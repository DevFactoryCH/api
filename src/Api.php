<?php namespace Devfactory\Api;

use Devfactory\Api\Provider\ServiceInterface;

use Response;

Class Api {

  protected $service;

  public function __construct(ServiceInterface $service) {
      $this->service = $service;
  }

  public function createResponse($data, $status = 200, $headers = array()) {

    // Create the repsonse
    $response = Response::make(json_encode($data), $status);

    $response->header('Content-Type', 'application/json');

    foreach ($headers as $key => $value){
      $response->header($key, $value);
    }

    return $response;
  }

  public function get($url, $data = array()) {
    return $this->service->get($url, $data);
  }

  public function post($url, $data = array()) {
    return $this->service->post($url, $data);
  }
}