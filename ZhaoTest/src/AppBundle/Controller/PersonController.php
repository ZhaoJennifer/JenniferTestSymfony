<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TDPerson;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PersonController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function insertionPrenom(Request $request)
    {
      $enPerson= new TDPerson();

    $form = $this->createFormBuilder($enPerson)
      ->add('prenom')
      ->add('save', SubmitType::class, array('label' => 'Soumettre'))
      ->getForm();

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {

      $em = $this->getDoctrine()->getManager();
      $em->persist($enPerson);
      $em->flush();

      return $this->render('created.html.twig');
    }

    return $this->render('create.html.twig', array('form' => $form->createView()));
    }

    /**
   * @Route("/viewUsers", name="viewUsers")
   */
  public function viewUsers(){

    $users = $this->getDoctrine()->getManager();
    $repo = $this->getDoctrine()->getRepository('AppBundle:TDPerson');

    $query = $repo->createQueryBuilder('p')
    ->orderBy('p.prenom', 'ASC')
    ->getQuery();

    $liste = $query->getResult();

    return $this->render('/showAllUsers.html.twig', array('liste' => array_reverse($liste)));
  }

}
