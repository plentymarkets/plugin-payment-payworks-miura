<?php //strict

namespace PayworksMiura\Methods;

use Plenty\Modules\Payment\Method\Contracts\PaymentMethodService;
use Plenty\Plugin\ConfigRepository;
use Plenty\Modules\Basket\Contracts\BasketRepositoryContract;
use Plenty\Modules\Basket\Models\Basket;

/**
 * Class PayworksMiuraVisaPaymentMethod
 * @package PayworksMiura\Methods
 */
class PayworksMiuraVisaPaymentMethod extends PaymentMethodService
{
    /**
     * Check the configuration if the payment method is active
     * Return true if the payment method is active, else return false
     *
     * @param ConfigRepository $configRepository
     * @param BasketRepositoryContract $basketRepositoryContract
     * @return bool
     */
    public function isActive( ConfigRepository $configRepository,
                              BasketRepositoryContract $basketRepositoryContract):bool
    {
        if( trim($configRepository->get('PayworksMiura.miuravisa-merchant_identifier')) != '' && trim($configRepository->get('PayworksMiura.miuravisa-merchant_secret_key')) !='')
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
        return 'PayworksMiura Visa';
    }
}
