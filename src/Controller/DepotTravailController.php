<?php

namespace App\Controller;

use App\Entity\DepotTravail;
use App\Entity\Travail;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class DepotTravailController extends AbstractController {
    private $globalRequest;
    private $entityManager;
    private $doctrine;
     /**
     * @Route("/depotTravail/{travail_code}",name="depotTravail")
     */
    public function template(Request $request,PersistenceManagerRegistry $doctrine,$travail_code) {
        $this->globalRequest = $request;
        $this->doctrine = $doctrine;
        $this->entityManager = $this->doctrine->getManager();
        $form = $this->handleForm($travail_code);
        if($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('Alltravail',["categorie_code" => $this->getCategory($travail_code)]);
        }
        return $this->render("depot.html.twig",[
            "form" => $form->createView()
        ]);
    }
    public function handleForm($travail_code) {
        $user = $this->doctrine->getRepository(User::class)->findOneBy(["username" => $this->globalRequest->cookies->get("username")]);
        $depot = $this->doctrine->getRepository(DepotTravail::class)->findOneBy(["user" => $user, "travail" => $travail_code]);
        if($depot) {
            return $this->edit($depot);
        }
        return $this->add($user,$travail_code);
    }
    public function getCategory($travail_code) {
        $travail = $this->doctrine->getRepository(Travail::class)->findOneBy(["id" => $travail_code]);
        return $travail->getCategorie()->getId(); 
    }
    public function edit($depot) {
        $form = $this->createFormBuilder($depot)
        ->add('titre',TextType::class)
        ->add('description',TextType::class)
        ->add('save',SubmitType::class,["label" => "edit Depot"])
        ->getForm();
        $form->handleRequest($this->globalRequest);
        if($form->isSubmitted() && $form->isValid()) {
            $depot = $form->getData();
            $this->entityManager->flush();
        }
        return $form;
    }
    public function add($user,$travail_code) {
        $form = $this->createFormBuilder(new DepotTravail())
        ->add('titre',TextType::class)
        ->add('description',TextType::class)
        ->add('save',SubmitType::class,["label" => "Depot"])
        ->getForm();
        $form->handleRequest($this->globalRequest);
        if($form->isSubmitted() && $form->isValid()) {
            $depot = $form ->getData();
            $depot->setUser($user);
            $depot->setTravail($this->getTravail($travail_code));
            $this->entityManager->persist($depot);
            $this->entityManager->flush();
        }
        return $form;
    }
    public function getTravail($travail_code) {
        return $this->doctrine->getRepository(Travail::class)->findOneBy(["id" => $travail_code]);
    }
}