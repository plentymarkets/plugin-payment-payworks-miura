<?php //strict

namespace PayworksMiura\Methods;

use Plenty\Modules\Payment\Method\Contracts\PaymentMethodService;
use PayworksMiura\Helper\PayworksMiuraHelper;
use Plenty\Plugin\ConfigRepository;

/**
 * Class PayworksMiuraPaymentMethod
 * @package PayworksMiura\Methods
 */
class PayworksMiuraPaymentMethod extends PaymentMethodService
{

    /**
     * @var ConfigRepository
     */
    private $configRepository;
    /**
     * PayworksMiuraPaymentMethod constructor.
     * @param ConfigRepository $configRepository
     */
    public function __construct(ConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    /**
     * Check the configuration if the payment method is active
     * Return true if the payment method is active, else return false
     *
     * @return bool
     */
    public function isActive():bool
    {

        if( $this->getMerchantIdentifierValue() != '' &&  $this->getMerchantSecretKeyValue() !='')
        {
            return true;
        }

        return false;
    }

    /**
     * Get the name of the payment method. The name can be entered in the config.json.
     *
     * @return string
     */
    public function getName():string
    {
        return PayworksMiuraHelper::PLUGIN_NAME;
    }

    /**
     * Get the value of the Merchant Identifier
     * @return string
     */
    private function getMerchantIdentifierValue():string {
        return trim( $this->configRepository->get( PayworksMiuraHelper::getMerchantIdentifierKey() ) );
    }
    /**
     * Get the value of the Merchant Secret Key
     * @return string
     */
    private function getMerchantSecretKeyValue():string {
        return trim( $this->configRepository->get( PayworksMiuraHelper::getMerchantSecretKeyKey() ) );
    }
}
