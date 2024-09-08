<?php

namespace App\Command;

use App\Entity\App\Tracker\DataLeague;
use App\Entity\App\Tracker\League;
use App\Entity\App\Tracker\Player;
use App\Service\Api\Rapid\RapidApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:associate-playerleague',
)]
class AssociatePlayerLeagueCommand extends Command
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
            ->setDescription('Associate player & league into the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $jsonData = $this->rapidApiService->getTeamsAndPlayers();

        foreach ($jsonData['data']['teams'] as $teamData) {
            if (!isset($teamData['players'], $teamData['homeLeague']['name'])) {
                continue;
            }

            foreach ($teamData['players'] as $playerData) {
                $leagueName = $teamData['homeLeague']['name'];

                $objectLeague = $this->entityManager->getRepository(DataLeague::class)->findBy(['name' => $leagueName]);
                if (empty($objectLeague)) {
                    $io->note("League not found: $leagueName");
                    continue;
                }

                $objectPlayer = $this->entityManager->getRepository(Player::class)->findOneBy(['idRiot' => $playerData['id']]);
                if (!$objectPlayer) {
                    $io->note("Player not found: {$playerData['id']}");
                    continue;
                }

                $existingAssociation = $this->entityManager->getRepository(League::class)->findOneBy([
                    'dataLeague' => $objectLeague[0],
                    'player' => $playerData['id'],
                ]);

                if (!$existingAssociation) {
                    $league = new League();
                    $league->setDataLeague($objectLeague[0]);
                    $league->setPlayer($objectPlayer);
                    $this->entityManager->persist($league);
                } else {
                    $existingAssociation->setDataLeague($objectLeague[0]);
                    $existingAssociation->setPlayer($objectPlayer);
                }
            }
        }

        $this->entityManager->flush();
        $io->success('Players & Leagues associated successfully.');

        return Command::SUCCESS;
    }
}
