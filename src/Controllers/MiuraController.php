<?php
namespace Miura\Controllers;

use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Log\Loggable;
/**
 * Created by IntelliJ IDEA.
 * User: jahnalexanderhane
 * Date: 08.02.17
 * Time: 15:53
 */
class MiuraController  extends Controller
{
    use Loggable;
    /**
     * @param Request $request
     * @return array
     */
    public function echoIt(Request $request) {

        return array('test' => 'kay');
    }

    public function methods(Request $request) {
        return [
            'visa' => ['foo' => 'bar']
        ];
    }
    public function methodByKey(Request $request) {
        return [];
    }
}