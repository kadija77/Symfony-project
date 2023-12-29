<?php

namespace App\Controller;

use App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class CrudController extends AbstractController {
    private $form;
    private $entityManager;
    private $globalRequest;
    private $doctrine;
    #[Route('/crudCategorie/{categorie_code}/{statut}', name: 'crudCategorie')]
    public function init(Request $request,PersistenceManagerRegistry $doctrine,$categorie_code,$statut) {
        $this->entityManager = $doctrine->getManager();
        $this->doctrine = $doctrine;
        $this->globalRequest = $request;
        $this->form = $this->handleCrud($categorie_code,$statut);
        if($this->form->isSubmitted() && $this->form->isValid()) {
            return $this->redirectToRoute('adminPath');
        }
        return $this->render("crud.html.twig",[
            "form" => $this->form->createView()
        ]);
    }
    public function handleCrud($categorie_code,$statut) {
        switch($statut) {
            case "edit" :
                return $this->edit($categorie_code);
                break;
            case "add" :
                return $this->add();
                break;
            case "delete" : 
                return $this->delete($categorie_code);
                break;
        };
    }
    public function edit($categorie_code) {
        $produit = $this->doctrine->getRepository(Categorie::class)->find($categorie_code);
        $form = $this->createFormBuilder($produit)
        ->add('nom',TextType::class)
        ->add('coefficient',IntegerType::class)
        ->add('save',SubmitType::class,["label" => "edit Produit"])
        ->getForm();
        $form->handleRequest($this->globalRequest);
        if($form->isSubmitted() && $form->isValid()) {
            $produit = $form->getData();
            $this->entityManager->flush();
        }
        return $form;
    }

    public function delete($categorie_code) {
        $produit = $this->doctrine->getRepository(Categorie::class)->find($categorie_code);
        $form = $this->createFormBuilder($produit)
        ->add('nom',TextType::class,['disabled' => true])
        ->add('coefficient',IntegerType::class,['disabled' => true])
        ->add('save',SubmitType::class,["label" => "delete produit"])
        ->getForm();
        $form->handleRequest($this->globalRequest);
        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->remove($produit);
            $this->entityManager->flush();
        }
        return $form;
    }
    public function add() {
        $form = $this->createFormBuilder(new Categorie())
        ->add('nom',TextType::class)
        ->add('coefficient',IntegerType::class)
        ->add('save',SubmitType::class,["label" => "create Category"])
        ->getForm();
        $form->handleRequest($this->globalRequest);
        if($form->isSubmitted() && $form->isValid()) {
            $produit = $form ->getData();
            $this->entityManager->persist($produit);
            $this->entityManager->flush();
        }
        return $form;
    }
}