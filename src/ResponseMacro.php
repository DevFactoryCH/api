<?php namespace Devfactory\Api;

\Response::macro('api', function($data, $status = 200, $headers = array()){
  $api = \App::make('api');
  return $api->createResponse($data, $status, $headers);
});