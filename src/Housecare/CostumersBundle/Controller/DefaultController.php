<?php

namespace Housecare\CostumersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Housecare\CostumersBundle\Entity\Costumers;
use Housecare\CostumersBundle\Form\CostumersType;

class DefaultController extends Controller {

   public function indexAction($name) {
      return $this->render('HousecareCostumersBundle:Default:index.html.twig', array('name' => $name));
   }

   public function listAction() {
      $repository = $this->getDoctrine()
              ->getManager()
              ->getRepository('HousecareCostumersBundle:Costumers');

      $objects = $repository->findAll();
      return $this->render('HousecareCostumersBundle:Default:list.html.twig', array('objects' => $objects));
   }

   public function createAction() {
      $countryManager = $this->container->get('housecare.CountryManager');
      date_default_timezone_set("Europe/Brussels");
      $objet = new Costumers();
      $form = $this->createForm(new CostumersType($countryManager), $objet);

      $request = $this->get('request');
      if ($request->getMethod() == 'POST') {
         $form->bind($request);
         if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($objet);
            $em->flush();
            return $this->redirect($this->generateUrl('housecare_costumers_read', array('id' => $objet->getId())));
         }
      }

      return $this->render('HousecareCostumersBundle:Default:create.html.twig', array(
                  'form' => $form->createView()
              ));
   }

   public function deleteAction() {
      
   }

   public function readAction(Costumers $object) {
      return $this->render('HousecareCostumersBundle:Default:read.html.twig', array('object' => $object));
   }

   public function updateAction(Costumers $object) {
      $countryManager = $this->container->get('housecare.CountryManager');
      $form = $this->createForm(new CostumersType($countryManager), $object);
      $request = $this->getRequest();

      if ($request->getMethod() == 'POST') {
         $form->bind($request);
         if ($form->isValid()) {
            // On enregistre l'article
            $em = $this->getDoctrine()->getManager();
            $em->persist($object);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info', 'Article bien modifié');

            return $this->redirect($this->generateUrl('housecare_costumers_read', array('id' => $object->getId())));
         }
      }


      return $this->render('HousecareCostumersBundle:Default:update.html.twig', array(
                  'form' => $form->createView(),
                  'object' => $object
              ));

   }

}
