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
    name: 'app:import-spellicons',
)]
class ImportSpellIconsCommand extends Command
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
            ->setDescription('Import spell icons into the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $url = 'https://raw.communitydragon.org/latest/plugins/rcp-be-lol-game-data/global/default/data/spells/icons2d/';
        $projectDir = $this->parameterBag->get('kernel.project_dir');
        $localPath = $projectDir.'/assets/img/communitydragon/lol-game-data/assets/data/spells/icons2d/';

        if (!$this->filesystem->exists($localPath)) {
            $this->filesystem->mkdir($localPath);
        }

        $files = $this->getRemoteFilesList($url);

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

        $io->success('Spell icons imported successfully!');

        return Command::SUCCESS;
    }

    private function getRemoteFilesList(string $url): array
    {
        try {
            $response = $this->httpClient->request('GET', $url);
            $html = $response->getContent();

            $dom = new \DOMDocument();
            @$dom->loadHTML($html);

            $files = [];
            foreach ($dom->getElementsByTagName('a') as $link) {
                $href = $link->getAttribute('href');
                if (preg_match('/\.png$/', $href)) {
                    $files[] = $href;
                }
            }

            return $files;
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to get remote files list: '.$e->getMessage());
        }
    }
}
