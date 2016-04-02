<?php

namespace GFBundle\Command;

use GFBundle\Service\ApiClient;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Doctrine\Bundle\DoctrineBundle\Registry;

abstract class ApiCommand extends ContainerAwareCommand
{
    /**
     * @return ApiClient
     */
    protected function getApiClient()
    {
        return $this->getContainer()->get('gf.api_client');
    }

    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return Registry
     *
     * @throws \LogicException If DoctrineBundle is not available
     */
    protected function getDoctrine()
    {
        if (!$this->getContainer()->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->getContainer()->get('doctrine');
    }

}
