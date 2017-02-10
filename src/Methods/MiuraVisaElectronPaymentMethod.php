<?php //strict

namespace Miura\Methods;

use Plenty\Modules\Payment\Method\Contracts\PaymentMethodService;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Log\Loggable;
/**
 * Class MiuraVisaElectronPaymentMethod
 * @package Miura\Methods
 */
class MiuraVisaElectronPaymentMethod extends PaymentMethodService
{
    use Loggable;
    const PAYMENT_METHOD_NAME = 'MiuraVisaElectron';
    const PAYMENT_METHOD_KEY = 'MIURA_VISA_ELECTRON';
    /**
     * @var ConfigRepository
     */
    private $configRepository;

    /**
     * MiuraVisaElectronPaymentMethod constructor.
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
        $miuraVisaElectronMerchantIdentifier = trim($this->configRepository->get('Miura.miura-visa-electron.merchant-identifier'));
        $miuraVisaElectronMerchantSecretKey = trim($this->configRepository->get('Miura.miura-visa-electron.merchant-secret-key'));

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
        $description = $this->configRepository->get('Miura.miura-visa-electron.description');

        $description = trim($description);
        return $description;
    }

}
