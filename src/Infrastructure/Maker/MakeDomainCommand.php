<?php

namespace App\Infrastructure\Maker;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeDomainCommand extends AbstractMakeCommand
{
    protected static $defaultName = 'do:domain';

    protected function configure(): void
    {
        $this
            ->setDescription('Crée un domaine dans le projet')
            ->addArgument('domainName', InputArgument::REQUIRED, "Nom du domaine")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /** @var string $domain */
        $domain = $input->getArgument('domainName');

        /** @var Application $application */
        $application = $this->getApplication();

        $basePath = 'src';

        $foldersToCreate = ['Entity', 'Event', 'Interface', 'Query','Repository','Resolver', 'Subscriber', 'Validator'];

        mkdir($basePath.'/Domain/'.$domain);
        foreach ($foldersToCreate as $folder){
           mkdir($basePath.'/Domain/'.$domain.'/'.$folder);
        }

        $this->createService($domain);

        $io->success('Le domaine a bien été créé');
        return Command::SUCCESS;
    }
}
