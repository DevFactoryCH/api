Api
======

Helpers to create an Api for laravel 4.2


##How to setup

update `composer.json` file:

```json
{
    "require": {
        "devfactory/api": "1.0.*"
    }
}
```

and run `composer update` from terminal to download files.

update `app.php` file in `app/config` directory:

```php
'providers' => array(
  'Devfactory\Api\ApiServiceProvider',
),
```

```php
alias => array(
    'API'          => 'Devfactory\Api\Facades\ApiFacade',
),
```

##Configuration
```
 php artisan config:publish devfactory/api
```


##How to use api
in your route

```php

Route::group(array('prefix' => 'v1'), function()
{
    Route::get('foo', 'ApiV1\FooController@foo');
    Route::post('bar', 'ApiV1\FooController@bar');
});

```

In you controller you can use

```php
  return Response::api(array("foo" => "bar"), 404);
  return Response::api(array("ok"));
```
or

```php
  return API::createResponse(array("foo" => "bar"), 404);
  return API::createResponse(array("ok"));
```

##To call your service you can use the Facade

```php
  API::get('v1/foo', array('foo' => 'bar'));
  API::post('v1/bar', array('foo' => 'bar'));
```
