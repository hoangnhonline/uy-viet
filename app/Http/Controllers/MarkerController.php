<?php
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