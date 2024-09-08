<?php

namespace App\Command;

use App\Repository\App\Tracker\TrackerRepository;
use App\Service\Tracker\TrackerUpdateService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:update-trackers',
)]
class UpdateTrackersCommand extends Command
{
    public function __construct(
        private TrackerUpdateService $trackerUpdateService,
        private TrackerRepository $trackerRepository
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Update trackers.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $trackers = $this->trackerRepository->findAll();
        $this->trackerUpdateService->updateTracker($trackers);
        $output->writeln('Trackers updated successfully.');

        return Command::SUCCESS;
    }
}
