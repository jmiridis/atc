<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Transfer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PricesController extends Controller
{
    /**
     * @Route("/prices", name="price_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $qb = $em->getRepository('AppBundle:Transfer')->createQueryBuilder('t')
            ->where('t.isActive = true')
        ;

        $destinations = array();
        $prices       = array();
        $js_prices    = array();

        /** @var Transfer $transfer */
        foreach($qb->getQuery()->getResult() as $transfer)
        {
            $pax = $transfer->getMinPax() . '-' . $transfer->getMaxPax();
            $rt  = $transfer->getRoundTrip();
            $id  = $transfer->getDestination()->getId();

            $destinations[$id] = $transfer->getDestination();
            $prices[$id][$pax][$rt] = $transfer->getPrice();
            $js_prices[$id.'|'.$pax.'|'.$rt] = $transfer->getPrice();
        }


        // replace this example code with whatever you need
        return $this->render('Price/index.html.twig', array(
            'destinations' => $destinations,
            'js_prices'    => $js_prices,
            'prices'       => $prices

        ));
    }
}
