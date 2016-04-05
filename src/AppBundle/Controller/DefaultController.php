<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{

    /**
     * @Route("/htmltopdf", name="htmltopdf")
     */
    public function htmlToPdfAction(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            $baseurl = $request->getScheme() . '://' . $request->getHttpHost();

            $htmlContent = utf8_decode($request->request->get('html_content'));
            $htmlContent = $this->replaceHttps($htmlContent, $baseurl);
            $pdfContent = $this->get('knp_snappy.pdf')->getOutputFromHtml($htmlContent);
            return new JsonResponse(array('pdf_content' => utf8_encode($pdfContent)));
        }else{
            return $this->render('default/htmltopdf.html.twig');
        }
    }

    protected function replaceHttps($html, $baseurl)
    {
        if(preg_match_all('!https://[a-z0-9\-\.\/]+\.(?:jpe?g|png|gif|svg)!Ui', $html, $matches)){
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
