<?php

namespace App\Command;

use App\Entity\App\Tracker\DataQueue;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:load-queues',
)]
class LoadQueuesDataCommand extends Command
{
    private const JSON_URL = 'https://raw.communitydragon.org/latest/plugins/rcp-be-lol-game-data/global/default/v1/queues.json';

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Loads queues data from a JSON URL into the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $jsonData = json_decode(file_get_contents(self::JSON_URL), true);

        foreach ($jsonData as $id => $queueData) {
            $queue = $this->entityManager->getRepository(DataQueue::class)->find($id) ?? new DataQueue();
            $queue->setId($id);
            $queue->setName($queueData['name']);
            $queue->setShortName($queueData['shortName']);
            $queue->setDescription($queueData['description']);

            $this->entityManager->persist($queue);
        }

        $this->entityManager->flush();
        $io->success('Queues data loaded successfully.');

        return Command::SUCCESS;
    }
}
