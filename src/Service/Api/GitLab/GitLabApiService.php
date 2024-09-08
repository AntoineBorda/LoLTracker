<?php

namespace App\Service\Api\GitLab;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GitLabApiService
{
    public function __construct(
        private HttpClientInterface $client,
        private string $gitlabToken
    ) {
    }

    public function getReleases(string $projectId): array
    {
        $response = $this->client->request('GET', "https://gitlab.com/api/v4/projects/$projectId/releases", [
            'headers' => [
                'Authorization' => 'Bearer '.$this->gitlabToken,
            ],
        ]);

        return $response->toArray();
    }
}
