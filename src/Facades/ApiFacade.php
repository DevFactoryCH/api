<?php namespace Devfactory\Api\Facades;

use Illuminate\Support\Facades\Facade;

class ApiFacade extends Facade {

  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor() { return 'api'; }

}