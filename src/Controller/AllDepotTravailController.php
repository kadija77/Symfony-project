<?php

namespace App\Controller;

use App\Entity\DepotTravail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;


class AllDepotTravailController extends AbstractController {

    #[Route('/allDepot/{travail_code}', name: 'allDepot')]
    public function template(Request $request,PersistenceManagerRegistry $doctrine,$travail_code) : Response {
        return $this->render("allDepot.html.twig", [
            "depot" => $this->getAllDepot($doctrine,$travail_code)
        ]);
    }
    public function getAllDepot($doctrine,$travail_code) {
        return $doctrine->getRepository(DepotTravail::class)->findBy(["travail" => $travail_code]);
    }
}