<?php

namespace App\Controller;

use App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;


class AdminController extends AbstractController {
    public function admin(Request $request,PersistenceManagerRegistry $doctrine) : Response {
        return $this->render("admin.html.twig", [
            "categorie" => $this->getAllCategorie($doctrine)
        ]);
    }
    public function getAllCategorie(PersistenceManagerRegistry $doctrine) {
        return $doctrine->getRepository(Categorie::class)->findAll();
    }
}