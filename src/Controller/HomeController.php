<?php

namespace App\Controller;

use App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController {
    public function home(Request $request) : Response {
        if(!$request->cookies->get('username')) {
            return $this->redirectToRoute("loginPath");
        }
        return $this->render("home.html.twig", [
            "username" => $request->cookies->get('username'),
            "categorie" => $this->getAllCategorie()
        ]);
    }
    public function getAllCategorie() {
        return $this->getDoctrine()->getRepository(Categorie::class)->findAll();
    }
}