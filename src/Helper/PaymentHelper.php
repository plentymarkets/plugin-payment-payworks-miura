<?php //strict

namespace MiuraPayworks\Helper;

use MiuraPayworks\Methods\MiuraPayworksAmericanExpressPaymentMethod;
use MiuraPayworks\Methods\MiuraPayworksMaestroPaymentMethod;
use MiuraPayworks\Methods\MiuraPayworksVisaElectronPaymentMethod;
use MiuraPayworks\Methods\MiuraPayworksVisaPaymentMethod;
use Plenty\Modules\Payment\Method\Contracts\PaymentMethodRepositoryContract;
use Plenty\Plugin\Log\Loggable;
use Plenty\Modules\Order\Contracts\OrderRepositoryContract;
use Plenty\Modules\Payment\Contracts\PaymentOrderRelationRepositoryContract;
/**
 * Class PaymentHelper
 *
 * @package MiuraPayworks\Helper
 */
class PaymentHelper
{

    use Loggable;

    const PAY_METHOD_NOT_FOUND = 'no_paymentmethod_found';
    const MIURA_PLUGIN_NAME = 'PayworksMiura'; //same as in plugin.json
    const MIURA_PLUGIN_KEY = 'plenty_payworks_miura';
    const LOGGER_KEY = 'PayworksMiuraPayment';

    /**
     * @var PaymentMethodRepositoryContract $paymentMethodRepository
     */
    private $paymentMethodRepository;
    /**
     * @var OrderRepositoryContract $orderRepository
     */
    private $orderRepository;

    /**
     * @var PaymentOrderRelationRepositoryContract
     */
    private $paymentOrderRelationRepo;
    /**
     * PaymentHelper constructor.
     *
     * @param PaymentMethodRepositoryContract $paymentMethodRepository
     */
    public function __construct(PaymentMethodRepositoryContract $paymentMethodRepository,
                                PaymentOrderRelationRepositoryContract $paymentOrderRelationRepo,
                                OrderRepositoryContract $orderRepository)
    {
        $this->paymentMethodRepository      = $paymentMethodRepository;
        $this->orderRepository              = $orderRepository;
        $this->paymentOrderRelationRepo     = $paymentOrderRelationRepo;
    }

    /**
     * Load the ID of the Miura American Express payment method
     * Return the ID for the payment method
     *
     * @return string|int
     */
    public function getMiuraAmericanExpressPaymentMethodId()
    {
        return $this->checkMethodKey(MiuraPayworksAmericanExpressPaymentMethod::PAYMENT_METHOD_KEY);
    }

    /**
     * Load the ID of the Miura Maestro payment method
     * Return the ID for the payment method
     *
     * @return string|int
     */
    public function getMiuraMaestroPaymentMethodId()
    {
        return $this->checkMethodKey(MiuraPayworksMaestroPaymentMethod::PAYMENT_METHOD_KEY);
    }

    /**
     * Load the ID of the Miura Master Card payment method
     * Return the ID for the payment method
     *
     * @return string|int
     */
    public function getMiuraMasterCardPaymentMethodId()
    {
        return $this->checkMethodKey(MiuraPayworksMaestroPaymentMethod::PAYMENT_METHOD_KEY);
    }

    /**
     * Load the ID of the Miura Visa Electron payment method
     * Return the ID for the payment method
     *
     * @return string|int
     */
    public function getMiuraVisaElectronPaymentMethodId()
    {
        return $this->checkMethodKey(MiuraPayworksVisaElectronPaymentMethod::PAYMENT_METHOD_KEY);
    }

    /**
     * Load the ID of the Miura Visa payment method
     * Return the ID for the payment method
     *
     * @return string|int
     */
    public function getMiuraVisaPaymentMethodId()
    {
        return $this->checkMethodKey(MiuraPayworksVisaPaymentMethod::PAYMENT_METHOD_KEY);
    }

    /**
     * @param string $methodKey
     * @return int|string
     */
    private function checkMethodKey(string $methodKey)
    {
        $paymentMethods = $this->paymentMethodRepository->allForPlugin(self::MIURA_PLUGIN_KEY);

        if( !is_null($paymentMethods) )
        {
            foreach($paymentMethods as $paymentMethod)
            {
                if($paymentMethod->paymentKey == $methodKey)
                {
                    return $paymentMethod->id;
                }
            }
        }

        return self::PAY_METHOD_NOT_FOUND;
    }

    public function isMiuraMopId($mopId) {

        if($this->getMiuraAmericanExpressPaymentMethodId() == $mopId)
            return true;

        if($this->getMiuraMaestroPaymentMethodId() == $mopId)
            return true;

        if($this->getMiuraMasterCardPaymentMethodId() == $mopId)
            return true;

        if($this->getMiuraVisaElectronPaymentMethodId() == $mopId)
            return true;

        if($this->getMiuraVisaPaymentMethodId() == $mopId)
            return true;

        return false;
    }
}
