<?php //strict

namespace MiuraPayworks\Methods;

use MiuraPayworks\Helper\PaymentHelper;
use Plenty\Modules\Payment\Method\Contracts\PaymentMethodService;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Log\Loggable;
/**
 * Class MiuraPayworksVisaElectronPaymentMethod
 * @package MiuraPayworks\Methods
 */
class MiuraPayworksVisaElectronPaymentMethod extends PaymentMethodService
{
    use Loggable;
    const PAYMENT_METHOD_NAME = 'MiuraPayworksVisaElectron';
    const PAYMENT_METHOD_KEY = 'MIURA_VISA_ELECTRON';
    /**
     * @var ConfigRepository
     */
    private $configRepository;

    /**
     * MiuraPayworksVisaElectronPaymentMethod constructor.
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
        $miuraVisaElectronMerchantIdentifier = trim($this->configRepository->get(PaymentHelper::MIURA_PLUGIN_NAME.'.miura-visa-electron_merchant-identifier'));
        $miuraVisaElectronMerchantSecretKey = trim($this->configRepository->get(PaymentHelper::MIURA_PLUGIN_NAME.'.miura-visa-electron_merchant-secret-key'));

        if(strlen($miuraVisaElectronMerchantIdentifier) > 0 && strlen($miuraVisaElectronMerchantSecretKey) > 0)
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
        $description = $this->configRepository->get(PaymentHelper::MIURA_PLUGIN_NAME.'.miura-visa-electron_description');

        $description = trim($description);
        return $description;
    }

}
