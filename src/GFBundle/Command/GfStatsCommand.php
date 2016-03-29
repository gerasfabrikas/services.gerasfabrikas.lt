<?php

namespace GFBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GfStatsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('gf:stats')
            ->setDescription('Geras Fabrikas: fetches statistics via Phabricator API');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Command result.');
    }

}
