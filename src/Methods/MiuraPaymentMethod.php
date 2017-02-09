<?php //strict

namespace Miura\Methods;

use Miura\Helper\MiuraHelper;
use Plenty\Modules\Payment\Method\Contracts\PaymentMethodService;
use Plenty\Plugin\ConfigRepository;
use Plenty\Modules\Basket\Contracts\BasketRepositoryContract;
use Plenty\Modules\Basket\Models\Basket;
use Plenty\Plugin\Log\Loggable;
/**
 * Class MiuraPaymentMethod
 * @package Miura\Methods
 */
class MiuraPaymentMethod extends PaymentMethodService
{
    use Loggable;
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

        $this->getLogger(MiuraHelper::LOGGER_KEY)->debug(__CLASS__.'->'.__FUNCTION__);
        /** @var bool $active */
        $active = true;

        /** @var Basket $basket
        $basket = $basketRepositoryContract->load();*/


        /**
         * Check whether the invoice address is the same as the shipping address

        if( $configRepository->get('Invoice.invoiceAddressEqualShippingAddress') == 1)
        {
            $active = false;
        }*/

        /**
        * Check whether the user is logged in

        if( $configRepository->get('Invoice.disallowInvoiceForGuest') == 1)
        {
            $active = false;
        }*/

        return $active;
    }

    /**
     * Get the name of the payment method. The name can be entered in the config.json.
     *
     * @param ConfigRepository $configRepository
     * @return string
     */
    public function getName( ConfigRepository $configRepository ):string
    {
        $this->getLogger(MiuraHelper::LOGGER_KEY)->debug(__CLASS__.'->'.__FUNCTION__);
        return MiuraHelper::PAYMENT_METHOD_NAME;
    }



    /**
     * Get the description of the payment method.
     *
     * @param ConfigRepository $configRepository
     * @return string
     */
    public function getDescription( ConfigRepository $configRepository ):string
    {
        $this->getLogger(MiuraHelper::LOGGER_KEY)->debug(__CLASS__.'->'.__FUNCTION__);
        return 'No description';
    }
}
