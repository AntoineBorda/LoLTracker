<?php

namespace App\Command;

use App\Entity\App\Tracker\DataTeam;
use App\Entity\App\Tracker\Player;
use App\Entity\App\Tracker\Team;
use App\Service\Api\Rapid\RapidApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:associate-playerteam',
)]
class AssociatePlayerTeamCommand extends Command
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
            ->setDescription('Associate player & team into the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $jsonData = $this->rapidApiService->getTeamsAndPlayers();

        foreach ($jsonData['data']['teams'] as $teamData) {
            foreach ($teamData['players'] as $playerData) {
                $team = $this->entityManager->getRepository(Team::class)->find($teamData['id']);
                $objectTeam = $this->entityManager->getRepository(DataTeam::class)->find($teamData['id']);
                $objectPlayer = $this->entityManager->getRepository(Player::class)->findOneBy(['idRiot' => $playerData['id']]);

                $existingAssociation = $this->entityManager->getRepository(Team::class)->findOneBy([
                    'dataTeam' => $objectTeam,
                    'player' => $objectPlayer,
                ]);

                if (!$existingAssociation) {
                    $team = new Team();
                    $team->setDataTeam($objectTeam);
                    $team->setPlayer($objectPlayer);
                    $this->entityManager->persist($team);
                } else {
                    $existingAssociation->setDataTeam($objectTeam);
                    $existingAssociation->setPlayer($objectPlayer);
                }
            }
        }

        $this->entityManager->flush();
        $io->success('Players and teams associated successfully.');

        return Command::SUCCESS;
    }
}
