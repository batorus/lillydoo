<?php

namespace LillydooBundle\Controller;

use LillydooBundle\Entity\Addressbook;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Addressbook controller.
 *
 */
class AddressbookController extends Controller
{
  
    /**
     * Lists all addressbook entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LillydooBundle:Addressbook')->findBy(array('enabled'=>1));
        
        // $paginator  = $this->get('knp_paginator');
        
        //        $pagination = $paginator->paginate(
        //                        $query, /* query NOT result */
        //                        $request->query->getInt('page', 1)/*page number*/,
        //                        2/*limit per page*/
        //        );

        return $this->render('@Lillydoo/addressbook/index.html.twig', array(
            'entities' => $entities,
        ));       
    }

    /**
     * Creates a new addressbook entity.
     *
     */
    public function newAction(Request $request)
    {
        $addressbook = new Addressbook();
        $form = $this->createForm('LillydooBundle\Form\AddressbookType', $addressbook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($addressbook);
            $em->flush();

            return $this->redirectToRoute('addressbook_show', array('id' => $addressbook->getId()));
        }

        return $this->render('addressbook/new.html.twig', array(
            'addressbook' => $addressbook,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a addressbook entity.
     *
     */
    public function showAction(Addressbook $addressbook)
    {
        $deleteForm = $this->createDeleteForm($addressbook);

        return $this->render('addressbook/show.html.twig', array(
            'addressbook' => $addressbook,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing addressbook entity.
     *
     */
    public function editAction(Request $request, Addressbook $addressbook)
    {
        $deleteForm = $this->createDeleteForm($addressbook);
        $editForm = $this->createForm('LillydooBundle\Form\AddressbookType', $addressbook);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('addressbook_edit', array('id' => $addressbook->getId()));
        }

        return $this->render('addressbook/edit.html.twig', array(
            'addressbook' => $addressbook,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a addressbook entity.
     *
     */
    public function deleteAction(Request $request, Addressbook $addressbook)
    {
        $form = $this->createDeleteForm($addressbook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($addressbook);
            $em->flush();
        }

        return $this->redirectToRoute('addressbook_index');
    }

    /**
     * Creates a form to delete a addressbook entity.
     *
     * @param Addressbook $addressbook The addressbook entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Addressbook $addressbook)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('addressbook_delete', array('id' => $addressbook->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
