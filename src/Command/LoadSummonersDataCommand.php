<?php

namespace App\Command;

use App\Entity\App\Tracker\DataSummoner;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:load-summoners',
)]
class LoadSummonersDataCommand extends Command
{
    private const JSON_URL = 'https://raw.communitydragon.org/latest/plugins/rcp-be-lol-game-data/global/default/v1/summoner-spells.json';

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Loads summoners data from a JSON URL into the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $jsonData = json_decode(file_get_contents(self::JSON_URL), true);

        foreach ($jsonData as $summonerData) {
            $summoner = $this->entityManager->getRepository(DataSummoner::class)->find(['id' => $summonerData['id']]) ?? new DataSummoner();
            $summoner->setId($summonerData['id']);
            $summoner->setName($summonerData['name']);
            $summoner->setDescription($summonerData['description']);
            $imagePath = 'build/img/communitydragon'.$summonerData['iconPath'];
            $summoner->setImage(strtolower($imagePath));

            $this->entityManager->persist($summoner);
        }

        $this->entityManager->flush();
        $io->success('Summoners data loaded successfully.');

        return Command::SUCCESS;
    }
}
