<?php //strict

namespace PayworksMiura\Providers;

use Plenty\Plugin\ServiceProvider;
use PayworksMiura\Helper\PayworksMiuraHelper;
use Plenty\Modules\Payment\Method\Contracts\PaymentMethodContainer;
use Plenty\Plugin\Events\Dispatcher;

use PayworksMiura\Methods\PayworksMiuraAmericanExpressPaymentMethod;
use PayworksMiura\Methods\PayworksMiuraMaestroPaymentMethod;
use PayworksMiura\Methods\PayworksMiuraMasterCardPaymentMethod;
use PayworksMiura\Methods\PayworksMiuraVisaPaymentMethod;
use PayworksMiura\Methods\PayworksMiuraVisaElectronPaymentMethod;

use Plenty\Modules\Basket\Events\Basket\AfterBasketChanged;
use Plenty\Modules\Basket\Events\BasketItem\AfterBasketItemAdd;
use Plenty\Modules\Basket\Events\Basket\AfterBasketCreate;

/**
 * Class PayworksMiuraServiceProvider
 * @package PayworksMiura\Providers
 */
 class PayworksMiuraServiceProvider extends ServiceProvider
 {
     public function register()
     {

     }

     /**
      * Boot additional services for the payment method
      *
      * @param PayworksMiuraHelper $paymentHelper
      * @param PaymentMethodContainer $payContainer
      * @param Dispatcher $eventDispatcher
      */
     public function boot(  PayworksMiuraHelper $paymentHelper,
                            PaymentMethodContainer $payContainer,
                            Dispatcher $eventDispatcher)
     {
         // Create the ID of the payment method if it doesn't exist yet
         $paymentHelper->createMopIfNotExists();

         // Register the PayworksMiura Visa payment method in the payment method container
         $payContainer->register( PayworksMiuraHelper::PLUGIN_KEY.'::PAYWORKSMIURA_VISA', PayworksMiuraVisaPaymentMethod::class,
                                [ AfterBasketChanged::class, AfterBasketItemAdd::class, AfterBasketCreate::class ]
         );

         // Register the PayworksMiura Visa Electron payment method in the payment method container
         $payContainer->register( PayworksMiuraHelper::PLUGIN_KEY.'::PAYWORKSMIURA_VISAELECTRON', PayworksMiuraVisaElectronPaymentMethod::class,
                                [ AfterBasketChanged::class, AfterBasketItemAdd::class, AfterBasketCreate::class ]
         );

         // Register the PayworksMiura Mastercard payment method in the payment method container
         $payContainer->register( PayworksMiuraHelper::PLUGIN_KEY.'::PAYWORKSMIURA_MASTERCARD', PayworksMiuraMasterCardPaymentMethod::class,
             [ AfterBasketChanged::class, AfterBasketItemAdd::class, AfterBasketCreate::class ]
         );

         // Register the PayworksMiura Visa American express payment method in the payment method container
         $payContainer->register( PayworksMiuraHelper::PLUGIN_KEY.'::PAYWORKSMIURA_AMERICANEXPRESS', PayworksMiuraAmericanExpressPaymentMethod::class,
             [ AfterBasketChanged::class, AfterBasketItemAdd::class, AfterBasketCreate::class ]
         );

         // Register the PayworksMiura Visa Maestro express payment method in the payment method container
         $payContainer->register( PayworksMiuraHelper::PLUGIN_KEY.'::PAYWORKSMIURA_MAESTRO', PayworksMiuraMaestroPaymentMethod::class,
             [ AfterBasketChanged::class, AfterBasketItemAdd::class, AfterBasketCreate::class ]
         );

         /**
          * No listening for GetPaymentMethodContent or ExecutePayment, this is handle by the app
          */
     }
 }
