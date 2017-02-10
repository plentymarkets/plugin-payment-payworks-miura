<?php //strict

namespace Miura\Providers;

use Miura\Methods\MiuraAmericanExpressPaymentMethod;
use Plenty\Modules\Payment\Events\Checkout\ExecutePayment;
use Plenty\Modules\Payment\Events\Checkout\GetPaymentMethodContent;
use Plenty\Plugin\ServiceProvider;
use Miura\Helper\PaymentHelper;
use Plenty\Modules\Payment\Method\Contracts\PaymentMethodContainer;
use Plenty\Plugin\Events\Dispatcher;

use Plenty\Modules\Basket\Events\Basket\AfterBasketChanged;
use Plenty\Modules\Basket\Events\BasketItem\AfterBasketItemAdd;
use Plenty\Modules\Basket\Events\Basket\AfterBasketCreate;
use Plenty\Plugin\Log\Loggable;

/**
 * Class MiuraServiceProvider
 * @package Miura\Providers
 */
 class MiuraServiceProvider extends ServiceProvider
 {
     use Loggable;

     public function register()
     {
         $this->getApplication()->register(MiuraRouteServiceProvider::class);
     }

     /**
      * Boot additional services for the payment method
      *
      * @param PaymentHelper $paymentHelper
      * @param PaymentMethodContainer $payContainer
      * @param Dispatcher $eventDispatcher
      */
     public function boot(  PaymentHelper $paymentHelper,
                            PaymentMethodContainer $payContainer,
                            Dispatcher $eventDispatcher)
     {
         $logger = $this->getLogger(PaymentHelper::LOGGER_KEY);




         // Register the Miura payment method in the payment method container
         $payContainer->register(PaymentHelper::MIURA_PLUGIN_KEY.'::'.PaymentHelper::MIURA_AMERICAN_EXPRESS_MOP_KEY , MiuraAmericanExpressPaymentMethod::class,
                                [ AfterBasketChanged::class, AfterBasketItemAdd::class, AfterBasketCreate::class ]
         );

         // Listen for the event that gets the payment method content
         $eventDispatcher->listen(GetPaymentMethodContent::class,
                 function(GetPaymentMethodContent $event) use( $paymentHelper, $logger)
                 {
                     if($event->getMop() == $paymentHelper->getMiuraAmericanExpressPaymentMethodId())
                     {
                         $event->setValue('');
                         $event->setType('continue');
                     }
                 });

         // Listen for the event that executes the payment
         $eventDispatcher->listen(ExecutePayment::class,
             function(ExecutePayment $event) use( $paymentHelper, $logger)
             {
                 if($event->getMop() == $paymentHelper->getMiuraAmericanExpressPaymentMethodId())
                 {
                     $event->setValue('<h1>Miura American Express kauf<h1>');
                     $event->setType('htmlContent');
                 }
             });
     }

 }
