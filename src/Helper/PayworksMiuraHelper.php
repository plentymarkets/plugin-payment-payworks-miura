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

    const PLUGIN_KEY = 'plenty_payworks_miura';
    const NO_PAYMENTMETHOD_FOUND = 'no_paymentmethod_found';
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
        if($this->getPaymentMethod('PAYWORKSMIURA_VISA') == self::NO_PAYMENTMETHOD_FOUND)
        {
            $paymentMethodData = array( 'pluginKey' => self::PLUGIN_KEY,
                                        'paymentKey' => 'PAYWORKSMIURA_VISA',
                                        'name' => 'PayworksMiura Visa');

            $this->paymentMethodRepository->createPaymentMethod($paymentMethodData);
        }
        // Check whether the ID of the Invoice payment method has been created
        if($this->getPaymentMethod('PAYWORKSMIURA_VISAELECTRON') == self::NO_PAYMENTMETHOD_FOUND)
        {
            $paymentMethodData = array( 'pluginKey' => self::PLUGIN_KEY,
                'paymentKey' => 'PAYWORKSMIURA_VISAELECTRON',
                'name' => 'PayworksMiura Visa Electron');

            $this->paymentMethodRepository->createPaymentMethod($paymentMethodData);
        }
        // Check whether the ID of the Invoice payment method has been created
        if($this->getPaymentMethod('PAYWORKSMIURA_MASTERCARD') == self::NO_PAYMENTMETHOD_FOUND)
        {
            $paymentMethodData = array( 'pluginKey' => self::PLUGIN_KEY,
                'paymentKey' => 'PAYWORKSMIURA_MASTERCARD',
                'name' => 'PayworksMiura MasterCard');

            $this->paymentMethodRepository->createPaymentMethod($paymentMethodData);
        }
        // Check whether the ID of the Invoice payment method has been created
        if($this->getPaymentMethod('PAYWORKSMIURA_AMERICANEXPRESS') == self::NO_PAYMENTMETHOD_FOUND)
        {
            $paymentMethodData = array( 'pluginKey' => self::PLUGIN_KEY,
                'paymentKey' => 'PAYWORKSMIURA_AMERICANEXPRESS',
                'name' => 'PayworksMiura American Express');

            $this->paymentMethodRepository->createPaymentMethod($paymentMethodData);
        }

        // Check whether the ID of the Invoice payment method has been created
        if($this->getPaymentMethod('PAYWORKSMIURA_MAESTRO') == self::NO_PAYMENTMETHOD_FOUND)
        {
            $paymentMethodData = array( 'pluginKey' => self::PLUGIN_KEY,
                'paymentKey' => 'PAYWORKSMIURA_MAESTRO',
                'name' => 'PayworksMiura Maestro');

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
        $paymentMethods = $this->paymentMethodRepository->allForPlugin(self::PLUGIN_KEY);

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

        return self::NO_PAYMENTMETHOD_FOUND;
    }
}
