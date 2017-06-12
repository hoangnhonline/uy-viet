<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 16/01/2017
 * Time: 11:08 SA
 */

namespace App\Http\Controllers;
use App\Http\Requests;
use DB;
use App\Quotation;
use Illuminate\Http\Request;


class MarkerController extends HomeController
{
    public function initPageWithMarker($marker)
    {
        $this->initPage();
    }
}