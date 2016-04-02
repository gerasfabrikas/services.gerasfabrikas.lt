<?php

namespace GFBundle\Command;

use GFBundle\Entity\User;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UsersCommand
 *
 * @package GFBundle\Command
 */
class UsersCommand extends ApiCommand
{
    protected function configure()
    {
        $this
            ->setName('gf:users')
            ->setDescription('Geras Fabrikas: fetches users via Phabricator API');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $apiClient = $this->getApiClient();

        print_r($apiClient->getUsers());
    }

}
