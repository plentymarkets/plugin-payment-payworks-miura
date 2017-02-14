<?php //strict

namespace PayworksMiura\Methods;

use Plenty\Modules\Payment\Method\Contracts\PaymentMethodService;
use Plenty\Plugin\ConfigRepository;

/**
 * Class PayworksMiuraPaymentMethod
 * @package PayworksMiura\Methods
 */
class PayworksMiuraPaymentMethod extends PaymentMethodService
{
    /**
     * Check the configuration if the payment method is active
     * Return true if the payment method is active, else return false
     *
     * @param ConfigRepository $configRepository
     * @return bool
     */
    public function isActive( ConfigRepository $configRepository ):bool
    {
        if( trim($configRepository->get('PayworksMiura.merchant_identifier')) != '' && trim($configRepository->get('PayworksMiura.merchant_secret_key')) !='')
        {
            return true;
        }

        return false;
    }

    /**
     * Get the name of the payment method. The name can be entered in the config.json.
     *
     * @param ConfigRepository $configRepository
     * @return string
     */
    public function getName( ConfigRepository $configRepository ):string
    {
        return 'PayworksMiura';
    }
}
