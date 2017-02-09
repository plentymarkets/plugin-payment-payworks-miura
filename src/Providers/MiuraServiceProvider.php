<?php //strict

namespace Miura\Providers;

use Plenty\Modules\Payment\Events\Checkout\ExecutePayment;
use Plenty\Modules\Payment\Events\Checkout\GetPaymentMethodContent;
use Plenty\Plugin\ServiceProvider;
use Miura\Helper\MiuraHelper;
use Plenty\Modules\Payment\Method\Contracts\PaymentMethodContainer;
use Plenty\Plugin\Events\Dispatcher;

use Miura\Methods\MiuraPaymentMethod;

use Plenty\Modules\Basket\Events\Basket\AfterBasketChanged;
use Plenty\Modules\Basket\Events\BasketItem\AfterBasketItemAdd;
use Plenty\Modules\Basket\Events\Basket\AfterBasketCreate;
use Plenty\Plugin\Log\Loggable;

/**
 * Class InvoiceServiceProvider
 * @package Invoice\Providers
 */
 class MiuraServiceProvider extends ServiceProvider
 {
     use Loggable;

     public function register()
     {
         $this->getLogger(MiuraHelper::LOGGER_KEY)->debug(__CLASS__.'->'.__FUNCTION__);
         $this->getApplication()->register(MiuraRouteServiceProvider::class);
     }

     /**
      * Boot additional services for the payment method
      *
      * @param MiuraHelper $paymentHelper
      * @param PaymentMethodContainer $payContainer
      * @param Dispatcher $eventDispatcher
      */
     public function boot(  MiuraHelper $paymentHelper,
                            PaymentMethodContainer $payContainer,
                            Dispatcher $eventDispatcher)
     {
         $this->getLogger(MiuraHelper::LOGGER_KEY)->debug(__CLASS__.'->'.__FUNCTION__);

         // Create the ID of the payment method if it doesn't exist yet
         $paymentHelper->createMopIfNotExists();

         // Register the Miura payment method in the payment method container
         $payContainer->register(MiuraHelper::MIURA_PLUGIN_KEY.'::'.MiuraHelper::MIURA_PAYMENT_KEY, MiuraPaymentMethod::class,
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
                     $event->setValue('<h1>Miurakauf<h1>');
                     $event->setType('htmlContent');
                 }
             });
     }
 }
