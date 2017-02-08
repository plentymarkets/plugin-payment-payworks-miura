<?php //strict

namespace Miura\Helper;

use Plenty\Modules\Payment\Method\Contracts\PaymentMethodRepositoryContract;
use Plenty\Modules\Payment\Method\Models\PaymentMethod;

/**
 * Class MiuraHelper
 *
 * @package Miura\Helper
 */
class MiuraHelper
{

    const PAY_METHOD_NOT_FOUND = 'no_paymentmethod_found';
    const MIURA_PLUGIN_KEY = 'plenty_miura';
    const MIURA_PAYMENT_KEY = 'MIURA';
    const PAYMENT_METHOD_NAME = 'Miura';
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
        // Check whether the ID of the Invoice payment method has been created
        if($this->getPaymentMethod() == PAY_METHOD_NOT_FOUND)
        {
            $paymentMethodData = array( 'pluginKey' => MIURA_PLUGIN_KEY,
                                        'paymentKey' => MIURA_PAYMENT_KEY,
                                        'name' => PAYMENT_METHOD_NAME);

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
        $paymentMethods = $this->paymentMethodRepository->allForPlugin(MIURA_PLUGIN_KEY);

        if( !is_null($paymentMethods) )
        {
            foreach($paymentMethods as $paymentMethod)
            {
                if($paymentMethod->paymentKey == MIURA_PAYMENT_KEY)
                {
                    return $paymentMethod->id;
                }
            }
        }

        return PAY_METHOD_NOT_FOUND;
    }
}
