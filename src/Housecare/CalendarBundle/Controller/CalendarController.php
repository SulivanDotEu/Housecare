<?php

namespace Housecare\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Housecare\CalendarBundle\Entity\CalendarElement;
use \Symfony\Component\HttpFoundation\Response;
use \Housecare\WorkersBundle\Entity\Worker;
use Housecare\CalendarBundle\Entity\Coordscp;
use \DateTime;
use Housecare\CalendarBundle\Form\CalendarElementType;
use \Housecare\CalendarBundle\CalendarPlugin\Odometer;

class CalendarController extends Controller {

   private $startHour = 7;
   private $endHour = 20;
   private $delatMinute = 20;

   public function getArrayId($year, $month, $day, $hour, $minutes, $idOwner) {
      $kmId = $year . '-' . $month . '-' . $day . '-' . $hour . '-' . $minutes . '-' . $idOwner;
      return $kmId;
   }

   public function getKmId($idOwner) {
      $date = $ce->getStartDate(); //->format('h');



      $year = '2013';
      $month = '08';
      $day = '19';
      $hour = strval($date->format('H'));
      $minutes = $date->format('i');
      //$idOwner = $ce->getOwner()->getId();

      if ($minutes >= 40 && $minutes < 60) {
         $minutes = '40';
      } else if ($minutes >= 20 && $minutes < 40) {
         $minutes = '20';
      } else {
         var_dump('COUCOU');
         $minutes = '00';
      }



      $kmId = $year . '-' . $month . '-' . $day . '-' . $hour . '-' . $minutes . '-' . $idOwner;
      return $kmId;
   }

   
   public function createIndice($hour, $minutes, $ownerId){
      if ($minutes >= 40 && $minutes < 60) {
         $minutes = '40';
      } else if ($minutes >= 20 && $minutes < 40) {
         $minutes = '20';
      } else {
         $minutes = '00';
      }
      return $ownerId.'-'.$hour.$minutes;
   }
   
   public function getDistanceByZipCode($zp1, $zp2) {
      static $resultat = array();
      if(isset($resultat[$zp1.'-'.$zp2])){
         echo 'raccourci';
         return $resultat[$zp1.'-'.$zp2];
      }
      
      $repositoryCoordscp = $this->getDoctrine()
              ->getManager()
              ->getRepository('HousecareCalendarBundle:Coordscp');

      $elements1 = $repositoryCoordscp->findByZip($zp1);
      if (is_array($elements1)) {
         $elements1 = $elements1[0];
      }
      $elements2 = $repositoryCoordscp->findByZip($zp2);
      if (is_array($elements2)) {
         $elements2 = $elements2[0];
      }
      
      $distance = $this->getDistance($elements1->getLat(), $elements1->getLng(), $elements2->getLat(), $elements2->getLng());
      
      $resultat[$zp1.'-'.$zp2] = $distance;
      
      return $distance;
      
   }


   public function getKmAction($zipCode) {
      $logger = $this->get('logger');
      $logger->info('CalendarController->getKmAction('.$zipCode.')');

      $repositoryJob = $this->getDoctrine()->getManager()->getRepository('HousecareJobBundle:Job');

      $elements = $repositoryJob->findAllByJobs();
      $repositoryCoordscp = $this->getDoctrine()->getManager()->getRepository('HousecareCalendarBundle:Coordscp');

      $coords = $repositoryCoordscp->findByZip($zipCode);
      if (is_array($coords)) {
         $coords = $coords[0];
      }
      // if coord null raise Exception
      // ON utilise le render pour récuperer la list des owner (pas de doublons)
      $render = $this->container->get('housecare_calendar.render');
      /* @var $render \Housecare\CalendarBundle\CalendarRender\CalendarRender */
      

      
      
      
      
      $odometer = new Odometer($repositoryCoordscp, 7, 20, $zipCode, $logger);
      $odometer->addCalendarElements($elements);
      $table = $odometer->getTableOfKm();
      $response = array();
      $response['state'] = true;
      $response['data'] = $table;
      $response['error'] = null;

      return new Response(json_encode($response));
   }

   public function generateUrlForGettinfElementInfoAjax($id) {
      return $this->generateUrl("calendar_get_element", ['id' => $id]);
   }

   public function findAllCalendarElement() {
      $repository = $this->getDoctrine()
              ->getManager()
              ->getRepository('HousecareJobBundle:Job');
   }

   public function testAction() {
      $repository = $this->getDoctrine()
              ->getManager()
              ->getRepository('HousecareJobBundle:Job');

      $repository2 = $this->getDoctrine()
              ->getManager()
              ->getRepository('HousecareCalendarBundle:CalendarElement');

      $list = $repository->findAllByJobs();

      return new Response(var_dump($list));
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

   public function indexAction() {

      $render = $this->container->get('housecare_calendar.render');
      /* @var $render \Housecare\CalendarBundle\CalendarRender\CalendarRender */
      $render->controller = $this;

      $repositoryJob = $this->getDoctrine()
              ->getManager()
              ->getRepository('HousecareJobBundle:Job');

      $elements = $repositoryJob->findAllByJobs();

      // parametre du render
      $render->setStartHour(7);
      $render->setEndHour(20);
      $render->init();

      foreach ($elements as $element) {
         $render->addCalendarElement($element);
      }

      $calendar = $render->render();

      return $this->render('HousecareCalendarBundle:calendar:overview.html.twig', array(
                  'calendar' => $calendar
              ));
   }

   public function getElementAction(CalendarElement $calendarElement) {
      $request = $this->getRequest();
      $form = $this->createForm(new CalendarElementType(), $calendarElement);

      //$request->isXmlHttpRequest();
      return $this->render('HousecareCalendarBundle:calendar:element_info.html.twig', ['entity' => $calendarElement,
                  'form' => $form->createView()]);
      return new Response("<h1>Hello World</p>");
   }

   public function listAction() {
      $repository = $this->getDoctrine()
              ->getManager()
              ->getRepository('HousecareCalendarBundle:CalendarElement');

      $elements = $repository->findAll();

      return $this->render('HousecareCalendarBundle:calendar:list.html.twig', array(
                  'elements' => $elements
              ));
   }

   public function readAction($id) {
      $repository = $this->getDoctrine()
              ->getManager()
              ->getRepository('HousecareCalendarBundle:CalendarElement');

      $calendarElement = $repository->find($id);


      // Puis modifiez la ligne du render comme ceci, pour prendre en compte l'article :
      return $this->render('HousecareCalendarBundle:calendar:read.html.twig', array(
                  'element' => $calendarElement
              ));
   }

   public function updateNoFormAction(\Symfony\Component\HttpFoundation\Request $request, CalendarElement $calendarElement) {
      $em = $this->getDoctrine()->getManager();
      $form = $this->createForm(new CalendarElementType(), $calendarElement);
      $form->submit($request);
      if ($form->isValid()) {
         $em->persist($calendarElement);
         $em->flush();

         return $this->redirect($this->generateUrl('housecare_calendar_index'));
      }
   }

   public function updateAction(CalendarElement $element) {
      // On utiliser le ArticleEditType
      $formBuilder = $this->createFormBuilder($element);
      $formBuilder
              ->add('startDate', 'datetime')
              ->add('endDate', 'datetime')
              ->add('color', 'text');
      $form = $formBuilder->getForm();

      $request = $this->getRequest();

      if ($request->getMethod() == 'POST') {
         $form->bind($request);

         if ($form->isValid()) {
            // On enregistre l'article
            $em = $this->getDoctrine()->getManager();
            $em->persist($element);
            $em->flush();

            // On définit un message flash
            $this->get('session')->getFlashBag()->add('info', 'Element bien modifié');

            return $this->redirect($this->generateUrl('housecare_calendar_read', array('id' => $element->getId())));
         }
      }

      return $this->render('HousecareCalendarBundle:calendar:update.html.twig', array(
                  'form' => $form->createView(),
                  'element' => $element
              ));
   }

   public function deleteAction(CalendarElement $element) {
// On crée un formulaire vide, qui ne contiendra que le champ CSRF
      // Cela permet de protéger la suppression d'article contre cette faille
      $form = $this->createFormBuilder()->getForm();

      $request = $this->getRequest();
      if ($request->getMethod() == 'POST') {
         $form->bind($request);

         if ($form->isValid()) {
            // On supprime l'article
            $em = $this->getDoctrine()->getManager();
            $em->remove($element);
            $em->flush();

            // On définit un message flash
            $this->get('session')->getFlashBag()->add('info', 'Element bien supprimé');

            // Puis on redirige vers l'accueil
            return $this->redirect($this->generateUrl('housecare_calendar_list'));
         }
      }

      // Si la requête est en GET, on affiche une page de confirmation avant de supprimer
      return $this->render('HousecareCalendarBundle:calendar:delete.html.twig', array(
                  'element' => $element,
                  'form' => $form->createView()
              ));
   }

   public function createAction() {
      date_default_timezone_set("Europe/Brussels");
      $calendarElement = new CalendarElement();

      $formBuilder = $this->createFormBuilder($calendarElement);
      $formBuilder
              ->add('startDate', 'datetime')
              ->add('endDate', 'datetime')
              ->add('color', 'text');
      $form = $formBuilder->getForm();

      // On récupère la requête
      $request = $this->get('request');

      // On vérifie qu'elle est de type POST
      if ($request->getMethod() == 'POST') {
         // On fait le lien Requête <-> Formulaire
         // À partir de maintenant, la variable $article contient les valeurs entrées dans le formulaire par le visiteur
         $form->bind($request);

         // On vérifie que les valeurs entrées sont correctes
         // (Nous verrons la validation des objets en détail dans le prochain chapitre)
         if ($form->isValid()) {
            // On l'enregistre notre objet $article dans la base de données
            $em = $this->getDoctrine()->getManager();
            $em->persist($calendarElement);
            $em->flush();

            // On redirige vers la page de visualisation de l'article nouvellement créé
            return $this->redirect($this->generateUrl('housecare_calendar_read', array('id' => $calendarElement->getId())));
         }
      }


      /*
       * return $this->render('HousecareCalendarBundle:calendar:create.html.twig', array(
        'form' => $form->createView(),
        ));
       * 
       */
      return $this->render('HousecareCalendarBundle:Calendar:create.html.twig', array(
                  'form' => $form->createView(),
              ));
   }

}
