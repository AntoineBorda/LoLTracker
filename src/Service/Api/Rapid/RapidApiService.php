<?php

namespace App\Service\Api\Rapid;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RapidApiService
{
    public function __construct(
        private HttpClientInterface $client,
        private LoggerInterface $logger,
        private string $rapidApiKey
    ) {
    }

    public function getLeagues(): array
    {
        try {
            $response = $this->client->request('GET', 'https://league-of-legends-esports.p.rapidapi.com/leagues', [
                'headers' => [
                    'X-RapidAPI-Key' => $this->rapidApiKey,
                    'X-RapidAPI-Host' => 'league-of-legends-esports.p.rapidapi.com',
                ],
            ]);

            return $response->toArray();
        } catch (TransportExceptionInterface|ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $e) {
            $this->logger->error('Failed to fetch leagues from RapidAPI', [
                'exception' => $e,
            ]);

            return [];
        }
    }

    public function getTeamsAndPlayers(): array
    {
        try {
            $response = $this->client->request('GET', 'https://league-of-legends-esports.p.rapidapi.com/teams', [
                'headers' => [
                    'X-RapidAPI-Key' => $this->rapidApiKey,
                    'X-RapidAPI-Host' => 'league-of-legends-esports.p.rapidapi.com',
                ],
            ]);

            return $response->toArray();
        } catch (TransportExceptionInterface|ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $e) {
            $this->logger->error('Failed to fetch teams and players from RapidAPI', [
                'exception' => $e,
            ]);

            return [];
        }
    }
}
