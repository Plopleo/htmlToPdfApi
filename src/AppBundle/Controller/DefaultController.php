<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use DOMDocument;
use DOMXPath;

class DefaultController extends Controller
{

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
                'label' => 'Générer le pdf !'
            ))
            ->getForm();

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            $data = $form->getData();

            $baseurl = $request->getScheme() . '://' . $request->getHttpHost();
            $pdfContent = $this->getContentPdf($data['html_content'], $baseurl);

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

            return new JsonResponse(array('pdf_content' => utf8_encode($this->getContentPdf($htmlContent, $baseurl))));
        }
    }

    protected function getContentPdf($htmlContent, $baseurl)
    {
        $htmlContent = utf8_decode($htmlContent);
        $htmlContent = $this->replaceHttps($htmlContent, $baseurl);

        $options = array(
            'load-error-handling' => 'ignore',
            'load-media-error-handling' => 'ignore',
        );

        $getHeaderResult = $this->getHeader($htmlContent);
        if($getHeaderResult != false){
            $htmlContent = $getHeaderResult;
            $options['header-html'] = $this->get('kernel')->getRootDir().'/../web/tmp/header.html';
            $options['margin-top'] = '20mm';
        }
        $getFooterResult = $this->getFooter($htmlContent);
        if($getFooterResult != false){
            $htmlContent = $getFooterResult;
            $options['footer-html'] = $this->get('kernel')->getRootDir().'/../web/tmp/footer.html';
            $options['margin-bottom'] = '20mm';
        }
        $pdfContent = $this->get('knp_snappy.pdf')->getOutputFromHtml($htmlContent, $options);
        return $pdfContent;
    }

    protected function getFooter($html)
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
            $styleContent = '';
            $styles = $doc->getElementsByTagName('style');
            foreach($styles as $style){
                $styleContent .= $style->nodeValue;
            }

            $txt = '<html><head><style>'.$styleContent.'</style></head><body><div id="footer">'.$result.'</div></body></html>';
            file_put_contents($this->get('kernel')->getRootDir().'/../web/tmp/footer.html', utf8_decode(html_entity_decode($txt)));

            $divFooter = $doc->getElementById('footer');
            $divFooter->parentNode->removeChild($divFooter);
            return $doc->saveHTML();
        }else{
            return false;
        }
    }

    protected function getHeader($html)
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
            $styleContent = '';
            $styles = $doc->getElementsByTagName('style');
            foreach($styles as $style){
                $styleContent .= $style->nodeValue;
            }

            $txt = '<html><head><style>'.$styleContent.'</style></head><body><div id="header">'.$result.'</div></body></html>';
            file_put_contents($this->get('kernel')->getRootDir().'/../web/tmp/header.html', utf8_decode(html_entity_decode($txt)));

            $divHeader = $doc->getElementById('header');
            $divHeader->parentNode->removeChild($divHeader);
            return $doc->saveHTML();
        }else{
            return false;
        }
    }

    protected function replaceHttps($html, $baseurl)
    {
        if(preg_match_all('!https://[a-z0-9\-\.\/\?\=\&\#]+\.(?:jpe?g|png|gif|svg|eot|woff|ttf)!Ui', $html, $matches)){
            $matches = array_pop($matches);
            foreach($matches as $key => $url){
                $explode = explode('.',$url);
                $extension = end($explode);

                $source = $url;
                $target = $this->get('kernel')->getRootDir() . '/../web/tmp/file'.$key.'.'.$extension;
                $ch = curl_init($source);
                $fp = fopen($target, "wb");

                curl_setopt($ch, CURLOPT_FILE, $fp);
                curl_setopt($ch, CURLOPT_HEADER, 0);

                curl_exec($ch);
                curl_close($ch);
                fclose($fp);

                $html = str_replace($url, $baseurl.'/tmp/file'.$key.'.'.$extension, $html);
            }
        }

        return $html;
    }
}
