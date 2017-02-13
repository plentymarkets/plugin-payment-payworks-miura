<?php

namespace PayworksMiura\Controllers;

use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;

class SettingsController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function echoIt(Request $request)
    {
        return ['foo' => 'bar'];
    }
}