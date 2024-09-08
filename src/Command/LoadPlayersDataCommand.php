<?php

namespace App\Command;

use App\Entity\App\Tracker\Player;
use App\Service\Api\Rapid\RapidApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:load-players',
)]
class LoadPlayersDataCommand extends Command
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
            ->setDescription('Loads players data from an API into the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $jsonData = $this->rapidApiService->getTeamsAndPlayers();

        // To avoid duplicates
        $processedIds = []; // Array to keep track of processed IDs
        foreach ($jsonData['data']['teams'] as $team) {
            foreach ($team['players'] as $playerData) {
                if (isset($processedIds[$playerData['id']])) {
                    continue; // If the ID has already been processed, skip it
                }
                // Mark ID as processed
                $processedIds[$playerData['id']] = true;

                $playerId = $playerData['summonerName'].'-'.$playerData['id'];
                $player = $this->entityManager->getRepository(Player::class)->findOneBy(['id' => $playerId]);

                if (!$player) {
                    $player = new Player();
                    $player->setId($playerId);
                    $player->setIdRiot($playerData['id']);
                }

                $player->setSummonerName($playerData['summonerName'] ?? null);
                $player->setFirstName($playerData['firstName'] ?? null);
                $player->setLastName($playerData['lastName'] ?? null);
                $player->setImage($playerData['image'] ?? null);
                $player->setRole($playerData['role'] ?? null);

                // Check for uniqueness and avoid duplication
                $existingPlayer = $this->entityManager->getRepository(Player::class)->findOneBy(['idRiot' => $playerData['id']]);
                if (!$existingPlayer) {
                    $this->entityManager->persist($player);
                }
            }
        }

        $this->entityManager->flush();
        $io->success('Players data loaded successfully.');

        return Command::SUCCESS;
    }
}
