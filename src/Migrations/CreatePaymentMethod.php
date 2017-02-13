<?php
namespace MiuraPayworks\Migrations;

use MiuraPayworks\Methods\MiuraPayworksAmericanExpressPaymentMethod;
use MiuraPayworks\Methods\MiuraPayworksMaestroPaymentMethod;
use MiuraPayworks\Methods\MiuraPayworksMasterCardPaymentMethod;
use MiuraPayworks\Methods\MiuraPayworksVisaElectronPaymentMethod;
use MiuraPayworks\Methods\MiuraPayworksVisaPaymentMethod;
use MiuraPayworks\Helper\PaymentHelper;
use Plenty\Modules\Payment\Method\Contracts\PaymentMethodRepositoryContract;

use Plenty\Plugin\Log\Loggable;
/**
 * Migration to create payment mehtods
 *
 * Class CreatePaymentMethod
 * @package MiuraPayworks\Migrations
 */
class CreatePaymentMethod
{

    use Loggable;
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

        $this->getLogger(PaymentHelper::LOGGER_KEY)->debug(__CLASS__.' '.__FUNCTION__);

        // Check whether the ID of the Miura American Express payment method has been created
        if($this->paymentHelper->getMiuraAmericanExpressPaymentMethodId() == PaymentHelper::PAY_METHOD_NOT_FOUND)
        {
            $paymentMethodData = array( 'pluginKey' => PaymentHelper::MIURA_PLUGIN_KEY,
                'paymentKey' => MiuraPayworksAmericanExpressPaymentMethod::PAYMENT_METHOD_KEY,
                'name' => MiuraPayworksAmericanExpressPaymentMethod::PAYMENT_METHOD_NAME);
            $this->paymentMethodRepositoryContract->createPaymentMethod($paymentMethodData);
        }

        // Check whether the ID of the Miura Maestro payment method has been created
        if($this->paymentHelper->getMiuraMaestroPaymentMethodId() == PaymentHelper::PAY_METHOD_NOT_FOUND)
        {
            $paymentMethodData = array( 'pluginKey'   => PaymentHelper::MIURA_PLUGIN_KEY,
                'paymentKey'  => MiuraPayworksMaestroPaymentMethod::PAYMENT_METHOD_KEY,
                'name'        => MiuraPayworksMaestroPaymentMethod::PAYMENT_METHOD_NAME);
            $this->paymentMethodRepositoryContract->createPaymentMethod($paymentMethodData);
        }

        // Check whether the ID of the Miura Master Card payment method has been created
        if($this->paymentHelper->getMiuraMasterCardPaymentMethodId() == PaymentHelper::PAY_METHOD_NOT_FOUND)
        {
            $paymentMethodData = array( 'pluginKey'   => PaymentHelper::MIURA_PLUGIN_KEY,
                'paymentKey'  => MiuraPayworksMasterCardPaymentMethod::PAYMENT_METHOD_KEY,
                'name'        => MiuraPayworksMasterCardPaymentMethod::PAYMENT_METHOD_NAME);
            $this->paymentMethodRepositoryContract->createPaymentMethod($paymentMethodData);
        }

        // Check whether the ID of the Miura Visa Electron payment method has been created
        if($this->paymentHelper->getMiuraVisaElectronPaymentMethodId() == PaymentHelper::PAY_METHOD_NOT_FOUND)
        {
            $paymentMethodData = array( 'pluginKey'   => PaymentHelper::MIURA_PLUGIN_KEY,
                'paymentKey'  => MiuraPayworksVisaElectronPaymentMethod::PAYMENT_METHOD_KEY,
                'name'        => MiuraPayworksVisaElectronPaymentMethod::PAYMENT_METHOD_NAME);
            $this->paymentMethodRepositoryContract->createPaymentMethod($paymentMethodData);
        }

        // Check whether the ID of the Miura Visa payment method has been created
        if($this->paymentHelper->getMiuraVisaPaymentMethodId() == PaymentHelper::PAY_METHOD_NOT_FOUND)
        {
            $paymentMethodData = array( 'pluginKey'   => PaymentHelper::MIURA_PLUGIN_KEY,
                'paymentKey'  => MiuraPayworksVisaPaymentMethod::PAYMENT_METHOD_KEY,
                'name'        => MiuraPayworksVisaPaymentMethod::PAYMENT_METHOD_NAME);
            $this->paymentMethodRepositoryContract->createPaymentMethod($paymentMethodData);
        }

    }
}