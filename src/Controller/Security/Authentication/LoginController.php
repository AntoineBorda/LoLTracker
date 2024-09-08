<?php

namespace App\Controller\Security\Authentication;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/security', name: 'security_')]
class LoginController extends AbstractController
{
    public function __construct(
        private AuthenticationUtils $authenticationUtils
    ) {
    }

    #[Route('/post-login', name: 'post_login', methods: ['GET', 'POST'])]
    public function postLogin(
        SessionInterface $session
    ): Response {
        $session->set('alertMessageSecurityKey', 'SECURITY_LOGIN_SUCCESS');

        return $this->redirectToRoute('app_home');
    }

    #[Route('/login', name: 'login', methods: ['GET', 'POST'])]
    public function login(
        SessionInterface $session
    ): Response {
        $lastUsername = $this->authenticationUtils->getLastUsername();
        $error = $this->authenticationUtils->getLastAuthenticationError();
        if ($this->getUser()) {
            $session->set('alertMessageSecurityKey', 'SECURITY_LOGIN_SUCCESS');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pages/security/authentification/login/base.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
}
