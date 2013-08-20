<?php

namespace Housecare\WorkersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Housecare\WorkersBundle\Entity;

class WorkerController extends Controller {

   public function indexAction() {
      $dal = Entity\WorkerRepository::getInstance();
      /* @var $dal Entity\WorkerRepository */
      $workers = $dal->getAllObjects();

      // Puis modifiez la ligne du render comme ceci, pour prendre en compte nos articles :
      return $this->render('HousecareWorkersBundle:workers:index.html.twig', array(
                  'workers' => $workers, 'test' => $workers));
   }

   public function menuAction($nombre) { // Ici, nouvel argument $nombre, on l'a transmis via le render() depuis la vue
      // On fixe en dur une liste ici, bien entendu par la suite on la récupérera depuis la BDD !
      // On pourra récupérer $nombre articles depuis la BDD,
      // avec $nombre un paramètre qu'on peut changer lorsqu'on appelle cette action
      $liste = array(
          array('id' => 2, 'titre' => 'Mon dernier weekend !'),
          array('id' => 5, 'titre' => 'Sortie de Symfony2.1'),
          array('id' => 9, 'titre' => 'Petit test')
      );

      return $this->render('HousecareWorkersBundle:workers:menu.html.twig', array(
                  'liste_articles' => $liste // C'est ici tout l'intérêt : le contrôleur passe les variables nécessaires au template !
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

   public function updateAction($id) {

      $finder = Entity\WorkerRepository::getInstance();
      $object = $finder->getObjectById($id);
     
      return $this->render('HousecareWorkersBundle:workers:edit.html.twig', array(
                  'worker' => $object
              ));
   }

   public function deleteAction($id) {


      // Puis modifiez la ligne du render comme ceci, pour prendre en compte l'article :
      return $this->render('HousecareWorkersBundle:workers:read.html.twig', array(
                  'worker' => $object
              ));
   }

   public function processAction() {
      $request = $this->getRequest();
      $id = $request->request->get('id');
      if(isset($id)){
         $worker = Entity\WorkerRepository::getInstance();
         $worker = $worker->getObjectById($id);
      } else {
         $worker = new Entity\Worker();
      }
      $worker->setFirstName($request->request->get('first_name'));
      $worker->setLastName($request->request->get('last_name'));
      $worker->setZipCode($request->request->get('zip_code'));
      $worker->setPhone($request->request->get('phone'));
      $worker->setOrder($request->request->get('order'));
      $worker->setNote($request->request->get('note'));
      $worker->setStatut($request->request->get('statut'));
      $worker->setEmail($request->request->get('email'));
      
      $dal = Entity\WorkerRepository::getInstance();
      if(isset($id)){
         $dal->update($worker);
      } else {
         $dal->create($worker);
      }

      $url = $this->generateUrl('housecare_workers_index');


      // Puis modifiez la ligne du render comme ceci, pour prendre en compte l'article :
      return $this->redirect($url);
   }

   public function createAction() {

      // Puis modifiez la ligne du render comme ceci, pour prendre en compte l'article :
      return $this->render('HousecareWorkersBundle:workers:create.html.twig', array(
                  'article' => null
              ));
   }

}
