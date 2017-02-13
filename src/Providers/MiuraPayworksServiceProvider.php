<?php //strict

namespace MiuraPayworks\Providers;

use MiuraPayworks\Methods\MiuraPayworksAmericanExpressPaymentMethod;
use MiuraPayworks\Methods\MiuraPayworksMaestroPaymentMethod;
use MiuraPayworks\Methods\MiuraPayworksMasterCardPaymentMethod;
use MiuraPayworks\Methods\MiuraPayworksVisaElectronPaymentMethod;
use MiuraPayworks\Methods\MiuraPayworksVisaPaymentMethod;
use MiuraPayworks\Helper\PaymentHelper;

use Plenty\Modules\Payment\Method\Contracts\PaymentMethodContainer;
use Plenty\Modules\Basket\Events\Basket\AfterBasketChanged;
use Plenty\Modules\Basket\Events\BasketItem\AfterBasketItemAdd;
use Plenty\Modules\Basket\Events\Basket\AfterBasketCreate;

use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Log\Loggable;

/**
 * Class MiuraPayworksServiceProvider
 * @package MiuraPayworks\Providers
 */
 class MiuraPayworksServiceProvider extends ServiceProvider
 {
     use Loggable;

     public function register()
     {
         $this->getLogger(PaymentHelper::LOGGER_KEY)->debug(__CLASS__.' '.__FUNCTION__);
         $this->getApplication()->register(MiuraPayworksRouteServiceProvider::class);
     }

     /**
      * Boot additional services for the payment method
      *
      * @param PaymentMethodContainer $payContainer
      */
     public function boot( PaymentMethodContainer $payContainer )
     {
         $this->getLogger(PaymentHelper::LOGGER_KEY)->debug(__CLASS__.' '.__FUNCTION__);
         $paymentMethodsToRegister = [
             MiuraPayworksAmericanExpressPaymentMethod::PAYMENT_METHOD_KEY  => MiuraPayworksAmericanExpressPaymentMethod::class,
             MiuraPayworksMaestroPaymentMethod::PAYMENT_METHOD_KEY          => MiuraPayworksMaestroPaymentMethod::class,
             MiuraPayworksMasterCardPaymentMethod::PAYMENT_METHOD_KEY       => MiuraPayworksMasterCardPaymentMethod::class,
             MiuraPayworksVisaElectronPaymentMethod::PAYMENT_METHOD_KEY     => MiuraPayworksVisaElectronPaymentMethod::class,
             MiuraPayworksVisaPaymentMethod::PAYMENT_METHOD_KEY             => MiuraPayworksVisaPaymentMethod::class
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
