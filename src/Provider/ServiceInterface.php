<?php namespace Devfactory\Api\Provider;

interface ServiceInterface {

  public function post($url, $data);

  public function get($url, $data);

}