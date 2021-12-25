<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;


class RegisterController extends AbstractController {
    private $globalRequest;
    public function template(Request $request) : Response {
        $this->entityManager = $this->getDoctrine()->getManager();
        $this->globalRequest = $request;
        $form = $this->register();
        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $userRepo = $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $user->getUsername()]);
            if(!$userRepo) {
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                return $this->redirectToRoute("loginPath");
            } else {
               echo "USER EXISTS";
            }
        }
        return $this->render("register.html.twig",[
            "form" => $form->createView()
        ]);
    }
    public function register() {
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
        ->add('submit',SubmitType::class,["label" => "Register", "attr" => ["class" => 'btn btn-primary btn-lg']])
        ->getForm();
        $form->handleRequest($this->globalRequest);
        return $form;
    }
}