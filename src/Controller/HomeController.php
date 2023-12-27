<?php

namespace App\Controller;

use App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class HomeController extends AbstractController {
    public function home(Request $request,PersistenceManagerRegistry $doctrine) : Response {
        if(!$request->cookies->get('username')) {
            return $this->redirectToRoute("loginPath");
        }
        return $this->render("home.html.twig", [
            "username" => $request->cookies->get('username'),
            "categorie" => $this->getAllCategorie($doctrine)
        ]);
    }
    public function getAllCategorie($doctrine) {
        return $doctrine->getRepository(Categorie::class)->findAll();
    }
}