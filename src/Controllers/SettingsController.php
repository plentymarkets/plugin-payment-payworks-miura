<?php

namespace PayworksMiura\Controllers;

use PayworksMiura\Helper\PayworksMiuraHelper;

use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\ConfigRepository;
use Plenty\Modules\Payment\Method\Contracts\PaymentMethodRepositoryContract;

class SettingsController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function configuration(Request $request)
    {

        //fetch plugin config
        $repo = pluginApp( ConfigRepository::class );

        $response['identifier']                             = $repo->get('PayworksMiura.merchant_identifier');
        $response['merchantSecretKey']                      = $repo->get('PayworksMiura.merchant_secret_key');
        $response['sepaLastschriftmandat']                  = $repo->get('PayworksMiura.sepa_lastschriftmandat');
        $response['datenschutzrechtlicheInformationen']     = $repo->get('PayworksMiura.datenschutzrechtliche_informationen');


        //fetch registered payment method info
        /**
         * @var $repoMop PaymentMethodRepositoryContract
         */
        $repoMop = pluginApp( PaymentMethodRepositoryContract::class );

        $mopModels = $repoMop->allForPlugin(PayworksMiuraHelper::PLUGIN_KEY);
        foreach($mopModels as $mopModel) {
            /**
             * @var $mopModel Plenty\Modules\Payment\Method\Models\PaymentMethod
             */
            $response['methodsOfPayment'][$mopModel->paymentKey] = $mopModel->id;
        }

        return $response;
    }
}