<?php //strict

namespace Miura\Methods;

use Miura\Helper\PaymentHelper;
use Plenty\Modules\Payment\Method\Contracts\PaymentMethodService;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Log\Loggable;
/**
 * Class MiuraVisaPaymentMethod
 * @package Miura\Methods
 */
class MiuraVisaPaymentMethod extends PaymentMethodService
{
    use Loggable;
    const PAYMENT_METHOD_NAME = 'MiuraVisa';
    const PAYMENT_METHOD_KEY = 'MIURA_VISA';
    /**
     * @var ConfigRepository
     */
    private $configRepository;

    /**
     * MiuraVisaPaymentMethod constructor.
     *
     * @param ConfigRepository $configRepo
     */
    public function __construct(ConfigRepository $configRepo)
    {
        $this->configRepository     = $configRepo;
    }

    /**
     * Check the configuration if the payment method is active
     * Return true if the payment method is active, else return false
     *
     * @return bool
     */
    public function isActive():bool
    {
        $miuraVisaMerchantIdentifier = trim($this->configRepository->get(PaymentHelper::MIURA_PLUGIN_NAME.'.miura-visa.merchant-identifier'));
        $miuraVisaMerchantSecretKey = trim($this->configRepository->get(PaymentHelper::MIURA_PLUGIN_NAME.'.miura-visa.merchant-secret-key'));

        if(strlen($miuraVisaMerchantIdentifier) > 0 && strlen($miuraVisaMerchantSecretKey) > 0)
            return true;

        return false;
    }

    /**
     * Get the name of the payment method. The name can be entered in the config.json.
     *
     * @return string
     */
    public function getName():string
    {
        return self::PAYMENT_METHOD_NAME;
    }


    /**
     * Get additional costs for Miura. Additional costs can be entered in the config.json.
     *
     * @return float
     */
    public function getFee():float
    {
        return 0;
    }
    /**
     * Get the description of the payment method.
     *
     * @return string
     */
    public function getDescription( ):string
    {
        $description = $this->configRepository->get(PaymentHelper::MIURA_PLUGIN_NAME.'.miura-visa.description');

        $description = trim($description);
        return $description;
    }
}
