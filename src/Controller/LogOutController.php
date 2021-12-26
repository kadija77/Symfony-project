<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LogOutController extends AbstractController {

    public function logOut(Request $request) : Response {
        $response = new RedirectResponse("/login");
        $response->headers->clearCookie("username");
        $response->headers->clearCookie("type");
        return $response;
    }
}