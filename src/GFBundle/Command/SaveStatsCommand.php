<?php

namespace GFBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Doctrine\DBAL\Connection;

class SaveStatsCommand extends ApiCommand
{
    /** @var Connection */
    private $conn;


    protected function configure()
    {
        $this
            ->setName('gf:save:stats')
            ->setDescription('Geras Fabrikas: saves statistics to CSV format');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->conn = $this->getDoctrine()->getConnection();

        $output->write('Fetch stats by category... ');
        $this->writeStatsByCategory($this->getStatsByCategory());
        $output->writeln('Done');

        $output->write('User stats by project... ');
        $this->writeStatsByProject($this->getStatsByProject());
        $output->writeln('Done');
    }

    /**
     * @return array
     */
    private function getStatsByCategory()
    {
        $query = 'SELECT c.name,
                         SUM(t.hours) AS hours
                  FROM `task` t
                  INNER JOIN `category` c
                      ON c.id = t.category_id
                  WHERE t.`status` = "resolved"
                  GROUP BY c.name';

        return $this->conn->fetchAll($query);
    }

    /**
     * @param array $stats
     */
    private function writeStatsByCategory($stats)
    {
        $fp = fopen('/var/www/www.gerasfabrikas.lt/stats/category_pie.csv', 'w');
        fputcsv($fp, ['Kategorija', 'Valandos']);
        fputcsv($fp, ['string', 'number']);
        foreach ($stats as $row) {
            fputcsv($fp, [$row['name'], $row['hours']]);
        }
        fclose($fp);
    }

    /**
     * @return array
     */
    private function getStatsByProject()
    {
        $query = 'SELECT p.name,
                         SUM(t.hours) AS hours
                  FROM `task` t
                  INNER JOIN project p
                      ON p.phid = t.project
                  WHERE t.`status` = "resolved"
                  GROUP BY p.name';

        return $this->conn->fetchAll($query);
    }

    /**
     * @param array $stats
     */
    private function writeStatsByProject($stats)
    {
        $fp = fopen('/var/www/www.gerasfabrikas.lt/stats/category_pie.csv', 'w');
        fputcsv($fp, ['Projektas', 'Valandos']);
        fputcsv($fp, ['string', 'number']);
        foreach ($stats as $row) {
            fputcsv($fp, [$row['name'], $row['hours']]);
        }
        fclose($fp);
    }

}
