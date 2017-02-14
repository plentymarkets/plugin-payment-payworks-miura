<?php //strict

namespace PayworksMiura\Providers;

use Plenty\Plugin\ServiceProvider;
use PayworksMiura\Helper\PayworksMiuraHelper;
use Plenty\Modules\Payment\Method\Contracts\PaymentMethodContainer;

use PayworksMiura\Methods\PayworksMiuraPaymentMethod;


/**
 * Class PayworksMiuraServiceProvider
 * @package PayworksMiura\Providers
 */
 class PayworksMiuraServiceProvider extends ServiceProvider
 {
     public function register()
     {
         $this->getApplication()->register( PayworksMiuraRouteServiceProvider::class );
     }

     /**
      * Boot additional services for the payment method
      *
      * @param PayworksMiuraHelper $paymentHelper
      * @param PaymentMethodContainer $payContainer
      */
     public function boot(  PayworksMiuraHelper $paymentHelper,
                            PaymentMethodContainer $payContainer)
     {
         // Create the ID of the payment method if it doesn't exist yet
         $paymentHelper->createMopIfNotExists();

         foreach (PayworksMiuraHelper::$paymentMethods as $paymentKey => $paymentName)
         {
             $payContainer->register(   PayworksMiuraHelper::PLUGIN_KEY.'::'.$paymentKey,
                                        PayworksMiuraPaymentMethod::class,
                                        []
             );
         }

         /**
          * No listening for GetPaymentMethodContent or ExecutePayment, this is handle by the app
          */
     }
 }
