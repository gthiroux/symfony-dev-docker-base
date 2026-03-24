<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdFormType;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request,EntityManagerInterface $em): Response
    {   $ad=new Ad();
        $ad_form=$this->createForm(AdFormType::class, $ad);
        $ad_form->handleRequest($request);
        if ($ad_form->isSubmitted()){
            if ($ad_form->isValid()) {
                $ad->setUser($this->getUser());
                $em->persist($ad);
                $em->flush();
                return $this->redirectToRoute('app_home');
            }}

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'ad_form'=>$ad_form,
        ]);
    }

}
