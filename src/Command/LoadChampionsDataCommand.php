<?php

namespace App\Command;

use App\Entity\App\Tracker\DataChampion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:load-champions',
)]
class LoadChampionsDataCommand extends Command
{
    private const JSON_URL = 'https://raw.communitydragon.org/latest/plugins/rcp-be-lol-game-data/global/default/v1/champion-summary.json';

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Loads champions data from a JSON URL into the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $jsonData = json_decode(file_get_contents(self::JSON_URL), true);

        if (null === $jsonData) {
            $io->error('Unable to decode JSON from the provided URL.');

            return Command::FAILURE;
        }

        foreach ($jsonData as $championData) {
            $champion = $this->entityManager->getRepository(DataChampion::class)->find(['id' => $championData['id']]) ?? new DataChampion();
            $champion->setId($championData['id']);
            $champion->setName($championData['name']);
            $imagePath = 'build/img/communitydragon'.$championData['squarePortraitPath'];
            $champion->setImage($imagePath);

            $this->entityManager->persist($champion);
        }

        $this->entityManager->flush();
        $io->success('Champions data loaded successfully.');

        return Command::SUCCESS;
    }
}
