<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;

#[AsCommand(
    name: 'FillGarageBdd',
    description: 'Remplire la Bddd de faux data ',
)]
class FillGarageBddCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $process = new Process(['php',dirname(__DIR__,2, ).'/migrations/FillGarageBDD.php']);

        $process->run();
        //$_ENV['GARAGE_DATABASE_URL'],$_ENV['GARAGE_DATABASE_USER'],$_ENV['GARAGE_DATABASE_PASSWORD'

        if ($process->isSuccessful()) {
            $output->writeln('Le fichier PHP a été exécuté avec succès.');
            $output->writeln($process->getOutput());
        } else {
            $output->writeln('Une erreur s\'est produite lors de l\'exécution du fichier PHP.');
            $output->writeln($process->getErrorOutput());
        }

        return Command::SUCCESS;
    }
}
