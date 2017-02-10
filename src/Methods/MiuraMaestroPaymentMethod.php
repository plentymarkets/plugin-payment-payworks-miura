<?php //strict

namespace Miura\Methods;

use Plenty\Modules\Payment\Method\Contracts\PaymentMethodService;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Log\Loggable;
/**
 * Class MiuraMaestroPaymentMethod
 * @package Miura\Methods
 */
class MiuraMaestroPaymentMethod extends PaymentMethodService
{
    use Loggable;
    const PAYMENT_METHOD_NAME = 'MiuraMaestro';
    const PAYMENT_METHOD_KEY = 'MIURA_MAESTRO';
    /**
     * @var ConfigRepository
     */
    private $configRepository;

    /**
     * MiuraMaestroPaymentMethod constructor.
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

        $miuraMaestroMerchantIdentifier = trim($this->configRepository->get('Miura.miura-maestro.merchant-identifier'));
        $miuraMaestroMerchantSecretKey = trim($this->configRepository->get('Miura.miura-maestro.merchant-secret-key'));

        if(strlen($miuraMaestroMerchantIdentifier) > 0 && strlen($miuraMaestroMerchantSecretKey) > 0)
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
        $description = $this->configRepository->get('Miura.miura-maestro.description');

        $description = trim($description);
        return $description;
    }

}
