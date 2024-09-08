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
    name: 'app:import-roleicons',
)]
class ImportRoleIconsCommand extends Command
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
            ->setDescription('Import role icons into the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $url = 'https://raw.communitydragon.org/latest/plugins/rcp-fe-lol-parties/global/default/';
        $projectDir = $this->parameterBag->get('kernel.project_dir');
        $localPath = $projectDir.'/assets/img/communitydragon/role-icons/';

        if (!$this->filesystem->exists($localPath)) {
            $this->filesystem->mkdir($localPath);
        }

        $files = [
            'icon-position-bottom.png',
            'icon-position-jungle.png',
            'icon-position-middle.png',
            'icon-position-top.png',
            'icon-position-utility.png',
        ];

        $renamedFiles = [
            'icon-position-bottom.png' => 'bottom.png',
            'icon-position-jungle.png' => 'jungle.png',
            'icon-position-middle.png' => 'middle.png',
            'icon-position-top.png' => 'top.png',
            'icon-position-utility.png' => 'utility.png',
        ];

        foreach ($files as $file) {
            $iconUrl = $url.$file;
            $localFile = $localPath.$file;
            $renamedFile = $localPath.$renamedFiles[$file];

            try {
                $response = $this->httpClient->request('GET', $iconUrl);
                if (200 === $response->getStatusCode()) {
                    $this->filesystem->dumpFile($localFile, $response->getContent());
                    $this->filesystem->rename($localFile, $renamedFile, true);
                } else {
                    $io->error("Failed to download $file: ".$response->getStatusCode());
                }
            } catch (\Exception $e) {
                $io->error("Failed to download $file: ".$e->getMessage());
            }
        }

        $io->success('Role icons imported successfully!');

        return Command::SUCCESS;
    }
}
