<?php //strict

namespace PayworksMiura\Helper;

use Plenty\Modules\Payment\Method\Contracts\PaymentMethodRepositoryContract;

/**
 * Class PayworksMiuraHelper
 *
 * @package PayworksMiura\Helper
 */
class PayworksMiuraHelper
{

    /**
     * @var string
     */
    const PLUGIN_NAME = 'PayworksMiura';
    /**
     * @var string
     */
    const PLUGIN_KEY = 'plenty_payworks_miura';
    /**
     * @var string
     */
    const NO_PAYMENTMETHOD_FOUND = 'no_paymentmethod_found';

    /**
     * @var array
     */
    public static $paymentMethods = [
        'PAYWORKSMIURA_AMERICANEXPRESS' => 'PayworksMiura American Express',
        'PAYWORKSMIURA_MAESTRO'         => 'PayworksMiura Maestro',
        'PAYWORKSMIURA_MASTERCARD'      => 'PayworksMiura MasterCard',
        'PAYWORKSMIURA_VISA'            => 'PayworksMiura Visa',
        'PAYWORKSMIURA_VISAELECTRON'    => 'PayworksMiura Visa Electron'
    ];

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
        // Check whether the ID of the payment method has been created

        foreach(self::$paymentMethods as $paymentKey => $paymentName)
        {
            if($this->getPaymentMethod($paymentKey) == self::NO_PAYMENTMETHOD_FOUND)
            {
                $paymentMethodData = array(
                    'pluginKey'     => self::PLUGIN_KEY,
                    'paymentKey'    => $paymentKey,
                    'name'          => $paymentName);

                $this->paymentMethodRepository->createPaymentMethod($paymentMethodData);
            }
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

    /**
     * Returns the complete Merchant Identifier key of the configuration
     * @return string
     */
    public static function getMerchantIdentifierKey(){
        return self::PLUGIN_NAME.'.merchant_identifier';
    }

    /**
     * Returns the complete Merchant Secret Key key of the configuration
     * @return string
     */
    public static function getMerchantSecretKeyKey(){
        return self::PLUGIN_NAME.'.merchant_secret_key';
    }

    /**
     * Returns the complete Sepa Lastschriftmandat key of the configuration
     * @return string
     */
    public static function getSepaLastschriftmandatKey(){
        return self::PLUGIN_NAME.'.sepa_lastschriftmandat';
    }

    /**
     * Returns the complete Datenschutzrechtliche Informationen key of the configuration
     * @return string
     */
    public static function getDatenschutzrechtlicheInformationen() {
        return self::PLUGIN_NAME.'.datenschutzrechtliche_informationen';
    }
}
