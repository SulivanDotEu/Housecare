<?php

namespace Housecare\JobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Housecare\JobBundle\Form\JobType;
use Housecare\JobBundle\Entity\Job;
use Housecare\CostumersBundle\Form\CostumersType;
use \Housecare\CostumersBundle\Entity\Costumers;
use Housecare\CalendarBundle\Controller\CalendarController;
use \Housecare\CalendarBundle\Entity\CalendarElement;
use Housecare\CalendarBundle\Form\CalendarElementType;

class JobCostumersController extends Controller {

   public static $SORT_BY_TYPE = "type";

   public function generateUrlForGettinfElementInfoAjax($id) {
      return $this->generateUrl("calendar_get_element", ['id' => $id]);
   }

   public function getCalendar() {
      $render = $this->container->get('housecare_calendar.render');
      /* @var $render \Housecare\CalendarBundle\CalendarRender\CalendarRender */
      $render->controller = $this;

      $repositoryJob = $this->getDoctrine()
              ->getManager()
              ->getRepository('HousecareJobBundle:Job');

      $elements = $repositoryJob->findAllByJobs();

      $render->setStartHour(7);
      $render->setEndHour(20);
      $render->init();

      foreach ($elements as $element) {
         $render->addCalendarElement($element);
      }

      $calendar = $render->render();
      return $calendar;
   }

   public function createAction() {
      date_default_timezone_set("Europe/Brussels");
      $objet = new Job();
      $objet->setCalendarElement(new CalendarElement());
      $objet->setCostumers(new Costumers());
      $form = $this->createForm(new JobType(), $objet);
      $countryManager = $this->container->get('housecare.CountryManager');
      $form->add('costumers', new CostumersType($countryManager));


      
      $form->add('worker', 'entity', array(
          'class' => 'HousecareWorkersBundle:Worker',
          'property' => 'fullName',
      ));
      $form->add('calendarElement', new CalendarElementType);
      
      


      $request = $this->get('request');
      if ($request->getMethod() == 'POST') {
         $form->bind($request);
         var_dump($objet);

         if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($objet);
            $em->flush();
            return $this->redirect($this->generateUrl('housecare_job_read', array('id' => $objet->getId())));
         }
      }


      $calendar = $this->getCalendar();

      return $this->render('HousecareJobBundle:jobCostumers:create.html.twig', array(
                  'form' => $form->createView(),
                  'calendar' => $calendar
              ));
   }

   public function deleteAction(Job $object) {
      if (!$object) {
         throw $this->createNotFoundException('Object not found');
      }

      $em = $this->getDoctrine()->getEntityManager();
      $em->remove($object);
      $em->flush();

      return $this->redirect($this->generateUrl('housecare_job_list'));
   }

   public function readAction(Job $object) {
      return $this->render('HousecareJobBundle:job:read.html.twig', array('object' => $object));
   }

   public function updateAction(Job $object) {
      $countryManager = $this->container->get('housecare.CountryManager');
      $form = $this->createForm(new JobType(), $object);
      $request = $this->getRequest();

      if ($request->getMethod() == 'POST') {
         $form->bind($request);
         if ($form->isValid()) {
            // On enregistre l'article
            $em = $this->getDoctrine()->getManager();
            $em->persist($object);

            $object->setSubtype(Job::$listOfSubtypes[$object->getSubtype()]);
            //$object->setType(Job::$listOfTypes[$object->getType()]);
            $object->setTimeNeeded(Job::$listOfTimeNeeded[$object->getTimeNeeded()]);
            $object->setThanksTo(Job::$listOfThanksTo[$object->getThanksTo()]);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info', 'update done');

            return $this->redirect($this->generateUrl('housecare_job_read', array('id' => $object->getId())));
         }
      }


      return $this->render('HousecareJobBundle:job:update.html.twig', array(
                  'form' => $form->createView(),
                  'object' => $object
              ));
   }

}
