<?php namespace Devfactory\Api;

use Devfactory\Api\Provider\ServiceInterface;

use Response;
use Route;
use App;
use Log;
use Config;
use SoapBox\Formatter\Formatter;

Class Api {

  /**
   * @implements Devfactory\Api\Provider\ServiceInterface
   */
  protected $service;

  /**
   * Debug mode
   */
  protected $debug = false;

  /**
   * Default format
   */
  protected $format = NULL;

  /**
   * Valid format
   */
  protected $valid_format = [
    'json',
    'xml',
    'yaml'
  ];

  /**
   * Content-Type
   */
  protected $content_types = [
    'json' => 'application/json',
    'xml' => 'application/xml',
    'yaml' => 'text/plain'
  ];


  public function __construct(ServiceInterface $service) {
    $this->service = $service;
    $this->format = Config::get('api::default_format', 'json');
    $this->debug = Config::get('api::debug', false);
  }

  /**
   * Convert an array to a defined format
   */
  protected function format($data) {
    $result = NULL;

    if(is_array($data)){
      $result = Formatter::make($data, 'array');
    }

    if(is_object($data)){
      $result = Formatter::make($data, 'object');
    }

    if(is_null($result)) {
      $result = Formatter::make(array($data), 'array');
    }

    return call_user_func(array($result, 'to' . ucfirst($this->format)));
  }

  /**
   * Return the content-type for a defined format
   */
  protected function setHeader() {
    return $this->content_types[$this->format];
  }

  /**
   * Retrieve the format parameter and override the default format
   */
  protected function determineFormat(){
    $format = NULL;

    // Get the current route
    $route = Route::getCurrentRoute();

    if($route){
      // Get the format parameter
      $format = $route->getParameter('format');
    }

    // Check if it's a valid format
    if(in_array($format, $this->valid_format)){
      // Set the good format
      $this->format = $format;
    }
  }

  protected function log($data, $status, $headers) {
    if(!$this->debug) {
      return;
    }

    Log::info(print_r($data, true), array('context' => 'API : data'));
    Log::info(print_r($status, true), array('context' => 'API : status'));
    Log::info(print_r($headers, true), array('context' => 'API : headers'));
  }

  /**
   * Retun the response
   *
   * @param data
   * @param status
   * @param headers
   *
   * @return
   */
  public function createResponse($data, $status = 200, $headers = array()) {

    // Find if a format has been setted
    $this->determineFormat();

    // Format to the good format
    $result = $this->format($data);

    // Create the repsonse
    $response = Response::make($result, $status);

    // Set the good headers
    $response->header('Content-Type', $this->setHeader());

    foreach ($headers as $key => $value){
      $response->header($key, $value);
    }

    $this->log($result, $status, $response->headers->all());

    return $response;
  }

  /**
   * Do a GET call to a internal url
   */
  public function get($url, $data = array()) {
    return $this->service->get($url, $data);
  }

  /**
   * Do a POST call to a internal url
   */
  public function post($url, $data = array()) {
    return $this->service->post($url, $data);
  }

  /**
   * Do a PUT call to a internal url
   */
  public function put($url, $data = array()) {
    return $this->service->put($url, $data);
  }
}