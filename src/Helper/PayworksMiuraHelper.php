<?php //strict

namespace PayworksMiura\Helper;

use Plenty\Modules\Payment\Method\Contracts\PaymentMethodRepositoryContract;
use Plenty\Modules\Payment\Method\Models\PaymentMethod;

/**
 * Class PayworksMiuraHelper
 *
 * @package PayworksMiura\Helper
 */
class PayworksMiuraHelper
{
    /**
     * @var PaymentMethodRepositoryContract $paymentMethodRepository
     */
    private $paymentMethodRepository;

    /**
     * PayworksMiuraHelper constructor.
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
        if($this->getPaymentMethod('PAYWORKSMIURA_VISA') == 'no_paymentmethod_found')
        {
            $paymentMethodData = array( 'pluginKey' => 'plenty_payworks_miura',
                                        'paymentKey' => 'PAYWORKSMIURA_VISA',
                                        'name' => 'PayworksMiura');

            $this->paymentMethodRepository->createPaymentMethod($paymentMethodData);
        }
        // Check whether the ID of the Invoice payment method has been created
        if($this->getPaymentMethod('PAYWORKSMIURA_VISAELECTRON') == 'no_paymentmethod_found')
        {
            $paymentMethodData = array( 'pluginKey' => 'plenty_payworks_miura',
                'paymentKey' => 'PAYWORKSMIURA_VISAELECTRON',
                'name' => 'PayworksMiura');

            $this->paymentMethodRepository->createPaymentMethod($paymentMethodData);
        }
    }

    /**
     * Load the ID of the payment method for the given plugin key
     * Return the ID for the payment method
     *
     * @return string|int
     */
    private function getPaymentMethod($method)
    {
        $paymentMethods = $this->paymentMethodRepository->allForPlugin('plenty_payworks_miura');

        if( !is_null($paymentMethods) )
        {
            foreach($paymentMethods as $paymentMethod)
            {
                if($paymentMethod->paymentKey == $method)
                {
                    return $paymentMethod->id;
                }
            }
        }

        return 'no_paymentmethod_found';
    }
}
