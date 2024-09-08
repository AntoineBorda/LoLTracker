<?php

namespace App\Command;

use App\Entity\App\Tracker\DataPerk;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:load-perks',
)]
class LoadPerksDataCommand extends Command
{
    private const JSON_URL_PERKS = 'https://raw.communitydragon.org/latest/plugins/rcp-be-lol-game-data/global/default/v1/perks.json';
    private const JSON_URL_PERKS_STYLES = 'https://raw.communitydragon.org/latest/plugins/rcp-be-lol-game-data/global/default/v1/perkstyles.json';

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Loads perks data from a JSON URL into the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $jsonDataPerks = json_decode(file_get_contents(self::JSON_URL_PERKS), true);

        if (null === $jsonDataPerks) {
            $io->error('Unable to decode JSON from the provided URL.');

            return Command::FAILURE;
        }

        $jsonDataPerksStyles = json_decode(file_get_contents(self::JSON_URL_PERKS_STYLES), true);

        if (null === $jsonDataPerksStyles) {
            $io->error('Unable to decode JSON from the provided URL.');

            return Command::FAILURE;
        }

        foreach ($jsonDataPerks as $perksData) {
            $perk = $this->entityManager->getRepository(DataPerk::class)->find(['id' => $perksData['id']]) ?? new DataPerk();
            $perk->setId($perksData['id']);
            $perk->setName($perksData['name']);
            $perk->setTooltip($perksData['tooltip']);
            $imagePath = 'build/img/communitydragon'.$perksData['iconPath'];
            $perk->setImage(strtolower($imagePath));

            $this->entityManager->persist($perk);
        }

        foreach ($jsonDataPerksStyles['styles'] as $perksStylesData) {
            $perk = $this->entityManager->getRepository(DataPerk::class)->find(['id' => $perksStylesData['id']]) ?? new DataPerk();
            $perk->setId($perksStylesData['id']);
            $perk->setName($perksStylesData['name']);
            $perk->setTooltip($perksStylesData['tooltip']);
            $imagePath = 'build/img/communitydragon'.$perksStylesData['iconPath'];
            $perk->setImage(strtolower($imagePath));

            $this->entityManager->persist($perk);
        }

        $this->entityManager->flush();
        $io->success('Perks data loaded successfully.');

        return Command::SUCCESS;
    }
}
