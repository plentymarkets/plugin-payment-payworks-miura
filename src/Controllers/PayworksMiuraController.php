<?php
namespace MiuraPayworks\Controllers;

use Plenty\Modules\Plugin\DataBase\Contracts\DataBase;
use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Log\Loggable;
/**
 * Created by IntelliJ IDEA.
 * User: jahnalexanderhane
 * Date: 08.02.17
 * Time: 15:53
 */
class PayworksMiuraController  extends Controller
{
    use Loggable;
    /**
     * @param Request $request
     * @return array
     */
    public function echoIt(Request $request) {

        return array('test' => 'okay');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function configuration(Request $request) {
        /** @var DataBase $repository */
        $repository = pluginApp(DataBase::class);

        return [];

    }

}