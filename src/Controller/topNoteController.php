<?php

namespace App\Controller;

use App\Entity\DepotTravail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class topNoteController extends AbstractController {

    /**
     * @Route("/topNote/{travail_code}",name="topNote")
     */
    public function template(Request $request,PersistenceManagerRegistry $doctrine,$travail_code) : Response {
        return $this->render("topNote.html.twig",[
            "depot" => $this->GetTopNote($doctrine,$travail_code)
        ]);
    }
    public function GetTopNote($doctrine,$travail_code) {
        return $doctrine->getRepository(DepotTravail::class)->getTopNote($travail_code);
    }
}