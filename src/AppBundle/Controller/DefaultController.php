<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use DOMDocument;
use DOMNode;
use DOMXPath;

class DefaultController extends Controller
{

    const HEADER = 'header';
    const FOOTER = 'footer';
    const LANDSCAPE_CLASSNAME = 'landscape';
    const PORTRAIT = 'portrait';
    const PAGE_CLASSNAME = 'page';

    /**
     * @Route("/", name="index")
     */
    public function indexAction(Request $request)
    {
        $data = array();
        $form = $this->createFormBuilder($data)
            ->add('html_content', TextareaType::class, array(
                'attr' => array('cols' => '50', 'rows' => '15'),
                'label' => false
            ))
            ->add('generer', SubmitType::class, array(
                'label' => 'Generate !'
            ))
            ->getForm();

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            $data = $form->getData();

            $baseurl = $request->getScheme() . '://' . $request->getHttpHost();
            $pdfContent = $this->getContentPdf($data['html_content'], $baseurl, [
                'header-margin-top' => '20mm',
                'footer-margin-bottom' => '20mm',
                'margin-left' => '20mm',
                'margin-right' => '20mm',
            ]);

            return new Response(
                $pdfContent,
                200,
                array(
                    'Content-Type'          => 'application/pdf',
                    'Content-Disposition'   => 'attachment; filename="file.pdf"'
                )
            );
        }

        return $this->render('default/index.html.twig', array(
            'form' => $form->createView(),
        ));

    }

    /**
     * @Route("/htmltopdf", name="htmltopdf")
     */
    public function htmlToPdfAction(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            $baseurl = $request->getScheme() . '://' . $request->getHttpHost();

            $htmlContent = $request->request->get('html_content');

            $options = [
                'header-margin-top' => $request->request->get('header-margin-top', '15mm'),
                'footer-margin-bottom' => $request->request->get('footer-margin-bottom', '15mm'),
                'margin-left' => $request->request->get('margin-left', '10mm'),
                'margin-right' => $request->request->get('margin-right', '10mm')
            ];

            return new JsonResponse(array('pdf_content' => utf8_encode($this->getContentPdf($htmlContent, $baseurl, $options))));
        }
    }

    /**
     * Return the pdf content
     * @param $htmlContent
     * @param $baseurl
     * @return mixed
     */
    protected function getContentPdf($htmlContent, $baseurl, $optionsPdf)
    {
        $uniqId = uniqid();

        $htmlContent = utf8_decode($htmlContent);
        $htmlContent = $this->replaceHttps($htmlContent, $baseurl, $uniqId);

        $options = array(
            'load-error-handling' => 'ignore',
            'load-media-error-handling' => 'ignore',
        );

        $getHeaderResult = $this->getHeader($htmlContent, $uniqId);
        if($getHeaderResult != false){
            $htmlContent = $getHeaderResult;
            $options['header-html'] = $this->getTmpFilesDirectory($uniqId).'/header.html';
            $options['margin-top'] = $optionsPdf['header-margin-top'];
        }
        $getFooterResult = $this->getFooter($htmlContent, $uniqId);
        if($getFooterResult != false){
            $htmlContent = $getFooterResult;
            $options['footer-html'] = $this->getTmpFilesDirectory($uniqId).'/footer.html';
            $options['margin-bottom'] = $optionsPdf['footer-margin-bottom'];
        }
        if(isset($optionsPdf['margin-left'])){
            $options['margin-left'] = $optionsPdf['margin-left'];
        }
        if(isset($optionsPdf['margin-right'])){
            $options['margin-right'] = $optionsPdf['margin-right'];
        }

        $allPages = $this->getPages($htmlContent, $uniqId);

        $fs = new Filesystem();

        if(count($allPages) == 0){
            $pdfContent = $this->get('knp_snappy.pdf')->getOutputFromHtml($htmlContent, $options);
        }else{
            $pdfFileNames = array();
            $optionsLandscape = $options;
            $optionsLandscape['orientation'] = 'Landscape';
            $index = 0;
            foreach($allPages as $page){

                if($page['type'] == self::PORTRAIT){
                    $pdfContentPage = $this->get('knp_snappy.pdf')->getOutputFromHtml(file_get_contents($page['page']), $options);
                }else{
                    $pdfContentPage = $this->get('knp_snappy.pdf')->getOutputFromHtml(file_get_contents($page['page']), $optionsLandscape);
                }
                $fs->dumpFile($this->getTmpFilesDirectory($uniqId).'/page'.$index.'.pdf', $pdfContentPage);
                $pdfFileNames[] = $this->getTmpFilesDirectory($uniqId).'/page'.$index.'.pdf';

                $index++;
            }
            $this->mergePdf($pdfFileNames, $this->getTmpFilesDirectory($uniqId).'/final.pdf');

            $pdfContent = file_get_contents($this->getTmpFilesDirectory($uniqId).'/final.pdf');
        }

        return $pdfContent;
    }

    /**
     * Create footer file if <div id="footer"></div> exist
     * @param $html
     * @return bool|string
     */
    protected function getFooter($html, $uniqId)
    {
        // evite les erreurs sur la structure du html
        libxml_use_internal_errors(true);
        $doc = new DOMDocument();
        $doc->loadHTML($html);
        if($doc->getElementById('footer') != null){
            $xpath = new DOMXPath($doc);
            $result = '';
            foreach($xpath->evaluate('//div[@id="footer"]/node()') as $childNode) {
                $result .= $doc->saveXML($childNode);
            }

            $styleContent = $this->getStyleContent($doc);

            $txt = '<!DOCTYPE html><html><head><style>'.$styleContent.'</style></head><body style="margin:0; padding:0;"><div id="footer">'.$result.'</div></body></html>';

            // Creation of footer.html
            $fs = new Filesystem();
            $fs->dumpFile($this->getTmpFilesDirectory($uniqId).'/footer.html', utf8_decode(html_entity_decode($txt)));

            $divFooter = $doc->getElementById('footer');
            $divFooter->parentNode->removeChild($divFooter);
            return $doc->saveHTML();
        }else{
            return false;
        }
    }

    /**
     * Create header file if <div id="header"></div> exist
     * @param $html
     * @return bool|string
     */
    protected function getHeader($html, $uniqId)
    {
        // evite les erreurs sur la structure du html
        libxml_use_internal_errors(true);
        $doc = new DOMDocument();
        $doc->loadHTML($html);
        if($doc->getElementById('header') != null){
            $xpath = new DOMXPath($doc);
            $result = '';
            foreach($xpath->evaluate('//div[@id="header"]/node()') as $childNode) {
                $result .= $doc->saveXML($childNode);
            }

            $styleContent = $this->getStyleContent($doc);

            $txt = '<!DOCTYPE html><html><head><style>'.$styleContent.'</style></head><body style="margin:0; padding:0;"><div id="header">'.$result.'</div></body></html>';

            // Creation of header.html
            $fs = new Filesystem();
            $fs->dumpFile($this->getTmpFilesDirectory($uniqId).'/header.html', utf8_decode(html_entity_decode($txt)));

            $divHeader = $doc->getElementById('header');
            $divHeader->parentNode->removeChild($divHeader);
            return $doc->saveHTML();
        }else{
            return false;
        }
    }

    /**
     * Return an array where $key = type(portrait or landscape) and $value = HTML content of the page | if no page -> empty array
     * @param $html
     * @return array
     */
    protected function getPages($html, $uniqId)
    {
        // evite les erreurs sur la structure du html
        libxml_use_internal_errors(true);
        $doc = new DOMDocument();
        $doc->loadHTML($html);
        $xpath = new DOMXPath($doc);

        $styleContent = $this->getStyleContent($doc);

        $allPages = array();

        $index = 0;
        foreach($xpath->query("//div[contains(concat(' ', normalize-space(@class), ' '), ' ".self::PAGE_CLASSNAME." ')]") as $divPage) {
            $domPage = new DOMDocument();
            $domPage->appendChild($domPage->importNode($divPage, true));
            $xpathPage = new DOMXPath($domPage);

            if($xpathPage->evaluate("count(/div[contains(concat(' ', normalize-space(@class), ' '), ' ".self::LANDSCAPE_CLASSNAME." ')])") > 0){
                $type = self::LANDSCAPE_CLASSNAME;
            }else{
                $type = self::PORTRAIT;
            }
            $page = $doc->saveXML($divPage);
            $content = '<!DOCTYPE html><html><head><style>'.$styleContent.'</style></head><body style="margin:0; padding:0;">'.$page.'</body></html>';

            // Creation of footer.html
            $fs = new Filesystem();
            $fs->dumpFile($this->getTmpFilesDirectory($uniqId).'/page'.$index.'.html', utf8_decode(html_entity_decode($content)));

            $page = array('type' => $type, 'page' => $this->getTmpFilesDirectory($uniqId).'/page'.$index.'.html');
            $allPages[] = $page;
            $index++;
        }

        return $allPages;
    }

    /**
     * Wkhtmltopdf throws some errors with https ressources... so we replace them by copy - using curl because of https too
     * @param $html
     * @param $baseurl
     * @return mixed
     */
    protected function replaceHttps($html, $baseurl, $uniqId)
    {
        if(preg_match_all('!https://[a-z0-9\_\-\.\/\?\=\&\#]+\.(?:jpe?g|png|gif|svg|eot|woff2|woff|ttf)!Ui', $html, $matches)){
            $matches = array_pop($matches);
            foreach($matches as $key => $url){
                $explode = explode('.',$url);
                $extension = end($explode);

                $filename = 'file'.$key.'.'.$extension;

                $target = $this->getTmpFilesDirectory($uniqId).'/'.$filename;
                $ch = curl_init($url);
                $fp = fopen($target, "wb");

                curl_setopt($ch, CURLOPT_FILE, $fp);
                curl_setopt($ch, CURLOPT_HEADER, 0);

                curl_exec($ch);
                curl_close($ch);
                fclose($fp);

                $html = str_replace($url, $this->getTmpFilesDirectory($uniqId).'/'.$filename, $html);
            }
        }

        return $html;
    }

    /**
     * Return all CSS content of $doc
     * @param DOMDocument $doc
     * @return string
     */
    protected function getStyleContent(DOMDocument $doc)
    {
        $styleContent = '';

        $head = $doc->getElementsByTagName('head')->item(0);
        $links = $head->getElementsByTagName("link");
        foreach($links as $l) {
            if($l->getAttribute("rel") == "stylesheet") {
                $styleContent .= @file_get_contents($l->getAttribute("href"));
            }
        }

        $styles = $doc->getElementsByTagName('style');
        foreach($styles as $style){
            $styleContent .= $style->nodeValue;
        }

        return $styleContent;
    }

    protected function getDomInnerHtml(DOMNode $element)
    {
        $innerHTML = '';
        foreach($element->childNodes as $child){
            $innerHTML .= $element->ownerDocument->saveHTML($child);
        }
        return $innerHTML;
    }

    /**
     * Check if exist or create the tmp files directory
     * @return string
     */
    protected function getTmpFilesDirectory($uniqId, $relatif = false)
    {
        $date = date('Y-m-d');
        $directoryPath = $this->get('kernel')->getRootDir() . '/../web/tmp/'.$date.'/'.$uniqId;
        $directoryRelatifPath = '/tmp/'.$date.'/'.$uniqId;
        $fs = new Filesystem();

        if($fs->exists($directoryPath)){
            $fs->chmod($directoryPath, 0777, 0000, true);
        }else{
            $fs->mkdir($directoryPath);
        }

        return ($relatif)?$directoryRelatifPath:$directoryPath;
    }

    protected function mergePdf($files, $filename)
    {
        $pathToGs = $this->getParameter('path_to_gs_command');
        $files = implode(' ', $files);
        $cmd = $pathToGs.' -q -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -sOutputFile='.$filename.' '.$files.' 2>&1';
        return shell_exec($cmd);
    }

}
