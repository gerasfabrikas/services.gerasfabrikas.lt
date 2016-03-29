<?php

require_once 'path/to/libphutil/src/__phutil_library_init__.php';

$api_token = "api-qeqev5vdaw4pmfea73lbsmyljkky";
$api_parameters = array(
  'status' => 'status-resolved',
  'limit' => 100,
);

$client = new ConduitClient('http://mano.gerasfabrikas.lt/');
$client->setConduitToken($api_token);

$result = $client->callMethodSynchronous('maniphest.query', $api_parameters);
print_r($result);
