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
        if($this->getPaymentMethod() == 'no_paymentmethod_found')
        {
            $paymentMethodData = array( 'pluginKey' => 'plenty_miura',
                                        'paymentKey' => 'MIURA',
                                        'name' => 'Miura');

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
        $paymentMethods = $this->paymentMethodRepository->allForPlugin('plenty_miura');

        if( !is_null($paymentMethods) )
        {
            foreach($paymentMethods as $paymentMethod)
            {
                if($paymentMethod->paymentKey == 'MIURA')
                {
                    return $paymentMethod->id;
                }
            }
        }

        return 'no_paymentmethod_found';
    }
}
