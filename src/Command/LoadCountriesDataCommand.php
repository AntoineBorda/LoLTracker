<?php

namespace App\Command;

use App\Entity\App\Tracker\DataCountry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:load-countries',
)]
class LoadCountriesDataCommand extends Command
{
    private const JSON_URL = 'https://restcountries.com/v3.1/all';

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Loads countries data from a JSON URL into the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $jsonData = json_decode(file_get_contents(self::JSON_URL), true);

        if (null === $jsonData) {
            $io->error('Unable to decode JSON from the provided URL.');

            return Command::FAILURE;
        }

        foreach ($jsonData as $countryKey) {
            $country = $this->entityManager->getRepository(DataCountry::class)->find(['id' => $countryKey['name']['common']]) ?? new DataCountry();
            $country->setId($countryKey['name']['common']);
            $country->setCommon($countryKey['name']['common']);
            $country->setOfficial($countryKey['name']['official']);
            $country->setCca2($countryKey['cca2']);
            $country->setRegion($countryKey['region']);
            $country->setFlag($countryKey['flags']['svg']);

            $this->entityManager->persist($country);
        }

        $this->entityManager->flush();
        $io->success('Countries data loaded successfully.');

        return Command::SUCCESS;
    }
}
