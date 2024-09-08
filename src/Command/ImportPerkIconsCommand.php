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
    name: 'app:import-perkicons',
)]
class ImportPerkIconsCommand extends Command
{
    private const JSON_URL = 'https://raw.communitydragon.org/latest/plugins/rcp-be-lol-game-data/global/default/v1/perks.json';

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
            ->setDescription('Import perk icons into the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $url = 'https://raw.communitydragon.org/latest/game/assets/perks/';
        $projectDir = $this->parameterBag->get('kernel.project_dir');
        $localPath = $projectDir.'/assets/img/communitydragon/lol-game-data/assets/v1/perk-images/';
        $jsonData = json_decode(file_get_contents(self::JSON_URL), true);

        if (!$this->filesystem->exists($localPath)) {
            $this->filesystem->mkdir($localPath);
        }

        $files = [];

        foreach ($jsonData as $championData) {
            $file = $championData['iconPath'];
            $indexDebut = strpos($file, 'perk-images/') + strlen('perk-images/');
            $file = substr($file, $indexDebut);
            $file = strtolower($file);

            $files[] = $file;
        }

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

        $io->success('Perk icons imported successfully!');

        return Command::SUCCESS;
    }
}
