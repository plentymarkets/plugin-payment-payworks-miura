<?php //strict

namespace Miura\Helper;

use Plenty\Modules\Payment\Method\Contracts\PaymentMethodRepositoryContract;
use Plenty\Modules\Payment\Method\Models\PaymentMethod;
use Plenty\Plugin\Log\Loggable;

/**
 * Class MiuraHelper
 *
 * @package Miura\Helper
 */
class MiuraHelper
{

    use Loggable;

    const PAY_METHOD_NOT_FOUND = 'no_paymentmethod_found';
    const MIURA_PLUGIN_KEY = 'plenty_miura';
    const MIURA_PAYMENT_KEY = 'MIURA';
    const PAYMENT_METHOD_NAME = 'Miura';
    const LOGGER_KEY = 'MiuraPayment';
    /**
     * @var PaymentMethodRepositoryContract $paymentMethodRepository
     */
    private $paymentMethodRepository;

    /**
     * InvoiceHelper constructor.
     *
     * @param PaymentMethodRepositoryContract $paymentMethodRepository
     */
    public function __construct(PaymentMethodRepositoryContract $paymentMethodRepository)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    /**
     * Create the ID of the payment method if it doesn't exist yet
     */
    public function createMopIfNotExists()
    {
        $this->getLogger(self::LOGGER_KEY)->debug(__CLASS__.'->'.__FUNCTION__);
        // Check whether the ID of the Miura payment method has been created
        if($this->getPaymentMethod() == self::PAY_METHOD_NOT_FOUND)
        {
            $paymentMethodData = array( 'pluginKey' => self::MIURA_PLUGIN_KEY,
                                        'paymentKey' => self::MIURA_PAYMENT_KEY,
                                        'name' => self::PAYMENT_METHOD_NAME);

            $this->paymentMethodRepository->createPaymentMethod($paymentMethodData);
        }
    }

    /**
     * Load the ID of the payment method for the given plugin key
     * Return the ID for the payment method
     *
     * @return string|int
     */
    public function getPaymentMethod()
    {
        $this->getLogger(self::LOGGER_KEY)->debug(__CLASS__.'->'.__FUNCTION__);
        $paymentMethods = $this->paymentMethodRepository->allForPlugin(self::MIURA_PLUGIN_KEY);

        if( !is_null($paymentMethods) )
        {
            foreach($paymentMethods as $paymentMethod)
            {
                if($paymentMethod->paymentKey == self::MIURA_PAYMENT_KEY)
                {
                    return $paymentMethod->id;
                }
            }
        }

        return self::PAY_METHOD_NOT_FOUND;
    }
}
