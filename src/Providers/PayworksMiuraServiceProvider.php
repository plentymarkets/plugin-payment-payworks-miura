<?php //strict

namespace PayworksMiura\Providers;

use Plenty\Modules\Payment\Events\Checkout\ExecutePayment;
use Plenty\Modules\Payment\Events\Checkout\GetPaymentMethodContent;
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

         // Register the PayworksMiura payment method in the payment method container
         $payContainer->register('plenty_payworks_miura::PAYWORKSMIURA', PayworksMiuraPaymentMethod::class,
                                [ AfterBasketChanged::class, AfterBasketItemAdd::class, AfterBasketCreate::class ]
         );

         // Listen for the event that gets the payment method content
         $eventDispatcher->listen(GetPaymentMethodContent::class,
                 function(GetPaymentMethodContent $event) use( $paymentHelper)
                 {
                     if($event->getMop() == $paymentHelper->getPaymentMethod())
                     {
                         $event->setValue('');
                         $event->setType('continue');
                     }
                 });

         // Listen for the event that executes the payment
         $eventDispatcher->listen(ExecutePayment::class,
             function(ExecutePayment $event) use( $paymentHelper)
             {
                 if($event->getMop() == $paymentHelper->getPaymentMethod())
                 {
                     $event->setValue('<h1>PayworksMiura<h1>');
                     $event->setType('htmlContent');
                 }
             });
     }
 }
