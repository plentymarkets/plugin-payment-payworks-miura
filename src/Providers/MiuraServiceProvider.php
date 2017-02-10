<?php //strict

namespace Miura\Providers;

use Miura\Methods\MiuraAmericanExpressPaymentMethod;
use Miura\Methods\MiuraMaestroPaymentMethod;
use Miura\Methods\MiuraMasterCardPaymentMethod;
use Miura\Methods\MiuraVisaElectronPaymentMethod;
use Miura\Methods\MiuraVisaPaymentMethod;
use Miura\Helper\PaymentHelper;

use Plenty\Modules\Payment\Method\Contracts\PaymentMethodContainer;
use Plenty\Modules\Basket\Events\Basket\AfterBasketChanged;
use Plenty\Modules\Basket\Events\BasketItem\AfterBasketItemAdd;
use Plenty\Modules\Basket\Events\Basket\AfterBasketCreate;

use Plenty\Plugin\ServiceProvider;
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
      * @param PaymentMethodContainer $payContainer
      */
     public function boot(  PaymentMethodContainer $payContainer )
     {

         $paymentMethodsToRegister = [
             MiuraAmericanExpressPaymentMethod::PAYMENT_METHOD_KEY  => MiuraAmericanExpressPaymentMethod::class,
             MiuraMaestroPaymentMethod::PAYMENT_METHOD_KEY          => MiuraMaestroPaymentMethod::class,
             MiuraMasterCardPaymentMethod::PAYMENT_METHOD_KEY       => MiuraMasterCardPaymentMethod::class,
             MiuraVisaElectronPaymentMethod::PAYMENT_METHOD_KEY     => MiuraVisaElectronPaymentMethod::class,
             MiuraVisaPaymentMethod::PAYMENT_METHOD_KEY             => MiuraVisaPaymentMethod::class
         ];

         $this->registerPaymentMethods($paymentMethodsToRegister,$payContainer);

     }

     /**
      * @param array $paymentMethod
      * @param PaymentMethodContainer $payContainer
      */
     private function registerPaymentMethods(array $paymentMethod, PaymentMethodContainer $payContainer) {

         foreach ($paymentMethod as $paymentMethodKey => $paymentMethodClass) {
             $payContainer->register(PaymentHelper::MIURA_PLUGIN_KEY.'::'.$paymentMethodKey , $paymentMethodClass,
                 [ AfterBasketChanged::class, AfterBasketItemAdd::class, AfterBasketCreate::class ]
             );
         }

     }

 }
