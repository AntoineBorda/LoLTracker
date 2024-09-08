<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'app:import-divisionicons',
)]
class ImportDivisionIconsCommand extends Command
{
    public function __construct(
        private Filesystem $filesystem,
        private ParameterBagInterface $parameterBag,
        private HttpClientInterface $httpClient,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Import division icons into the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $url = 'https://raw.communitydragon.org/latest/plugins/rcp-fe-lol-shared-components/global/default/';
        $projectDir = $this->parameterBag->get('kernel.project_dir');
        $localPath = $projectDir.'/assets/img/communitydragon/division-icons/';

        if (!$this->filesystem->exists($localPath)) {
            $this->filesystem->mkdir($localPath);
        }

        $files = [
            'bronze.png',
            'challenger.png',
            'diamond.png',
            'emerald.png',
            'gold.png',
            'grandmaster.png',
            'iron.png',
            'master.png',
            'platinum.png',
            'silver.png',
            'unranked.png',
        ];

        foreach ($files as $file) {
            $iconUrl = $url.$file;
            $localFile = $localPath.$file;

            try {
                $response = $this->httpClient->request('GET', $iconUrl);
                if (200 === $response->getStatusCode()) {
                    $this->filesystem->dumpFile($localFile, $response->getContent());
                } else {
                    $io->error("Failed to download $file: ".$response->getStatusCode());
                }
            } catch (\Exception $e) {
                $io->error("Failed to download $file: ".$e->getMessage());
            }
        }

        $io->success('Division icons imported successfully!');

        return Command::SUCCESS;
    }
}
