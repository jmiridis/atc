<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/backend/reservation")
 */
class ReservationBackendController extends Controller
{
    /**
     * @Route("", name="backend_reservation_index")
     */
    public function indexAction()
    {
        // replace this example code with whatever you need
        return $this->render(':Reservation:index.html.twig', array(
        ));
    }

    /**
     * @Route("/reservation2/new", name="reservation_new2")
     */
    public function newAction()
    {
        // replace this example code with whatever you need
        return $this->render(':Reservation:new.html.twig', array(
        ));
    }

}
