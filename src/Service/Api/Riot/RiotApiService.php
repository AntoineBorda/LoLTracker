<?php

namespace App\Service\Api\Riot;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class RiotApiService
{
    public function __construct(
        private HttpClientInterface $client,
        private string $apiKey
    ) {
    }

    // GET LEAGUE DATA BY SUMMONER ID
    public function getLeagueDataBySummonerId(string $summonerId)
    {
        $response = $this->client->request(
            'GET',
            "https://euw1.api.riotgames.com/lol/league/v4/entries/by-summoner/{$summonerId}",
            [
                'headers' => [
                    'X-Riot-Token' => $this->apiKey,
                ],
            ]
        );

        return $response->toArray();
    }

    // GET SUMMONER DATA BY PUUID
    public function getSummonerDataByPuuid(string $puuid)
    {
        $response = $this->client->request(
            'GET',
            "https://euw1.api.riotgames.com/lol/summoner/v4/summoners/by-puuid/{$puuid}",
            [
                'headers' => [
                    'X-Riot-Token' => $this->apiKey,
                ],
            ]
        );

        return $response->toArray();
    }

    // GET PUUID BY RIOT ID
    public function getPuuidByRiotId(string $gamename, string $tagline)
    {
        $response = $this->client->request(
            'GET',
            "https://europe.api.riotgames.com/riot/account/v1/accounts/by-riot-id/{$gamename}/{$tagline}",
            [
                'headers' => [
                    'X-Riot-Token' => $this->apiKey,
                ],
            ]
        );

        return $response->toArray();
    }

    // GET LAST GAME 5V5 RANKED SOLO QUEUE
    public function getLastMatchByPuuid(string $puuid, string $timestamp)
    {
        $response = $this->client->request(
            'GET',
            "https://europe.api.riotgames.com/lol/match/v5/matches/by-puuid/{$puuid}/ids?endTime={$timestamp}&queue=420&start=0&count=1",
            [
                'headers' => [
                    'X-Riot-Token' => $this->apiKey,
                ],
            ]
        );

        return $response->toArray();
    }

    // GET GAME DATA BY MATCH ID
    public function getGameDataByMatchId(string $matchId)
    {
        $response = $this->client->request(
            'GET',
            "https://europe.api.riotgames.com/lol/match/v5/matches/{$matchId}",
            [
                'headers' => [
                    'X-Riot-Token' => $this->apiKey,
                ],
            ]
        );

        return $response->toArray();
    }
}
