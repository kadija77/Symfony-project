<?php

namespace App\Controller;

use App\Entity\DepotTravail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class NoteController extends AbstractController {
    private $globalRequest;
    private $entityManager;
    private $doctrine;
     /**
     * @Route("/noteDepot/{depot_code}",name="noteDepot")
     */
    public function template(Request $request,PersistenceManagerRegistry $doctrine,$depot_code) : Response {
        $this->globalRequest = $request;
        $this->doctrine = $doctrine;
        $this->entityManager = $this->doctrine->getManager();
        $form = $this->returnNoteForm($depot_code);
        if($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('allDepot',["travail_code" => $this->getTravail($depot_code)]);
        }
        return $this->render("note.html.twig", [
            "form" => $form->createView()
        ]);
    }
    public function returnNoteForm($depot_code) {
        $depot = $this->doctrine->getRepository(DepotTravail::class)->findOneBy(["id" => $depot_code]);
        $form = $this->createFormBuilder($depot)
        ->add("note", IntegerType::class)
        ->add('save',SubmitType::class,["label" => "Note"])
        ->getForm();
        $form->handleRequest($this->globalRequest);
        if($form->isSubmitted() && $form->isValid()) {
            $depot = $form->getData();
            $this->entityManager->flush();
        }
        return $form;
    }
    public function getTravail($depot_code) {
        $depot = $this->doctrine->getRepository(DepotTravail::class)->findOneBy(["id" => $depot_code]);
        return $depot->getTravail()->getId();
    }
}