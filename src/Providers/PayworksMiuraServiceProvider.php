<?php //strict

namespace PayworksMiura\Providers;

use PayworksMiura\Methods\PayworksMiuraVisaElectronPaymentMethod;
use Plenty\Plugin\ServiceProvider;
use PayworksMiura\Helper\PayworksMiuraHelper;
use Plenty\Modules\Payment\Method\Contracts\PaymentMethodContainer;
use Plenty\Plugin\Events\Dispatcher;

use PayworksMiura\Methods\PayworksMiuraPaymentMethod;

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
         $payContainer->register('plenty_payworks_miura::PAYWORKSMIURA_VISA', PayworksMiuraVisaPaymentMethod::class,
                                [ AfterBasketChanged::class, AfterBasketItemAdd::class, AfterBasketCreate::class ]
         );

         // Register the PayworksMiura Visa Electron payment method in the payment method container
         $payContainer->register('plenty_payworks_miura::PAYWORKSMIURA_VISAELECTRON', PayworksMiuraVisaElectronPaymentMethod::class,
                                [ AfterBasketChanged::class, AfterBasketItemAdd::class, AfterBasketCreate::class ]
         );

         /**
          * No listening for GetPaymentMethodContent or ExecutePayment, this is handle by the app
          */
     }
 }
