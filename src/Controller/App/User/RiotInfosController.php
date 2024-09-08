<?php

namespace App\Controller\App\User;

use App\Entity\Account\User\RiotInfo;
use App\Entity\Account\User\User;
use App\Form\App\User\RiotInfosType;
use App\Service\Api\Riot\RiotApiService;
use App\Service\Tracker\RiotInfoService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/user', name: 'user_')]
class RiotInfosController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private RiotApiService $riotApiService,
        private RiotInfoService $riotInfoService
    ) {
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/{id}/riotinfos/new', name: 'riotinfos_new', methods: ['GET', 'POST'])]
    public function riotInfosNew(
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

        $riotInfos = $this->entityManager->getRepository(RiotInfo::class)->findBy(['user' => $user]);

        $riotInfo = new RiotInfo();

        $form = $this->createForm(RiotInfosType::class, $riotInfo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $riotInfo->setUser($user);
            $this->entityManager->persist($riotInfo);

            try {
                $this->riotInfoService->updateRiotInfo($riotInfo);
                $session->set('alertMessageRiotInfosKey', 'RIOTINFOS_NEW_SUCCESS');

                return $this->redirectToRoute('user_riotinfos_new', [
                    'id' => $user->getId(),
                ]);
            } catch (\Exception $e) {
                $session->set('alertMessageRiotInfosKey', 'RIOTINFOS_NEW_ERROR');

                return $this->redirectToRoute('user_riotinfos_new', [
                    'id' => $user->getId(),
                ]);
            }
        }

        return $this->render('pages/account/user/riot_infos/base.html.twig', [
            'form' => $form->createView(),
            'riotInfos' => $riotInfos,
        ]);
    }

    #[Route('{id}/riotinfos', name: 'riotinfos_delete', methods: ['GET', 'POST'])]
    public function riotInfoDelete(
        SessionInterface $session,
        Request $request,
        RiotInfo $riotInfo
    ): Response {
        // ############################## SECURITY ###############################
        $user = $this->getUser();
        if (!$user) {
            $session->set('alertMessageSecurityKey', 'SECURITY_MUSTBECONNECTED');

            return $this->redirectToRoute('security_login');
        }
        if ($riotInfo->getUser() !== $user) {
            $session->set('alertMessageSecurityKey', 'SECURITY_ERROR');

            return $this->redirectToRoute('app_home');
        }
        // ############################## SECURITY ###############################
        try {
            if ($this->isCsrfTokenValid('delete'.$riotInfo->getId(), $request->request->get('_token'))) {
                $this->entityManager->remove($riotInfo);
                $this->entityManager->flush();
                $session->set('alertMessageRiotInfosKey', 'RIOTINFOS_DELETE_SUCCESS');

                return $this->redirectToRoute('user_riotinfos_new', ['id' => $user->getId()]);
            }
        } catch (\Exception $e) {
            $session->set('alertMessageRiotInfosKey', 'RIOTINFOS_DELETE_ERROR');

            return $this->redirectToRoute('user_riotinfos_new', ['id' => $user->getId()]);
        }

        return $this->redirectToRoute('user_riotinfos_new', ['id' => $user->getId()]);
    }
}
