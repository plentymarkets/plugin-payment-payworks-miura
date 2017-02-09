<?php //strict

namespace Miura\Providers;

use Miura\Helper\MiuraHelper;
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
         $this->getLogger(MiuraHelper::LOGGER_KEY)->debug(__CLASS__.'->'.__FUNCTION__);
     }

     /**
      * @param Router $router
      */
     public function map(Router $router)
     {
         // simple echo to check that rest works for this plugin
         $router->get('miura/echo', 'Miura\Controllers\MiuraController@echoIt');
     }
 }
