<?php

namespace App\Controller\App\Core;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LegalController extends AbstractController
{
    #[Route('/legal', name: 'app_legal')]
    public function legalDisplay(): Response
    {
        return $this->render('pages/app/core/legal/index.html.twig', []);
    }
}
