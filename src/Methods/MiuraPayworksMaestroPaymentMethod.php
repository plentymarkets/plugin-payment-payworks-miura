<?php //strict

namespace MiuraPayworks\Methods;

use MiuraPayworks\Helper\PaymentHelper;
use Plenty\Modules\Payment\Method\Contracts\PaymentMethodService;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Log\Loggable;
/**
 * Class MiuraPayworksMaestroPaymentMethod
 * @package MiuraPayworks\Methods
 */
class MiuraPayworksMaestroPaymentMethod extends PaymentMethodService
{
    use Loggable;
    const PAYMENT_METHOD_NAME = 'MiuraPayworksMaestro';
    const PAYMENT_METHOD_KEY = 'MIURA_MAESTRO';
    /**
     * @var ConfigRepository
     */
    private $configRepository;

    /**
     * MiuraPayworksMaestroPaymentMethod constructor.
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

        $miuraMaestroMerchantIdentifier = trim($this->configRepository->get(PaymentHelper::MIURA_PLUGIN_NAME.'.miura-maestro.merchant-identifier'));
        $miuraMaestroMerchantSecretKey = trim($this->configRepository->get(PaymentHelper::MIURA_PLUGIN_NAME.'.miura-maestro.merchant-secret-key'));

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
        $description = $this->configRepository->get(PaymentHelper::MIURA_PLUGIN_NAME.'.miura-maestro.description');

        $description = trim($description);
        return $description;
    }

}
