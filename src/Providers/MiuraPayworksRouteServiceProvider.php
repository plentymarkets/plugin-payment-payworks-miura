<?php //strict

namespace MiuraPayworks\Providers;

use MiuraPayworks\Controllers\MiuraPayworksPayworksController;
use MiuraPayworks\Helper\PaymentHelper;
use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;

use Plenty\Plugin\Log\Loggable;

/**
 * Class MiuraPayworksRouteServiceProvider
 * @package MiuraPayworks\Providers
 */
 class MiuraPayworksRouteServiceProvider extends RouteServiceProvider
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
         //callable as "{SHOP_URL}payworksmiura/echo" => dev enviroment "http://master.plentymarkets.com/miura/echo"
         $router->get('payworksmiura/echo', 'MiuraPayworks\Controllers\PayworksMiuraController@echoIt');
         $router->get('payworksmiura/configuration', 'MiuraPayworks\Controllers\PayworksMiuraController@configuration');
     }
 }
