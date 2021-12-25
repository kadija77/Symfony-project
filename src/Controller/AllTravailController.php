<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Travail;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class AllTravailController extends AbstractController {
    private $globalRequest;
    private $entityManager;
     /**
     * @Route("/Alltravail/{categorie_code}",name="Alltravail")
     */
    public function template(Request $request,$categorie_code) : Response {
        $this->entityManager = $this->getDoctrine()->getManager();
        $this->globalRequest = $request;
        return $this->render("travail.html.twig", [
            'user' => $this->getMyUser(),
            "form" => $this->add($categorie_code)->createView(),
            "allTravail" => $this->getAllTravail($categorie_code)
        ]);
    }
    public function getAllTravail($categorie_code) {
        return $this->getDoctrine()->getRepository(Travail::class)->findBy(["category" => $categorie_code]);
    }
    public function getMyUser() {
        return $this->getDoctrine()->getRepository(User::class)->findOneBy(["username" => $this->globalRequest->cookies->get("username")]);
    }
    public function add($categorie_code) {
        $form = $this->createFormBuilder(new Travail())
        ->add('file',TextType::class)
        ->add('path',TextType::class, [
            "label" => "link"
        ])
        ->add('save',SubmitType::class,["label" => "create Travail"])
        ->getForm();
        $form->handleRequest($this->globalRequest);
        if($form->isSubmitted() && $form->isValid()) {
            $travail = $form ->getData();
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(["username" => $this->globalRequest->cookies->get("username")]);
            $categorie = $this->getDoctrine()->getRepository(Categorie::class)->findOneBy(["id" => $categorie_code]);
            $travail->setUser($user);
            $travail->setCategorie($categorie);
            $this->entityManager->persist($travail);
            $this->entityManager->flush();
        }
        return $form;
    }
}