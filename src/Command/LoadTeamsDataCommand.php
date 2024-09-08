<?php

namespace App\Command;

use App\Entity\App\Tracker\DataTeam;
use App\Service\Api\Rapid\RapidApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:load-teams',
)]
class LoadTeamsDataCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private RapidApiService $rapidApiService,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Loads teams data from API into the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $jsonData = $this->rapidApiService->getTeamsAndPlayers();

        foreach ($jsonData['data'] as $teams) {
            foreach ($teams as $teamData) {
                $team = $this->entityManager->getRepository(DataTeam::class)->find($teamData['id']);

                if (!$team) {
                    $team = new DataTeam();
                    $team->setId($teamData['id']);
                }

                $team->setName($teamData['name'] ?? null);
                $team->setSlug($teamData['slug'] ?? null);
                $team->setCode($teamData['code'] ?? null);
                $team->setImage($teamData['image'] ?? null);
                $team->setAlternativeImage($teamData['alternativeImage'] ?? null);
                $team->setBackgroundImage($teamData['backgroundImage'] ?? null);
                $team->setStatus($teamData['status'] ?? null);
                $team->setHomeLeagueName($teamData['homeLeague']['name'] ?? null);
                $team->setHomeLeagueRegion($teamData['homeLeague']['region'] ?? null);

                $this->entityManager->persist($team);
            }
        }

        $this->entityManager->flush();
        $io->success('Teams data loaded successfully!');

        return Command::SUCCESS;
    }
}
