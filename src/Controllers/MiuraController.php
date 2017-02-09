<?php
namespace Miura\Controllers;

use Miura\Helper\MiuraHelper;
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

        $this->getLogger(MiuraHelper::LOGGER_KEY)->debug(__CLASS__.'->'.__FUNCTION__);
        return array('test' => 'kay');
    }
}