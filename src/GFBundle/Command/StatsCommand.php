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

        $output->write('User stats by category... ');
        $this->userStatsByCategory();
        $output->writeln('Done');

        $output->write('User stats by project... ');
        $this->userStatsByProject();
        $output->writeln('Done');

        $output->write('Company stats by category... ');
        $this->companyStatsByCategory();
        $output->writeln('Done');

        $output->write('Company stats by project... ');
        $this->companyStatsByProject();
        $output->writeln('Done');
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    private function userStatsByCategory()
    {
        $this->conn->query('TRUNCATE `user_stats_by_category`');
        $query =
            'INSERT INTO `user_stats_by_category` (user_id, hours, category_id)
                    SELECT u.id,
                           SUM(t.hours) AS hours,
                           t.category_id
                    FROM `task` t
                    INNER JOIN `user` u
                        ON u.phid = t.owner
                    WHERE t.`status` = "resolved"
                    GROUP BY u.id,
                             t.category_id';

        $this->conn->query($query);
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    private function userStatsByProject()
    {
        $this->conn->query('TRUNCATE `user_stats_by_project`');
        $query =
            'INSERT INTO `user_stats_by_project` (user_id, hours, project_id)
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

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    private function companyStatsByCategory()
    {
        $this->conn->query('TRUNCATE `company_stats_by_category`');
        $query =
            'INSERT INTO `company_stats_by_category` (company_id, hours, category_id)
                    SELECT u.company_id,
                           SUM(t.hours) AS hours,
                           t.category_id
                    FROM `task` t
                    INNER JOIN `user` u
                        ON u.phid = t.owner AND u.company_id IS NOT NULL
                    WHERE t.`status` = "resolved"
                    GROUP BY u.company_id,
                             t.category_id';

        $this->conn->query($query);
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    private function companyStatsByProject()
    {
        $this->conn->query('TRUNCATE `company_stats_by_project`');
        $query =
            'INSERT INTO `company_stats_by_project` (company_id, hours, project_id)
                    SELECT u.company_id,
                           SUM(t.hours) AS hours,
                           p.id
                    FROM `task` t
                    INNER JOIN `user` u
                        ON u.phid = t.owner AND u.company_id IS NOT NULL
                    INNER JOIN project p
                        ON p.phid = t.project
                    WHERE t.`status` = "resolved"
                    GROUP BY u.company_id,
                             p.id';

        $this->conn->query($query);
    }



}
