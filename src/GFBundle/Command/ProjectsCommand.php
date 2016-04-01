<?php

namespace GFBundle\Command;

require_once dirname(dirname(__FILE__)) . '/lib/libphutil/src/__phutil_library_init__.php';

use GFBundle\Service\ApiClient;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProjectsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('gf:projects')
            ->setDescription('Geras Fabrikas: fetches projects via Phabricator API');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //$output->writeln('Command result.');
        /** @var ApiClient $apiClient */
        $apiClient = $this->getContainer()->get('gf.api_client');

        print_r($apiClient->getOpenProjects());
    }

}
