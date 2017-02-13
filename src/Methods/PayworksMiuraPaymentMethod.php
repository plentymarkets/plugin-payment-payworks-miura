<?php //strict

namespace PayworksMiura\Methods;

use Plenty\Modules\Payment\Method\Contracts\PaymentMethodService;
use Plenty\Plugin\ConfigRepository;
use Plenty\Modules\Basket\Contracts\BasketRepositoryContract;
use Plenty\Modules\Basket\Models\Basket;

/**
 * Class PayworksMiuraPaymentMethod
 * @package PayworksMiura\Methods
 */
class PayworksMiuraPaymentMethod extends PaymentMethodService
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

        /** @var Basket $basket */
        $basket = $basketRepositoryContract->load();

        /**
         * Check the minimum amount
         */
        if( $configRepository->get('PayworksMiura.minimumAmount') > 0.00 &&
            $basket->basketAmount < $configRepository->get('PayworksMiura.minimumAmount'))
        {
            $active = false;
        }

        /**
         * Check the maximum amount
         */
        if( $configRepository->get('PayworksMiura.maximumAmount') > 0.00 &&
            $configRepository->get('PayworksMiura.maximumAmount') < $basket->basketAmount)
        {
            $active = false;
        }

        /**
         * Check whether the PayworksMiura address is the same as the shipping address
         */
        if( $configRepository->get('PayworksMiura.invoiceAddressEqualShippingAddress') == 1)
        {
            $active = false;
        }

        /**
        * Check whether the user is logged in
        */
        if( $configRepository->get('PayworksMiura.disallowInvoiceForGuest') == 1)
        {
            $active = false;
        }

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
        $name = $configRepository->get('PayworksMiura.name');

        if(!strlen($name))
        {
            $name = 'PayworksMiura';
        }

        return $name;

    }

    /**
     * Get additional costs for the payment method. Additional costs can be entered in the config.json.
     *
     * @param ConfigRepository $configRepository
     * @param BasketRepositoryContract $basketRepositoryContract
     * @return float
     */
    public function getFee( ConfigRepository $configRepository,
                            BasketRepositoryContract $basketRepositoryContract):float
    {
        $basket = $basketRepositoryContract->load();
        if($basket->shippingCountryId == 1)
        {
            return $configRepository->get('PayworksMiura.fee.domestic');
        }
        else
        {
            return $configRepository->get('PayworksMiura.fee.foreign');
        }
    }

    /**
     * Get the path of the icon
     *
     * @param ConfigRepository $configRepository
     * @return string
     */
    public function getIcon( ConfigRepository $configRepository ):string
    {
        if($configRepository->get('PayworksMiura.logo') == 1)
        {
            return $configRepository->get('PayworksMiura.logo.url');
        }
        return '';
    }

    /**
     * Get the description of the payment method. The description can be entered in the config.json.
     *
     * @param ConfigRepository $configRepository
     * @return string
     */
    public function getDescription( ConfigRepository $configRepository ):string
    {
        if($configRepository->get('PayworksMiura.infoPage.type') == 1)
        {
            return $configRepository->get('PayworksMiura.infoPage.intern');
        }
        elseif ($configRepository->get('PayworksMiura.infoPage.type') == 2)
        {
            return $configRepository->get('PayworksMiura.infoPage.extern');
        }
        else
        {
          return '';
        }
    }
}
