<?php //strict

namespace Miura\Helper;

use Plenty\Modules\Payment\Method\Contracts\PaymentMethodRepositoryContract;
use Plenty\Modules\Payment\Method\Models\PaymentMethod;
use Plenty\Plugin\Log\Loggable;
use Plenty\Modules\Payment\Models\Payment;
use Plenty\Modules\Order\Contracts\OrderRepositoryContract;
use Plenty\Modules\Order\Models\Order;
use Plenty\Modules\Payment\Contracts\PaymentOrderRelationRepositoryContract;
use Plenty\Modules\Payment\Contracts\PaymentRepositoryContract;
/**
 * Class PaymentHelper
 *
 * @package Miura\Helper
 */
class PaymentHelper
{

    use Loggable;

    const PAY_METHOD_NOT_FOUND = 'no_paymentmethod_found';
    const MIURA_PLUGIN_KEY = 'plenty_miura';
    const MIURA_PAYMENT_KEY = 'MIURA';
    const PAYMENT_METHOD_NAME = 'Miura';
    const LOGGER_KEY = 'MiuraPayment';
    const MIURA_AMERICAN_EXPRESS_MOP_KEY = '';
    const MIURA_MAESTRO_MOP_KEY = '';
    const MIURA_MASTER_CARD_MOP_KEY = '';
    const MIURA_VISA_ELECTRON_MOP_KEY = '';
    const MIURA_VISA_MOP_KEY = '';
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
     * Load the ID of the payment method for the given plugin key
     * Return the ID for the payment method
     *
     * @return string|int
     */
    public function getMiuraAmericanExpressPaymentMethodId()
    {
        return $this->checkMethodKey(self::MIURA_AMERICAN_EXPRESS_MOP_KEY);
    }

    /**
     * Load the ID of the payment method for the given plugin key
     * Return the ID for the payment method
     *
     * @return string|int
     */
    public function getMiuraMaestroPaymentMethodId()
    {
        return $this->checkMethodKey(self::MIURA_MAESTRO_MOP_KEY);
    }

    /**
     * Load the ID of the payment method for the given plugin key
     * Return the ID for the payment method
     *
     * @return string|int
     */
    public function getMiuraMasterCardPaymentMethodId()
    {
        return $this->checkMethodKey(self::MIURA_MASTER_CARD_MOP_KEY);
    }

    /**
     * Load the ID of the payment method for the given plugin key
     * Return the ID for the payment method
     *
     * @return string|int
     */
    public function getMiuraVisaElectronPaymentMethodId()
    {
        return $this->checkMethodKey(self::MIURA_VISA_ELECTRON_MOP_KEY);
    }

    /**
     * Load the ID of the payment method for the given plugin key
     * Return the ID for the payment method
     *
     * @return string|int
     */
    public function getMiuraVisaPaymentMethodId()
    {

        return $this->checkMethodKey(self::MIURA_VISA_MOP_KEY);
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

}
