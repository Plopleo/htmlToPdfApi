<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;


class DeleteOldDataCommand extends Command
{
    const NB_DAYS_TO_SAVE = 4;

    protected function configure()
    {
        $this->setName('app:clear')
            ->setDescription('Delete old data saved for the pdf generation')
            ->setHelp("This command allows you to delete old data")
            ->addArgument('nbDaysToSave', InputArgument::OPTIONAL, 'To keep the data from today <-> nbDaysToSave in the past');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('===> Start deleting...');

        $nbDaysToSave = $input->getArgument('nbDaysToSave');

        if($nbDaysToSave != null && is_numeric($nbDaysToSave)){
            $nbDaysToSave = intval($nbDaysToSave);
        }else{
            $nbDaysToSave = self::NB_DAYS_TO_SAVE;
        }

        $fs = new Filesystem();
        $finder = new Finder();

        $dueDate = new \DateTime('now');
        $dueDate->sub(new \DateInterval('P'.$nbDaysToSave.'D'));

        $finder->in(__DIR__.'/../../../web/tmp')->directories()->depth('== 0');
        foreach ($finder as $dir) {
            $directoryDate = new \DateTime($dir->getRelativePathname());
            if($directoryDate < $dueDate){
               $fs->remove([$dir->getRealPath()]);
            }
        }

        $output->writeln('End !');
    }

}