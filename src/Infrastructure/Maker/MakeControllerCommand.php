<?php

namespace App\Infrastructure\Maker;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeControllerCommand extends AbstractMakeCommand
{
    protected static $defaultName = 'do:controller';

    protected function configure(): void
    {
        $this
            ->setDescription('Crée un controller et le test associé')
            ->addArgument('controllerName', InputArgument::OPTIONAL, 'Nom du controller')
            ->addOption('admin', null, InputOption::VALUE_NONE, "Génère un controller pour l'admin")
            ->addOption('profile', null, InputOption::VALUE_NONE, "Génère un controller pour le profil")
            ->addOption('auth', null, InputOption::VALUE_NONE, "Génère un controller pour l'authentification")
            ->addOption('public', null, InputOption::VALUE_NONE, "Génère un controller pour la partie Public")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        /** @var string $controllerPath */
        $controllerPath = $input->getArgument('controllerName');
        if ('Controller' !== substr($controllerPath, -1 * strlen('Controller'))) {
            $controllerPath .= 'Controller';
        }
        if (!is_string($controllerPath)) {
            throw new \RuntimeException('controllerPath doit être une chaine de caractère');
        }
        $parts = explode('/', $controllerPath);

        if (1 === count($parts)) {
            $namespace = '';
            $className = $parts[0];
        } else {
            $namespace = '\\'.implode('\\', array_slice($parts, 0, -1));
            $className = $parts[count($parts) - 1];
        }
        
        $admin = $input->getOption('admin');
        $profile = $input->getOption('profile');
        $auth = $input->getOption('auth');
        $public = $input->getOption('public');
        if (true === $admin) {$basePath = 'src/Http/Admin/Controller/';}
        elseif (true === $profile) {$basePath = 'src/Http/Profile/Controller/';}
        elseif (true === $auth) {$basePath = 'src/Http/Auth/Controller/';}
        elseif (true === $public) {$basePath = 'src/Http/Public/Controller/';} else {
            $basePath = 'src/Http/Controller/';
        }

        $params = [
            'namespace' => $namespace,
            'class_name' => $className,
            'admin' => $admin,
            'auth' => $auth,
            'profile' => $profile,
            'public' => $public
        ];
        

        $this->createFile('controller', $params, "{$basePath}{$controllerPath}.php");

        $io->success('Le controller a bien été créé');

        return Command::SUCCESS;
    }
}
