<?php

namespace App\Controller;

use App\Entity\DepotTravail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class topNoteController extends AbstractController {

    /**
     * @Route("/topNote/{travail_code}",name="topNote")
     */
    public function template(Request $request,$travail_code) : Response {
        return $this->render("topNote.html.twig",[
            "depot" => $this->GetTopNote($travail_code)
        ]);
    }
    public function GetTopNote($travail_code) {
        return $this->getDoctrine()->getRepository(DepotTravail::class)->getTopNote($travail_code);
    }
}