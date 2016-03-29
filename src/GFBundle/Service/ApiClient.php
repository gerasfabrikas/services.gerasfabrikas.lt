<?php

namespace GFBundle\Service;

require_once dirname(dirname(__FILE__)) . '/lib/libphutil/src/__phutil_library_init__.php';

/**
 * Phabricator API wrapper
 */
class ApiClient
{
    const API_TOKEN = "api-qeqev5vdaw4pmfea73lbsmyljkky";
    /** @var \ConduitClient */
    private $client;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->client = new \ConduitClient('http://mano.gerasfabrikas.lt/');
        $this->client->setConduitToken(self::API_TOKEN);
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
}
