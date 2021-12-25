<?php

namespace App\Controller;

use App\Entity\DepotTravail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AllDepotTravailController extends AbstractController {

    /**
     * @Route("/allDepot/{travail_code}",name="allDepot")
     */
    public function template(Request $request,$travail_code) : Response {
        return $this->render("allDepot.html.twig", [
            "depot" => $this->getAllDepot($travail_code)
        ]);
    }
    public function getAllDepot($travail_code) {
        return $this->getDoctrine()->getRepository(DepotTravail::class)->findBy(["travail" => $travail_code]);
    }
}