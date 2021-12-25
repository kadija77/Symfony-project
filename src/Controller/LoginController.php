<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;


class LoginController extends AbstractController {
    private $globalRequest;

    public function template(Request $request) : Response {
        $this->entityManager = $this->getDoctrine()->getManager();
        $this->globalRequest = $request;
        $form = $this->login();
        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $userRepo = $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $user->getUsername(),'password' => $user->getPassword(),'type' => $user->getType()]);
            if(!$userRepo) {
                echo "NO USER";
            } else {
                $response = new RedirectResponse("/home");
                $response->headers->clearCookie("username");
                $response->headers->clearCookie("type");
                $response->headers->setCookie(new Cookie('username',$user->getUserName()));
                $response->headers->setCookie(new Cookie('type',$user->getType()));
                return $response;
            }
        }
        return $this->render('login.html.twig', [
            "form" => $this->login()->createView()
        ]);
    }

    public function login() {
        $form = $this->createFormBuilder(new User())
        ->add('type',ChoiceType::class,array(
            'choices' => array(
                'etudiant' => 'etudiant',
                'enseignant' => 'enseignant'
            ),
            'attr' => ['class' => 'form-control form-control-lg']
        ))
        ->add('username',TextType::class,[
            'attr' => ['class' => 'form-control form-control-lg']
        ])
        ->add('password',PasswordType::class,[
            'attr' => ['class' => 'form-control form-control-lg']
        ])
        ->add('submit',SubmitType::class,["label" => "Connection", "attr" => ["class" => 'btn btn-primary btn-lg']])
        ->getForm();
        $form->handleRequest($this->globalRequest);
        return $form;
    }
}