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
     * @param int $limit
     *
     * @return array
     */
    public function getRecentlyResolvedTasks($limit = 10)
    {
        $parameters = array(
            'status' => 'status-resolved',
            'limit' => $limit,
        );

        return $this->client->callMethodSynchronous('maniphest.query', $parameters);
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
     * @return array
     */
    public function getTasks()
    {
        $parameters = array(
            'limit' => 25,
        );

        return $this->client->callMethodSynchronous('maniphest.query', $parameters);
    }
}
