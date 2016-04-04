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
            $htmlContent = $request->request->get('html_content');
            $pdfContent = $this->get('knp_snappy.pdf')->getOutputFromHtml(utf8_encode($htmlContent));
            return new JsonResponse(array('pdf_content' => utf8_encode($pdfContent)));
        }else{
            return $this->render('default/htmltopdf.html.twig');
        }
    }
}
