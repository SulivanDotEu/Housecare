<?php

namespace Housecare\JobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Housecare\JobBundle\Form\JobType;
use Housecare\JobBundle\Entity\Job;
use Housecare\WorkersBundle\Entity\Worker;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Housecare\CalendarBundle\Entity\CalendarElement;
use Housecare\CalendarBundle\Form\CalendarElementType;

class JobController extends Controller {

   function __construct() {
      date_default_timezone_set("Europe/Brussels");
   }

   public static $SORT_BY_TYPE = "type";

   public function compareByType(Job $a, Job $b) {
      if ($a->getType() == $b->getType())
         return 0;
      return ($a->getType() < $b->getType()) ? -1 : 1;
   }

   /**
    * @ParamConverter("job", class="HousecareJobBundle:Job")
    * @ParamConverter("worker", class="HousecareWorkersBundle:Worker")
    */
   public function assignWorker2JobAction(Job $job, Worker $worker) {
      $job->setWorker($worker);
      $em = $this->getDoctrine()->getManager();
      $em->persist($job);
      $em->flush();
      return $this->redirect($this->generateUrl('housecare_job_read', array('id' => $job->getId())));
   }

   public function scheduleJobAction(Job $job) {
      $calendarElement = new CalendarElement();
      $job->setCalendarElement($calendarElement);
      $calendarElement->setOwner($job->getWorker());
      $calendarElement->setDelegate($job);
      $form = $this->createForm(new CalendarElementType(), $calendarElement);
      $request = $this->get('request');
      if ($request->getMethod() == 'POST') {
         $form->bind($request);
         if ($form->isValid()) {

            var_dump($job);
            $em = $this->getDoctrine()->getManager();
            $em->persist($calendarElement);
            $em->flush();
            $em->persist($job);
            $em->flush();
            return $this->redirect($this->generateUrl('housecare_job_list'));
         }
      }
      return $this->render('HousecareJobBundle:job:schedule.html.twig', array(
                  'form' => $form->createView(),
                  'entity' => $job
              ));
   }

   public function assignWorkerAction(Job $object) {
      $formBuilder = $this->createFormBuilder();
      $repository = $this->getDoctrine()
              ->getManager()
              ->getRepository('HousecareWorkersBundle:Worker');
      $workers = $repository->findAll();

      $temp = array();
      foreach ($workers as $worker) {
         $temp[$worker->getId()] = $worker->getFirstName() . " " . $worker->getLastName();
      }
      $choices = array('choices' => $temp);

//$listOfStatut = array('choices' => Worker::$listOfStatut);
// On ajoute les champs de l'entité que l'on veut à notre formulaire
      $formBuilder
              ->add('workers', 'choice', $choices);
      $form = $formBuilder->getForm();

      $request = $this->get('request');
      if ($request->getMethod() == 'POST') {
         $form->bind($request);
         if ($form->isValid()) {

            $dataForm = $form->getData();
            $idWorker = $dataForm['workers'];
            $worker = $repository->find($idWorker);
            $object->setWorker($worker);

            $em = $this->getDoctrine()->getManager();
            $em->persist($object);
            $em->flush();

            return $this->redirect($this->generateUrl('housecare_job_read', array('id' => $object->getId())));
         }
      }

      return $this->render('HousecareJobBundle:job:assign.html.twig', array(
                  'form' => $form->createView(),
                  'object' => $object
              ));
   }

   public function listAction($sort = null, $order = "ASC") {

      $repository = $this->getDoctrine()
              ->getManager()
              ->getRepository('HousecareJobBundle:Job');

// on récupère les workers
      $repositoryWorkers = $this->getDoctrine()
              ->getManager()
              ->getRepository('HousecareWorkersBundle:Worker');
      $workers = $repositoryWorkers->findAll();

      $objects = $repository->findAll();

      if (isset($sort)) {
         $comparator = $this->container->get('housecare.object_comparator');
         $comparator->sort($objects, $sort);
      }

      if ($order != "ASC")
         $objects = array_reverse($objects);

      return $this->render('HousecareJobBundle:job:list.html.twig', array('objects' => $objects, 'workers' => $workers));
   }

   public function createAction() {
      $objet = new Job();
      $form = $this->createForm(new JobType(), $objet);

      $request = $this->get('request');
      if ($request->getMethod() == 'POST') {
         $form->bind($request);

         if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($objet);
            $em->flush();
            return $this->redirect($this->generateUrl('housecare_job_read', array('id' => $objet->getId())));
         }
      }

      return $this->render('HousecareJobBundle:job:create.html.twig', array(
                  'form' => $form->createView()
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

//$object->setSubtype(Job::$listOfSubtypes[$object->getSubtype()]);
//$object->setType(Job::$listOfTypes[$object->getType()]);
//$object->setTimeNeeded(Job::$listOfTimeNeeded[$object->getTimeNeeded()]);
//$object->setThanksTo(Job::$listOfThanksTo[$object->getThanksTo()]);
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
