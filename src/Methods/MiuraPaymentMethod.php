<?php //strict

namespace Miura\Methods;

use Miura\Helper\MiuraHelper;
use Plenty\Modules\Payment\Method\Contracts\PaymentMethodService;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Log\Loggable;
/**
 * Class MiuraPaymentMethod
 * @package Miura\Methods
 */
class MiuraPaymentMethod extends PaymentMethodService
{
    use Loggable;
    /**
     * @var ConfigRepository
     */
    private $configRepository;

    /**
     * MiuraPaymentMethod constructor.
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

        $this->getLogger(MiuraHelper::LOGGER_KEY)->debug(__CLASS__.'->'.__FUNCTION__);

        $active = false;

        if($this->isAtLeastOneMiuraKeyValuePairFilled())
            $active = true;

        return $active;
    }

    /**
     * Get the name of the payment method. The name can be entered in the config.json.
     *
     * @return string
     */
    public function getName():string
    {
        $this->getLogger(MiuraHelper::LOGGER_KEY)->debug(__CLASS__.'->'.__FUNCTION__);
        return MiuraHelper::PAYMENT_METHOD_NAME;
    }


    /**
     * Get additional costs for Miura. Additional costs can be entered in the config.json.
     *
     * @return float
     */
    public function getFee():float
    {
        $fee = $this->configRepository->get('Miura.fee');
        if(strlen($fee))
        {
            $fee = str_replace(',', '.', $fee);
        }
        else
        {
            $fee = 0;
        }
        return (float)$fee;
    }
    /**
     * Get the description of the payment method.
     *
     * @return string
     */
    public function getDescription( ):string
    {
        $this->getLogger(MiuraHelper::LOGGER_KEY)->debug(__CLASS__.'->'.__FUNCTION__);
        $description = $this->configRepository->get('Miura.description');

        $description = trim($description);
        return $description;
    }


    /**
     * @return bool
     */
    private function isAtLeastOneMiuraKeyValuePairFilled():bool {

        //Miura Visa
        $miuraVisaMerchantIdentifier = $this->configRepository->get('Miura.miura-visa.merchant-identifier');
        $miuraVisaMerchantSecretKey = $this->configRepository->get('Miura.miura-visa.merchant-secret-key');

        if(strlen($miuraVisaMerchantIdentifier) > 0 && strlen($miuraVisaMerchantSecretKey) > 0)
            return true;

        //Miura Visa Electron
        $miuraVisaElectronMerchantIdentifier = $this->configRepository->get('Miura.miura-visa-electron.merchant-identifier');
        $miuraVisaElectronMerchantSecretKey = $this->configRepository->get('Miura.miura-visa-electron.merchant-secret-key');

        if(strlen($miuraVisaElectronMerchantIdentifier) > 0 && strlen($miuraVisaElectronMerchantSecretKey) > 0)
            return true;

        //Miura Mastercard
        $miuraMastercardMerchantIdentifier = $this->configRepository->get('Miura.miura-mastercard.merchant-identifier');
        $miuraMastercardMerchantSecretKey = $this->configRepository->get('Miura.miura-mastercard.merchant-secret-key');

        if(strlen($miuraMastercardMerchantIdentifier) > 0 && strlen($miuraMastercardMerchantSecretKey) > 0)
            return true;

        //Miura American Express
        $miuraAmericanExpressMerchantIdentifier = $this->configRepository->get('Miura.miura-american-express.merchant-identifier');
        $miuraAmericanExpressMerchantSecretKey = $this->configRepository->get('Miura.miura-american-express.merchant-secret-key');

        if(strlen($miuraAmericanExpressMerchantIdentifier) > 0 && strlen($miuraAmericanExpressMerchantSecretKey) > 0)
            return true;

        //Miura American Express
        $miuraMaestroMerchantIdentifier = $this->configRepository->get('Miura.miura-maestro.merchant-identifier');
        $miuraMaestroMerchantSecretKey = $this->configRepository->get('Miura.miura-maestro.merchant-secret-key');

        if(strlen($miuraMaestroMerchantIdentifier) > 0 && strlen($miuraMaestroMerchantSecretKey) > 0)
            return true;

        return false;
    }
}
