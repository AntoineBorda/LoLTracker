<?php

namespace App\Controller\App\User;

use App\Entity\Account\User\User;
use App\Form\App\User\PasswordConfirmationType;
use App\Form\Security\SecurityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/user', name: 'user_')]
class Security extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/{id}/security/edit/', name: 'security_edit', methods: ['GET', 'POST'])]
    public function editPassword(
        SessionInterface $session,
        User $user,
        UserPasswordHasherInterface $passwordHasher,
        Request $request,
    ): Response {
        // ############################## SECURITY ###############################
        if (!$this->getUser()) {
            $session->set('alertMessageSecurityKey', 'SECURITY_MUSTBECONNECTED');

            return $this->redirectToRoute('security_login');
        }
        if ($this->getUser() !== $user) {
            $session->set('alertMessageSecurityKey', 'SECURITY_ERROR');

            return $this->redirectToRoute('app_home');
        }
        // ############################## SECURITY ###############################

        $form = $this->createForm(SecurityType::class, $user, [
            'validation_groups' => ['registration'],
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $currentPassword = $form->get('currentPassword')->getData();
            if ($passwordHasher->isPasswordValid($user, $currentPassword)) {
                $user->setUpdatedAt(new \DateTimeImmutable());
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $session->set('alertMessagePasswordKey', 'PASSWORD_EDIT_SUCCESS');

                return $this->redirectToRoute('user_security_edit', [
                    'id' => $user->getId(),
                ]);
            } else {
                $session->set('alertMessagePasswordKey', 'PASSWORD_EDIT_ERROR');

                return $this->redirectToRoute('user_security_edit', [
                    'id' => $user->getId(),
                ]);
            }
        }

        return $this->render('pages/account/user/security/edit_password/base.html.twig', [
            'form' => $form->createView(),
            'current_route' => $request->get('_route'),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/{id}/security/delete/', name: 'security_delete', methods: ['GET', 'POST'])]
    public function deleteUserAccount(
        SessionInterface $session,
        User $user,
        UserPasswordHasherInterface $passwordHasher,
        Request $request,
    ): Response {
        // ############################## SECURITY ###############################
        if (!$this->getUser()) {
            $session->set('alertMessageSecurityKey', 'SECURITY_MUSTBECONNECTED');

            return $this->redirectToRoute('security_login');
        }
        if ($this->getUser() !== $user) {
            $session->set('alertMessageSecurityKey', 'SECURITY_ERROR');

            return $this->redirectToRoute('app_home');
        }
        // ############################## SECURITY ###############################

        $form = $this->createForm(PasswordConfirmationType::class, $user, [
            'validation_groups' => ['registration'],
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $currentPassword = $form->get('plainPassword')->getData();
            if ($passwordHasher->isPasswordValid($user, $currentPassword)) {
                $this->entityManager->remove($user);
                $this->entityManager->flush();

                $session->invalidate();
                $this->container->get('security.token_storage')->setToken(null);

                $session->set('alertMessageAccountKey', 'ACCOUNT_DELETE_SUCCESS');

                return $this->redirectToRoute('app_home');
            } else {
                $session->set('alertMessageAccountKey', 'ACCOUNT_DELETE_ERROR');

                return $this->redirectToRoute('user_security_delete', [
                    'id' => $user->getId(),
                ]);
            }
        }

        return $this->render('pages/account/user/security/delete_account/base.html.twig', [
            'form' => $form->createView(),
            'current_route' => $request->get('_route'),
        ]);
    }
}
