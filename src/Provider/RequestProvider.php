<?php namespace Devfactory\Api\Provider;

use Request;
use Route;
use Input;

class RequestProvider implements ServiceInterface {

  protected $params;
  protected $mehtod;
  protected $url;

  protected function request() {
    Input::replace($this->params);
    $request = Request::create($this->url, $this->method);
    $response = Route::dispatch($request);
    return $response->getContent();
  }

  /**
   * Make a POST query
   *
   * @param data
   *
   * @return
   */
  public function post($url, $params = null) {
    $this->params = $params;
    $this->method = 'POST';
    $this->url = $url;

    return $this->request();
  }

  /**
   * Make a GET query
   *
   * @param data
   *
   * @return
   */
  public function get($url, $params = null) {
    $this->params = $params;
    $this->method = 'GET';
    $this->url = $url;

    return $this->request();
  }
}