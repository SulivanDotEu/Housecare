<?php

namespace Housecare\WorkersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Housecare\WorkersBundle\Entity;
use Housecare\WorkersBundle\Entity\Worker;
use Housecare\WorkersBundle\Form\WorkerType;

class WorkerController extends Controller {

   public function indexAction() {
      $repository = $this->getDoctrine()
              ->getManager()
              ->getRepository('HousecareWorkersBundle:Worker');
      $objects = $repository->findAll();

      // Puis modifiez la ligne du render comme ceci, pour prendre en compte nos articles :
      return $this->render('HousecareWorkersBundle:workers:index.html.twig', array(
                  'workers' => $objects));
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

   public function readAction(Worker $object) {
      // Puis modifiez la ligne du render comme ceci, pour prendre en compte l'article :
      return $this->render('HousecareWorkersBundle:workers:read.html.twig', array(
                  'worker' => $object
              ));
   }

   public function updateAction(Worker $object) {

      $form = $this->createForm(new WorkerType(), $object);
      $request = $this->getRequest();

      if ($request->getMethod() == 'POST') {
         $form->bind($request);
         if ($form->isValid()) {
            // On enregistre l'article
            $em = $this->getDoctrine()->getManager();
            $em->persist($object);

            $em->flush();
            $this->get('session')->getFlashBag()->add('info', 'update done');

            return $this->redirect($this->generateUrl('housecare_workers_read', array('id' => $object->getId())));
         }
      }


      return $this->render('HousecareWorkersBundle:workers:create.html.twig', array(
                  'form' => $form->createView(),
                  'object' => $object
              ));
      
      
      
      
      $finder = Entity\WorkerRepository::getInstance();
      $object = $finder->getObjectById($id);

      return $this->render('HousecareWorkersBundle:workers:edit.html.twig', array(
                  'worker' => $object
              ));
   }

   public function deleteAction(Worker $id) {
      if (!$object) {
         throw $this->createNotFoundException('Object not found');
      }

      $em = $this->getDoctrine()->getEntityManager();
      $em->remove($object);
      $em->flush();

      return $this->redirect($this->generateUrl('housecare_workers_list'));

   }


   public function createAction() {
      date_default_timezone_set("Europe/Brussels");
      $objet = new Worker();
      $form = $this->createForm(new WorkerType(), $objet);

      $request = $this->get('request');
      if ($request->getMethod() == 'POST') {
         $form->bind($request);
         if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($objet);
            $em->flush();
            return $this->redirect($this->generateUrl('housecare_workers_read', array('id' => $objet->getId())));
         }
      }

      return $this->render('HousecareWorkersBundle:workers:create.html.twig', array(
                  'form' => $form->createView()
              ));
   }

}
