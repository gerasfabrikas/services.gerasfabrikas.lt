<?php

namespace GFBundle\Service;

require_once dirname(dirname(__FILE__)) . '/lib/libphutil/src/__phutil_library_init__.php';

/**
 * Phabricator API wrapper
 */
class ApiClient
{
    /** @var \ConduitClient */
    private $client;

    /**
     * @param string $apiToken
     */
    public function __construct($apiToken)
    {
        $this->client = new \ConduitClient('http://mano.gerasfabrikas.lt/');
        $this->client->setConduitToken($apiToken);
    }

    /**
     * @return array
     */
    public function getOpenProjects()
    {
        $parameters = array(
            'status' => 'status-open'
        );

        return $this->client->callMethodSynchronous('project.query', $parameters);
    }

    /**
     * @return array
     */
    public function getUsers()
    {
        return $this->client->callMethodSynchronous('user.query', []);
    }

    /**
     * @param int $limit
     *
     * @return array
     */
    public function getTasks($limit = 100)
    {
        $parameters = array(
            'limit' => $limit,
            'order' => 'order-modified'
        );

        return $this->client->callMethodSynchronous('maniphest.query', $parameters);
    }
}
