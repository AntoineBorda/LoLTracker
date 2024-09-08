<?php

namespace App\Controller\Security\Authentication;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/security', name: 'security_')]
class LogoutController extends AbstractController
{
    public function __construct()
    {
    }

    #[Route('/post-logout', name: 'post_logout', methods: ['GET', 'POST'])]
    public function postLogout(
        SessionInterface $session
    ): Response {
        $session->set('alertMessageSecurityKey', 'SECURITY_LOGOUT_SUCCESS');

        return $this->redirectToRoute('app_home');
    }

    #[Route('/logout', name: 'logout')]
    public function logout(): void
    {
    }
}
