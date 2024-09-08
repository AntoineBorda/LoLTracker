<?php

namespace App\Controller\App\Core;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contactDisplay(): Response
    {
        return $this->render('pages/app/core/contact/index.html.twig', []);
    }
}