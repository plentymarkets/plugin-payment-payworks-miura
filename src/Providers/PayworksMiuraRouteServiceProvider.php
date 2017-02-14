<?php
/**
 * Created by IntelliJ IDEA.
 * User: jahnalexanderhane
 * Date: 13.02.17
 * Time: 14:59
 */

namespace PayworksMiura\Providers;


use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;
/**
 * Class PayworksMiuraRouteServiceProvider
 * @package PayworksMiura\Providers
 */
class PayworksMiuraRouteServiceProvider extends RouteServiceProvider
{
    /**
     * @param Router $router
     */
    public function map(Router $router)
    {

        //call {SHOP_DOMAIN}/payworksmiura/configuration
        $router->get('payworksmiura/configuration', [
            'middleware' => 'oauth',
            'uses'       => 'PayworksMiura\Controllers\SettingsController@configuration'
        ]);
    }
}