<?php //strict

namespace Miura\Methods;

use Plenty\Modules\Payment\Method\Contracts\PaymentMethodService;
use Plenty\Plugin\ConfigRepository;
use Plenty\Modules\Basket\Contracts\BasketRepositoryContract;
use Plenty\Modules\Basket\Models\Basket;

/**
 * Class MiuraPaymentMethod
 * @package Miura\Methods
 */
class MiuraPaymentMethod extends PaymentMethodService
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
        $name = $configRepository->get('Miura.name');

        if(!strlen($name))
        {
            $name = 'Miura';
        }

        return $name;

    }



    /**
     * Get the description of the payment method.
     *
     * @param ConfigRepository $configRepository
     * @return string
     */
    public function getDescription( ConfigRepository $configRepository ):string
    {
        return 'No description';
    }
}
