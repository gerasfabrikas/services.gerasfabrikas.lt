<?php

namespace GFBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StatsCommand extends ApiCommand
{
    protected function configure()
    {
        $this
            ->setName('gf:stats')
            ->setDescription('Geras Fabrikas: calculates statistics');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $sql = 'SELECT u.realname,
                       SUM(t.hours) AS hours,
                       tc.name
                FROM `task` t
                       INNER JOIN `user` u
                               ON u.phid = t.owner
                       INNER JOIN task_category tc
                               ON tc.category = t.category
                WHERE  t.`status` = \'resolved\'
                GROUP  BY u.realname,
                          tc.name';

        $output->writeln('Done');

    }

}
