<?php

namespace App\Controller\App\User;

use App\Entity\Account\User\User;
use App\Form\App\User\MyInfosType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/user', name: 'user_')]
class MyInfosController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/{id}/myinfos/edit', name: 'myinfos_edit', methods: ['GET', 'POST'])]
    public function editMyInfos(
        SessionInterface $session,
        User $user,
        Request $request
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

        $form = $this->createForm(MyInfosType::class, $user, [
            'validation_groups' => ['Default'],
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setUpdatedAt(new \DateTimeImmutable());

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $session->set('alertMessageMyInfosKey', 'MYINFOS_EDIT_SUCCESS');

            return $this->redirectToRoute('user_myinfos_edit', [
                'id' => $user->getId(),
            ]);
        }

        return $this->render('pages/account/user/my_infos/base.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
