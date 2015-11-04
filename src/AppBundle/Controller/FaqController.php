<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FaqController extends Controller
{
    /**
     * @Route("/faq", name="faq_index")
     */
    public function indexAction()
    {
        return $this->render(':Faq:index.html.twig', array(
        ));
    }
}
