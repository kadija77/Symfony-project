<?php

namespace App\Controller;

use App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends AbstractController {
    public function admin(Request $request) : Response {
        return $this->render("admin.html.twig", [
            "categorie" => $this->getAllCategorie()
        ]);
    }
    public function getAllCategorie() {
        return $this->getDoctrine()->getRepository(Categorie::class)->findAll();
    }
}