<?php

namespace GFBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Doctrine\DBAL\Connection;

class StatsCommand extends ApiCommand
{
    /** @var Connection */
    private $conn;


    protected function configure()
    {
        $this
            ->setName('gf:stats')
            ->setDescription('Geras Fabrikas: calculates statistics');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->conn = $this->getDoctrine()->getConnection();
        $this->clearData();

        $query =
            'INSERT INTO `stats` (`name`, company, hours, category)
                    SELECT u.realname,
                           u.company,
                           SUM(t.hours) AS hours,
                           tc.name
                    FROM `task` t
                    INNER JOIN `user` u
                        ON u.phid = t.owner
                    INNER JOIN task_category tc
                        ON tc.category = t.category
                    WHERE t.`status` = "resolved"
                    GROUP BY u.realname,
                             tc.name';

        $this->conn->query($query);
        $output->writeln('Done');
    }

    private function clearData()
    {
        $this->conn->query('TRUNCATE `stats`');

    }



}
