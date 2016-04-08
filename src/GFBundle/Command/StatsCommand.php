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

        $output->writeln('User stats by category...');
        $this->statsByCategory();
        $output->writeln('Done');

        $output->writeln('User stats by project...');
        $this->statsByProject();
        $output->writeln('Done');
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    private function statsByCategory()
    {
        $this->conn->query('TRUNCATE `user_stats_by_category`');
        $query =
            'INSERT INTO `user_stats_by_category` (userId, hours, categoryId)
                    SELECT u.id,
                           SUM(t.hours) AS hours,
                           tc.id
                    FROM `task` t
                    INNER JOIN `user` u
                        ON u.phid = t.owner
                    INNER JOIN task_category tc
                        ON tc.category = t.category
                    WHERE t.`status` = "resolved"
                    GROUP BY u.id,
                             tc.id';

        $this->conn->query($query);

    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    private function statsByProject()
    {
        $this->conn->query('TRUNCATE `user_stats_by_project`');
        $query =
            'INSERT INTO `user_stats_by_project` (userId, hours, projectId)
                    SELECT u.id,
                           SUM(t.hours) AS hours,
                           p.id
                    FROM `task` t
                    INNER JOIN `user` u
                        ON u.phid = t.owner
                    INNER JOIN project p
                        ON p.phid = t.project
                    WHERE t.`status` = "resolved"
                    GROUP BY u.id,
                             p.id';

        $this->conn->query($query);
    }



}
