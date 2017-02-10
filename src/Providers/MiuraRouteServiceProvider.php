<?php //strict

namespace Miura\Providers;

use Miura\Controllers\MiuraController;
use Miura\Helper\PaymentHelper;
use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;

use Plenty\Plugin\Log\Loggable;

/**
 * Class MiuraRouteServiceProvider
 * @package Miura\Providers
 */
 class MiuraRouteServiceProvider extends RouteServiceProvider
 {
     use Loggable;

     public function register()
     {
         $this->getLogger(PaymentHelper::LOGGER_KEY)->debug(__CLASS__.'->'.__FUNCTION__);
     }

     /**
      * @param Router $router
      */
     public function map(Router $router)
     {
         // simple echo to check that rest works for this plugin
         //callable as "{SHOP_URL}miura/echo" => dev enviroment "http://master.plentymarkets.com/miura/echo"
         //$router->get('miura/echo', 'Miura\Controllers\MiuraController@echoIt');
         $router->get('miura/methods', [
             'middleware'   => 'oauth',
             'uses'         =>'Miura\Controllers\MiuraController@configuration'
         ]);
     }
 }
