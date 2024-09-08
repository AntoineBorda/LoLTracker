<?php

namespace App\Command;

use App\Entity\App\Tracker\DataItem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:load-items',
)]
class LoadItemsDataCommand extends Command
{
    private const JSON_URL = 'https://raw.communitydragon.org/latest/plugins/rcp-be-lol-game-data/global/default/v1/items.json';

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Loads items data from a JSON URL into the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $jsonData = json_decode(file_get_contents(self::JSON_URL), true);

        if (null === $jsonData) {
            $io->error('Unable to decode JSON from the provided URL.');

            return Command::FAILURE;
        }

        foreach ($jsonData as $itemData) {
            $item = $this->entityManager->getRepository(DataItem::class)->find(['id' => $itemData['id']]) ?? new DataItem();
            $item->setId($itemData['id']);
            $item->setName($itemData['name']);
            $item->setDescription(strip_tags($itemData['description']));
            $imagePath = 'build/img/communitydragon'.$itemData['iconPath'];
            $item->setImage(strtolower($imagePath));

            $this->entityManager->persist($item);
        }

        $this->entityManager->flush();
        $io->success('Items data loaded successfully.');

        return Command::SUCCESS;
    }
}
