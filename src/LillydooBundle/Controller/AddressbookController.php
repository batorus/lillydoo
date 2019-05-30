<?php

namespace LillydooBundle\Controller;

use LillydooBundle\Entity\Addressbook;
use LillydooBundle\Entity\Documents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use LillydooBundle\Form\AddressbookType;
use LillydooBundle\Form\DocumentsType;
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
        
        $paginator  = $this->get('knp_paginator');
        
        $pagination = $paginator->paginate(
                        $entities, /* query NOT result */
                        $request->query->getInt('page', 1)/*page number*/,
                        2/*limit per page*/
        );

        return $this->render('@Lillydoo/addressbook/index.html.twig', array(
            'entities' => $pagination,
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

        $entity = new Addressbook();
          
        $form = $this->createForm(AddressbookType::class, $entity);
        
        $form->handleRequest($request);
        
        $validator = $this->get('validator');
        $errors = $validator->validate($form);    
                
        if (count($errors) > 0) 
        {                    
            return $this->render('@Lillydoo/addressbook/new.html.twig', array(
                'entity' => $entity,
                'form' => $form->createView()
            ));
        }
     
        $em = $this->getDoctrine()->getManager();
        
        $entity->setFirstname($request->request->get('lillydoobundle_addressbook')['firstname']);   
        $entity->setLastname($request->request->get('lillydoobundle_addressbook')['lastname']);
        $entity->setStreet($request->request->get('lillydoobundle_addressbook')['street']);
        $entity->setNumber($request->request->get('lillydoobundle_addressbook')['number']);   
        
        $entity->setBirthday(new \DateTime($request->request->get('lillydoobundle_addressbook')['birthday']));
        
        $entity->setCountry($request->request->get('lillydoobundle_addressbook')['country']);   
        $entity->setPhonenumber($request->request->get('lillydoobundle_addressbook')['phonenumber']);
        
        $entity->setEmail($request->request->get('lillydoobundle_addressbook')['email']);
        $entity->setPicture($request->request->get('lillydoobundle_addressbook')['picture']); 

        $entity->setEnabled(1);
        $em->persist($entity);
       
        try{     
           
           $em->flush();
           
        }catch(\Doctrine\DBAL\Exception\UniqueConstraintViolationException  $e){           
            
           $this->container->get('session')->getFlashBag()->add("error", "The record already exists into the db!");
            
           return $this->redirect($this->generateUrl('addressbook_new'));
        };
              
        $this->container->get('session')->getFlashBag()->add("notice", "Record saved into the db!"); 
        
        return $this->redirect($this->generateUrl('addressbook'));    
              
    }

    
    /**
     * Displays a form to edit an existing medicament entity.
     *
     */
    public function editAction(Addressbook $addressbook)
    {
        $editForm = $this->createForm(AddressbookType::class, $addressbook);
        
        $uploadForm = $this->createForm(DocumentsType::class, new Documents());              
        $documents = $addressbook->getDocuments();
        
        if (!$documents) {
            throw $this->createNotFoundException('Unable to find Documents entity.');
        }
        
        $updateForm = array();
        $docs = array();
        foreach($documents as $document){
            if($document->getEnabled()==1){
                $docs[] = $document;
                $updateForm[] = $this->createForm(DocumentsType::class, $document)->createView();
            }
        }            
 
        return $this->render('@Lillydoo/addressbook/edit.html.twig', array(
            'entity' => $addressbook,
            'form' => $editForm->createView(),
            'documents'=>$docs,
            "uploadForm" =>$uploadForm->createView(),
            'updateForm'=>$updateForm,
        ));
    }
    
    public function uploadAction(Request $request, $id)
    { 
           
         $em = $this->getDoctrine()->getManager();
       
        $entity = $em->getRepository('LillydooBundle:Addressbook')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find entity.');
        }
      
        //$documents = $em->getRepository('AnomaliesBundle:Documents')->getRecords($id);
        $documents = $entity->getDocuments();
        if (!$documents) {
            throw $this->createNotFoundException('Unable to find Documents entity.');
        }
        
        $docs = array();
        $updateForm = array();       
        foreach($documents as $document){
            if($document->getEnabled() == 1){
                $docs[] = $document;
                $updateForm[] = $this->createForm(DocumentsType::class, $document)->createView();               
            }
        }

        
        $form = $this->createForm(AddressbookType::class, $entity);
        
        $uploadForm = $this->createForm( DocumentsType::class, new Documents());      
        $uploadForm->handleRequest($request);
        
        $validator = $this->get('validator');
        $errors = $validator->validate($uploadForm);  
           
        if (count($errors) > 0) 
        {                    
            return $this->render('@Lillydoo/addressbook/edit.html.twig', array(
                'entity' => $entity,
                'documents'=>$docs,                
                'form' => $form->createView(),
                'uploadForm'=>$uploadForm->createView(),
                'updateForm'=>$updateForm,              
                'errors' => $errors
            ));

        }
        
       // $em = $this->getDoctrine()->getManager(); 
        //(new FileUploader($request, $em, $this->container))->uploadAction($id, true);
         $this->get('application.file_uploader')->uploadAction($id, true);
        return $this->redirectToRoute('addressbook_edit',array('id'=>$id));
    }    
    
    public function updateAction(Request $request, int $id)
    {
     
        $em = $this->getDoctrine()->getManager();
       
        $entity = $em->getRepository('LillydooBundle:Addressbook')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Addressbook entity.');
        }
               
        $form = $this->createForm(AddressbookType::class, $entity);
              
        $form->handleRequest($request);
        $validator = $this->get('validator');
        $errors = $validator->validate($form);    
                
        if (count($errors) > 0) 
        {                     
           return $this->render('@Lillydoo/addressbook/edit.html.twig', array(
                                'entity' => $entity,
                                'form'   => $form->createView(),
                                'errors' => $errors
            ));
            
        }
        
        $em = $this->getDoctrine()->getManager();
        $entity->setFirstname($request->request->get('lillydoobundle_addressbook')['firstname']);   
        $entity->setLastname($request->request->get('lillydoobundle_addressbook')['lastname']);
        $entity->setStreet($request->request->get('lillydoobundle_addressbook')['street']);
        $entity->setNumber($request->request->get('lillydoobundle_addressbook')['number']);   
        
        $entity->setBirthday(new \DateTime($request->request->get('lillydoobundle_addressbook')['birthday']));
        
        $entity->setCountry($request->request->get('lillydoobundle_addressbook')['country']);   
        $entity->setPhonenumber($request->request->get('lillydoobundle_addressbook')['phonenumber']);
        
        $entity->setEmail($request->request->get('lillydoobundle_addressbook')['email']);
        $entity->setPicture($request->request->get('lillydoobundle_addressbook')['picture']); 

        $entity->setEnabled(1);

        try{     

             $em->flush();

        }catch(\Doctrine\DBAL\Exception  $e){           

             $this->container->get('session')->getFlashBag()->add("error", $e->getMessage());

             return $this->redirect($this->generateUrl('addressbook_new'));
        };


        $this->container->get('session')->getFlashBag()->add("notice", "Record saved into the db!"); 

        return $this->redirect($this->generateUrl('addressbook'));                          
    }

    /**
     * Deletes a addressbook entity.
     *
     */
    public function deleteAction(Request $request, int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('LillydooBundle:Addressbook')->find($id);
        
         try{     
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find entity.');
            };

        }catch(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException  $e){           
            
            //Logare exceptie aici
             $this->container->get('session')->getFlashBag()->add("error", "The entity could not be found!");           

            return $this->redirect($this->generateUrl('addressbook'));
        };
      
        //soft deletion
        $entity->setEnabled(0);   
        //$em->remove($entity);
        $em->flush();
        
        return $this->redirect($this->generateUrl('addressbook'));
    }
    ###############################################


    /**
     * Finds and displays an addressbook entity.
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

}
