<?php

namespace App\Command;

use App\Entity\App\Tracker\DataLeague;
use App\Service\Api\Rapid\RapidApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:load-leagues',
)]
class LoadLeaguesDataCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private RapidApiService $rapidApiService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Loads leagues data from API into the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $jsonData = $this->rapidApiService->getLeagues();

        if (empty($jsonData)) {
            $io->error('Unable to fetch leagues from the API.');

            return Command::FAILURE;
        }

        foreach ($jsonData['data'] as $leagues) {
            foreach ($leagues as $leagueData) {
                $league = $this->entityManager->getRepository(DataLeague::class)->find($leagueData['id']);

                if (!$league) {
                    $league = new DataLeague();
                    $league->setId($leagueData['id']);
                }

                $league->setName($leagueData['name'] ?? null);
                $league->setSlug($leagueData['slug'] ?? null);
                $league->setRegion($leagueData['region'] ?? null);
                $league->setImage($leagueData['image'] ?? null);
                $league->setPriority($leagueData['priority'] ?? null);
                $league->setPosition($leagueData['displayPriority']['position'] ?? null);
                $league->setStatus($leagueData['displayPriority']['status'] ?? null);

                $this->entityManager->persist($league);
            }
        }

        $this->entityManager->flush();
        $io->success('Leagues data loaded successfully.');

        return Command::SUCCESS;
    }
}
