<?php

namespace PayworksMiura\Controllers;

use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\ConfigRepository;
use Plenty\Modules\Payment\Method\Repositories\PaymentMethodRepository;

class SettingsController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function configuration(Request $request)
    {

        $repo = pluginApp( ConfigRepository::class );

        $repoMop = pluginApp( PaymentMethodRepository::class );

        $response['identifier']                             = $repo->get('PayworksMiura.merchant_identifier');
        $response['merchantSecretKey']                      = $repo->get('PayworksMiura.merchant_secret_key');
        $response['sepaLastschriftmandat']                  = $repo->get('PayworksMiura.sepa_lastschriftmandat');
        $response['datenschutzrechtlicheInformationen']     = $repo->get('PayworksMiura.datenschutzrechtliche_informationen');
        $response['methodsOfPayment'] = [
            'Visa'              => 10001,
            'VisaElectron'      => 10002,
            'AmericanExpress'   => 10003,
            'Maestro'           => 10004,
            'MasterCard'        => 10005
        ];

        return $response;
    }
}