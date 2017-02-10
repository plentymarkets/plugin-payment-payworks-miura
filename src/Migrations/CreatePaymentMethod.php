<?php
namespace Miura\Migrations;
use Miura\Methods\MiuraAmericanExpressPaymentMethod;
use Miura\Methods\MiuraMaestroPaymentMethod;
use Miura\Methods\MiuraMasterCardPaymentMethod;
use Miura\Methods\MiuraVisaElectronPaymentMethod;
use Miura\Methods\MiuraVisaPaymentMethod;
use Plenty\Modules\Payment\Method\Contracts\PaymentMethodRepositoryContract;
use Miura\Helper\PaymentHelper;
/**
 * Migration to create payment mehtods
 *
 * Class CreatePaymentMethod
 * @package PayPal\Migrations
 */
class CreatePaymentMethod
{
    /**
     * @var PaymentMethodRepositoryContract
     */
    private $paymentMethodRepositoryContract;
    /**
     * @var PaymentHelper
     */
    private $paymentHelper;
    /**
     * CreatePaymentMethod constructor.
     *
     * @param PaymentMethodRepositoryContract $paymentMethodRepositoryContract
     * @param PaymentHelper $paymentHelper
     */
    public function __construct(    PaymentMethodRepositoryContract $paymentMethodRepositoryContract,
                                    PaymentHelper $paymentHelper)
    {
        $this->paymentMethodRepositoryContract = $paymentMethodRepositoryContract;
        $this->paymentHelper = $paymentHelper;
    }
    /**
     * Run on plugin build
     *
     * Create Method of Payment ID for Miura relevant payment methods if they don't exist
     */
    public function run()
    {

        // Check whether the ID of the PayPal payment method has been created
        if($this->paymentHelper->getMiuraAmericanExpressPaymentMethodId() == PaymentHelper::PAY_METHOD_NOT_FOUND)
        {
            $paymentMethodData = array( 'pluginKey' => PaymentHelper::MIURA_PLUGIN_KEY,
                'paymentKey' => MiuraAmericanExpressPaymentMethod::PAYMENT_METHOD_KEY,
                'name' => MiuraAmericanExpressPaymentMethod::PAYMENT_METHOD_NAME);
            $this->paymentMethodRepositoryContract->createPaymentMethod($paymentMethodData);
        }

        // Check whether the ID of the PayPal Express payment method has been created
        if($this->paymentHelper->getMiuraMaestroPaymentMethodId() == PaymentHelper::PAY_METHOD_NOT_FOUND)
        {
            $paymentMethodData = array( 'pluginKey'   => PaymentHelper::MIURA_PLUGIN_KEY,
                'paymentKey'  => MiuraMaestroPaymentMethod::PAYMENT_METHOD_KEY,
                'name'        => MiuraMaestroPaymentMethod::PAYMENT_METHOD_NAME);
            $this->paymentMethodRepositoryContract->createPaymentMethod($paymentMethodData);
        }

        // Check whether the ID of the PayPal Express payment method has been created
        if($this->paymentHelper->getMiuraMasterCardPaymentMethodId() == PaymentHelper::PAY_METHOD_NOT_FOUND)
        {
            $paymentMethodData = array( 'pluginKey'   => PaymentHelper::MIURA_PLUGIN_KEY,
                'paymentKey'  => MiuraMasterCardPaymentMethod::PAYMENT_METHOD_KEY,
                'name'        => MiuraMasterCardPaymentMethod::PAYMENT_METHOD_NAME);
            $this->paymentMethodRepositoryContract->createPaymentMethod($paymentMethodData);
        }

        // Check whether the ID of the PayPal Express payment method has been created
        if($this->paymentHelper->getMiuraVisaElectronPaymentMethodId() == PaymentHelper::PAY_METHOD_NOT_FOUND)
        {
            $paymentMethodData = array( 'pluginKey'   => PaymentHelper::MIURA_PLUGIN_KEY,
                'paymentKey'  => MiuraVisaElectronPaymentMethod::PAYMENT_METHOD_KEY,
                'name'        => MiuraVisaElectronPaymentMethod::PAYMENT_METHOD_NAME);
            $this->paymentMethodRepositoryContract->createPaymentMethod($paymentMethodData);
        }

        // Check whether the ID of the PayPal Express payment method has been created
        if($this->paymentHelper->getMiuraVisaPaymentMethodId() == PaymentHelper::PAY_METHOD_NOT_FOUND)
        {
            $paymentMethodData = array( 'pluginKey'   => PaymentHelper::MIURA_PLUGIN_KEY,
                'paymentKey'  => MiuraVisaPaymentMethod::PAYMENT_METHOD_KEY,
                'name'        =>  MiuraVisaPaymentMethod::PAYMENT_METHOD_NAME);
            $this->paymentMethodRepositoryContract->createPaymentMethod($paymentMethodData);
        }

    }
}