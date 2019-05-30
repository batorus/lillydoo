<?php

namespace LillydooBundle\Controller;

use LillydooBundle\Entity\Addressbook;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use LillydooBundle\Form\AddressbookType;

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
    
    ####################################################
     /**
     * Creates a new addressbook entity.
     *
     */
    public function newAction()
    {
        $entity = new Addressbook();
        $form = $this->createForm(AddressbookType::class, $entity);
     
        return $this->render('@Lillydoo/addressbook/new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }
    
    
   ########################################## Data is sent from New #####################
    public function createAction(Request $request)
    {

        $entity = new Medicament();
          
        $form = $this->createForm(new MedicamentType(), $entity);
        
        $form->handleRequest($request);
        
        $validator = $this->get('validator');
        $errors = $validator->validate($form);    
                
        if (count($errors) > 0) 
        {          
           
            return $this->render('MedicalsystemBundle:Medicament:new.html.twig', array(
                'entity' => $entity,
                'form' => $form->createView()
            ));

        }
     
        $em = $this->getDoctrine()->getManager();
        $entity->setName($request->request->get('medicalsystembundle_medicament')['name']);   
        $entity->setNumber($request->request->get('medicalsystembundle_medicament')['number']);
        $entity->setType($request->request->get('medicalsystembundle_medicament')['type']);
        $entity->setDetails($request->request->get('medicalsystembundle_medicament')['details']);   
        
        $entity->setDatecreated(new \DateTime($request->request->get('medicalsystembundle_medicament')['datecreated']));
        $entity->setExpirationdate(new \DateTime($request->request->get('medicalsystembundle_medicament')['expirationdate']));
        
        $entity->setUses($request->request->get('medicalsystembundle_medicament')['uses']);   
        $entity->setSideeffects($request->request->get('medicalsystembundle_medicament')['sideeffects']);
        $entity->setPrecautions($request->request->get('medicalsystembundle_medicament')['precautions']);
        $entity->setInteractions($request->request->get('medicalsystembundle_medicament')['interactions']);   
        $entity->setOverdose($request->request->get('medicalsystembundle_medicament')['overdose']);
        $entity->setStorage($request->request->get('medicalsystembundle_medicament')['storage']);
        $entity->setEnabled(1);
        $em->persist($entity);
       
        try{     
           
           $em->flush();
           
        }catch(\Doctrine\DBAL\Exception\UniqueConstraintViolationException  $e){           
            
           $this->container->get('session')->getFlashBag()->add("error", "L'enregistrement existe déjà dans la base de données!");
            
           return $this->redirect($this->generateUrl('medicament_new'));
        };
              
        $this->container->get('session')->getFlashBag()->add("notice", "Enregistrement ajouté avec succès!"); 
        
        return $this->redirect($this->generateUrl('medicament'));    
              
    }

    
    /**
     * Displays a form to edit an existing medicament entity.
     *
     */
    public function editAction(Medicament $medicament)
    {
        $editForm = $this->createForm(new MedicamentType(), $medicament);
 
        return $this->render('MedicalsystemBundle:Medicament:edit.html.twig', array(
            'entity' => $medicament,
            'form' => $editForm->createView()
        ));
    }
    
    
    public function updateAction(Request $request, $id)
    {
     
        $em = $this->getDoctrine()->getManager();
       
        $entity = $em->getRepository('MedicalsystemBundle:Medicament')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Medicament entity.');
        }
               
        $form = $this->createForm(new MedicamentType(), $entity);
              
        $form->handleRequest($request);
        $validator = $this->get('validator');
        $errors = $validator->validate($form);    
                
        if (count($errors) > 0) 
        {                     
           return $this->render('MedicalsystemBundle:Medicament:edit.html.twig', array(
                                'entity' => $entity,
                                'form'   => $form->createView(),
                                'errors' => $errors
            ));
            
        }
        
        $em = $this->getDoctrine()->getManager();
        $entity->setName($request->request->get('medicalsystembundle_medicament')['name']);   
        $entity->setNumber($request->request->get('medicalsystembundle_medicament')['number']);
        $entity->setType($request->request->get('medicalsystembundle_medicament')['type']);
        $entity->setDetails($request->request->get('medicalsystembundle_medicament')['details']);   
        
        $entity->setDatecreated(new \DateTime($request->request->get('medicalsystembundle_medicament')['datecreated']));
        $entity->setExpirationdate(new \DateTime($request->request->get('medicalsystembundle_medicament')['expirationdate']));
        
        $entity->setUses($request->request->get('medicalsystembundle_medicament')['uses']);   
        $entity->setSideeffects($request->request->get('medicalsystembundle_medicament')['sideeffects']);
        $entity->setPrecautions($request->request->get('medicalsystembundle_medicament')['precautions']);
        $entity->setInteractions($request->request->get('medicalsystembundle_medicament')['interactions']);   
        $entity->setOverdose($request->request->get('medicalsystembundle_medicament')['overdose']);
        $entity->setStorage($request->request->get('medicalsystembundle_medicament')['storage']);
        $entity->setEnabled(1);

        try{     

             $em->flush();

        }catch(\Doctrine\DBAL\Exception\UniqueConstraintViolationException  $e){           

             $this->container->get('session')->getFlashBag()->add("error", "L'enregistrement existe déjà dans la base de données!");

             return $this->redirect($this->generateUrl('medicament_new'));
        };


        $this->container->get('session')->getFlashBag()->add("notice", "Enregistrement ajouté avec succès!"); 

        return $this->redirect($this->generateUrl('medicament'));          
                  
    }

    /**
     * Deletes a medicament entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MedicalsystemBundle:Medicament')->find($id);
        
         try{     

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find entity.');
            };

        }catch(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException  $e){           
            
            //Logare exceptie aici
            // $this->container->get('session')->getFlashBag()->add("error", "L'enregistrement existe déjà dans la base de données!");           
            //            echo "<pre>";
            //            print_r($e->getTraceAsString());
            //            die();
            return $this->redirect($this->generateUrl('medicament'));
        };

       
        //soft deletion
        $entity->setEnabled(0);   
        //$em->remove($entity);
        $em->flush();
        
        return $this->redirect($this->generateUrl('medicament'));
    }
    ###############################################
    
    

    /**
     * Creates a new addressbook entity.
     *
     */
//    public function newAction(Request $request)
//    {
//        $addressbook = new Addressbook();
//        $form = $this->createForm('LillydooBundle\Form\AddressbookType', $addressbook);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($addressbook);
//            $em->flush();
//
//            return $this->redirectToRoute('addressbook_show', array('id' => $addressbook->getId()));
//        }
//
//        return $this->render('addressbook/new.html.twig', array(
//            'addressbook' => $addressbook,
//            'form' => $form->createView(),
//        ));
//    }

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
//    public function editAction(Request $request, Addressbook $addressbook)
//    {
//        $deleteForm = $this->createDeleteForm($addressbook);
//        $editForm = $this->createForm('LillydooBundle\Form\AddressbookType', $addressbook);
//        $editForm->handleRequest($request);
//
//        if ($editForm->isSubmitted() && $editForm->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('addressbook_edit', array('id' => $addressbook->getId()));
//        }
//
//        return $this->render('addressbook/edit.html.twig', array(
//            'addressbook' => $addressbook,
//            'edit_form' => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }

    /**
     * Deletes a addressbook entity.
     *
     */
//    public function deleteAction(Request $request, Addressbook $addressbook)
//    {
//        $form = $this->createDeleteForm($addressbook);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($addressbook);
//            $em->flush();
//        }
//
//        return $this->redirectToRoute('addressbook_index');
//    }

    /**
     * Creates a form to delete a addressbook entity.
     *
     * @param Addressbook $addressbook The addressbook entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
//    private function createDeleteForm(Addressbook $addressbook)
//    {
//        return $this->createFormBuilder()
//            ->setAction($this->generateUrl('addressbook_delete', array('id' => $addressbook->getId())))
//            ->setMethod('DELETE')
//            ->getForm()
//        ;
//    }
}
