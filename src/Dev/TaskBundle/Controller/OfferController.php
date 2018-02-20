<?php

namespace Dev\TaskBundle\Controller;

use Dev\TaskBundle\Entity\Offer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Offer controller.
 *
 * @Route("offer")
 */
class OfferController extends Controller
{
    /**
     * Lists all offer entities.
     *
     * @Route("/", name="offer_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $offers = $em->getRepository('DevTaskBundle:Offer')->findAll();

        return $this->render('offer/index.html.twig', array(
            'offers' => $offers,
        ));
    }

    /**
     * Creates a new offer entity.
     *
     * @Route("/new", name="offer_new")
     * @Method({"GET", "POST"})
     */
	 
    public function newAction(Request $request)
    {
        $offer = new Offer();
        $form = $this->createForm('Dev\TaskBundle\Form\OfferType', $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($offer);
            $em->flush($offer);

            return $this->redirectToRoute('offer_show', array('id' => $offer->getId()));
        }

        return $this->render('offer/new.html.twig', array(
            'offer' => $offer,
            'form' => $form->createView(),
        ));
    }
	/*
	public function newAction()
    {		
		$response = array();
		$response['application_id'] = 2;
		$response['country'] = 'GB';
		$response['payout'] = 5;
		$response['name'] = 'Casino';
		$response['platform'] = 'IOS';
	
		$offer = new Offer();
        $offer->setApplicationId($response['application_id']);
		$offer->setCountry($response['country']);
		$offer->setPayout($response['payout']);
		$offer->setName($response['name']);
		$offer->setPlatform($response['platform']);
        $em = $this->getDoctrine()->getManager();
        $em->persist($offer);
        $em->flush();
        return new Response('Offer created!');
    }*/
	
	/**
     * Creates a new offer entity.
     *
     * @Route("/newrow", name="offer_newrow")
     * @Method({"GET", "POST"})
     */
	public function addrowAction()
    {		
		$response = array();
		$response['application_id'] = 2;
		$response['country'] = 'GB';
		$response['payout'] = 5;
		$response['name'] = 'Casino';
		$response['platform'] = 'IOS';
	
		$offer = new Offer();
        $offer->setApplicationId($response['application_id']);
		$offer->setCountry($response['country']);
		$offer->setPayout($response['payout']);
		$offer->setName($response['name']);
		$offer->setPlatform($response['platform']);
        $em = $this->getDoctrine()->getManager();
        $em->persist($offer);
        $em->flush();
        return new Response('Offer created!');
    }

    /**
     * Finds and displays a offer entity.
     *
     * @Route("/{id}", name="offer_show")
     * @Method("GET")
     */
    public function showAction(Offer $offer)
    {
        $deleteForm = $this->createDeleteForm($offer);

        return $this->render('offer/show.html.twig', array(
            'offer' => $offer,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing offer entity.
     *
     * @Route("/{id}/edit", name="offer_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Offer $offer)
    {
        $deleteForm = $this->createDeleteForm($offer);
        $editForm = $this->createForm('Dev\TaskBundle\Form\OfferType', $offer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('offer_edit', array('id' => $offer->getId()));
        }

        return $this->render('offer/edit.html.twig', array(
            'offer' => $offer,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a offer entity.
     *
     * @Route("/{id}", name="offer_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Offer $offer)
    {
        $form = $this->createDeleteForm($offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($offer);
            $em->flush($offer);
        }

        return $this->redirectToRoute('offer_index');
    }

    /**
     * Creates a form to delete a offer entity.
     *
     * @param Offer $offer The offer entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Offer $offer)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('offer_delete', array('id' => $offer->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
