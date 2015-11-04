<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Message;
use AppBundle\Form\MessageType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Message controller.
 *
 * @Route("/contact")
 */
class ContactController extends Controller
{
    /**
     * Displays a form to create a new Message entity.
     *
     * @Route("", name="contact_index")
     * @Method("GET")
     */
    public function newAction()
    {
        $message = new Message();

        if(null !== $clientId = $this->get('session')->get('client-id'))
        {
            if(null !== $client = $this->getDoctrine()->getRepository('AppBundle:Client')->find($clientId))
            {
                $message->setClient($client);
            }
        }

        $form   = $this->createCreateForm($message);

        return $this->render(':Contact:index.html.twig', array(
            'message' => $message,
            'form'    => $form->createView(),
        ));
    }

    /**
     * Creates a new Message entity.
     *
     * @Route("/", name="contact_create")
     * @Method("POST")
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function createAction(Request $request)
    {
        $message = new Message();
        $form = $this->createCreateForm($message);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            return $this->redirect($this->generateUrl('contact_confirmation', array('id' => $message->getId())));
        }

        return $this->render(':Contact/index.html.twig', array(
            'entity' => $message,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a confirmation for the stored Message entity.
     *
     * @Route("/{id}", name="contact_confirmation")
     * @Method("GET")
     *
     * @param int $id
     * @return array
     */
    public function confirmationAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        if(null === $message = $em->getRepository('AppBundle:Message')->find($id))
        {
            throw $this->createNotFoundException('Unable to find Contact request.');
        }

        return $this->render(':Contact:confirmation.html.twig', array(
            'message' => $message,
        ));
    }

    /**
     * Creates a form to create a Message entity.
     *
     * @param Message $message The Message entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Message $message)
    {
        $form = $this->createForm(new MessageType(), $message, array(
            'action' => $this->generateUrl('contact_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }
}
