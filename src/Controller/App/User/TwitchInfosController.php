<?php

namespace App\Controller\App\User;

use App\Entity\Account\User\TwitchInfo;
use App\Entity\Account\User\User;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[IsGranted('ROLE_USER')]
#[Route('/user', name: 'user_')]
class TwitchInfosController extends AbstractController
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/{id}/twitchinfos', name: 'twitchinfos')]
    public function twitchInfosDisplay(User $user)
    {
        $twitchInfos = $this->entityManager->getRepository(TwitchInfo::class)->findBy(['user' => $user]);

        $clientID = $_ENV['TWITCH_CLIENT_ID'];
        $redirectURI = $_ENV['TWITCH_REDIRECT_URI'];
        $scopes = 'user:read:email';
        $url = 'https://id.twitch.tv/oauth2/authorize?response_type=code&client_id='.urlencode($clientID).'&redirect_uri='.urlencode($redirectURI).'&scope='.urlencode($scopes);

        return $this->render('pages/account/user/twitch_infos/base.html.twig', [
            'twitchInfos' => $twitchInfos,
            'clientID' => $clientID,
            'redirectURI' => $redirectURI,
            'twitchUrl' => $url,
        ]);
    }

    #[Route('/twitchinfos/new', name: 'twitchinfos_new')]
    public function twitchInfosNew(
        SessionInterface $session,
        Request $request
    ) {
        // ############################## SECURITY ###############################
        /** @var User $user */
        $user = $this->getUser();
        if (!$user) {
            $session->set('alertMessageSecurityKey', 'SECURITY_MUSTBECONNECTED');

            return $this->redirectToRoute('security_login');
        }
        // ############################## SECURITY ###############################
        $code = $request->query->get('code');

        if (!$code) {
            return $this->redirectToRoute('app_home');
        }

        $existingTwitchInfo = $this->entityManager->getRepository(TwitchInfo::class)->findOneBy(['user' => $user]);

        if ($existingTwitchInfo) {
            $session->set('alertMessageTwitchInfosKey', 'TWITCHINFOS_NEW_ALREADYEXISTS');

            return $this->redirectToRoute('user_twitchinfos', ['id' => $user->getId()]);
        }

        // Exchange the code for an access token
        $response = $this->httpClient->request('POST', 'https://id.twitch.tv/oauth2/token', [
            'body' => [
                'client_id' => $_ENV['TWITCH_CLIENT_ID'],
                'client_secret' => $_ENV['TWITCH_CLIENT_SECRET'],
                'code' => $code,
                'grant_type' => 'authorization_code',
                'redirect_uri' => $_ENV['TWITCH_REDIRECT_URI'],
            ],
        ]);

        $data = $response->toArray();

        // Use access token to retrieve user information
        $userResponse = $this->httpClient->request('GET', 'https://api.twitch.tv/helix/users', [
            'headers' => [
                'Authorization' => 'Bearer '.$data['access_token'],
                'Client-Id' => $_ENV['TWITCH_CLIENT_ID'],
            ],
        ]);

        $userData = $userResponse->toArray();

        $login = $userData['data'][0]['login'];
        $displayName = $userData['data'][0]['display_name'];
        $profileImageUrl = $userData['data'][0]['profile_image_url'];
        $email = $userData['data'][0]['email'];

        // Save user information to the database
        $twitchInfo = new TwitchInfo();
        $twitchInfo->setUser($user);
        $twitchInfo->setLogin($login);
        $twitchInfo->setDisplayName($displayName);
        $twitchInfo->setProfileImageUrl($profileImageUrl);
        $twitchInfo->setEmail($email);

        $this->entityManager->persist($twitchInfo);
        $this->entityManager->flush();

        $session->set('alertMessageTwitchInfosKey', 'TWITCHINFOS_NEW_SUCCESS');

        return $this->redirectToRoute('user_twitchinfos', ['id' => $user->getId()]);
    }

    #[Route('{id}/twitchinfos/delete', name: 'twitchinfos_delete', methods: ['POST'])]
    public function twitchInfoDelete(
        SessionInterface $session,
        Request $request,
        TwitchInfo $twitchInfo
    ) {
        // ############################## SECURITY ###############################
        $user = $this->getUser();
        if (!$user) {
            $session->set('alertMessageSecurityKey', 'SECURITY_MUSTBECONNECTED');

            return $this->redirectToRoute('security_login');
        }
        if ($twitchInfo->getUser() !== $user) {
            $session->set('alertMessageSecurityKey', 'SECURITY_ERROR');

            return $this->redirectToRoute('app_home');
        }
        // ############################## SECURITY ###############################

        if ($this->isCsrfTokenValid('delete'.$twitchInfo->getId(), $request->request->get('_token'))) {
            try {
                $this->entityManager->remove($twitchInfo);
                $this->entityManager->flush();
                $session->set('alertMessageTwitchInfosKey', 'TWITCHINFOS_DELETE_SUCCESS');
            } catch (ForeignKeyConstraintViolationException $e) {
                $session->set('alertMessageTwitchInfosKey', 'TWITCHINFOS_DELETE_ERROR');

                return $this->redirectToRoute('user_twitchinfos', ['id' => $user->getId()]);
            }
        }

        return $this->redirectToRoute('user_twitchinfos', ['id' => $user->getId()]);
    }
}
