<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Hash;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\GroupUser;
use App\Models\Company;
use App\Models\Province;
use App\Models\ShopType;
use App\Models\UserProvince;
use App\Models\Shop;
use App\Models\District;
use App\Models\Ward;
use App\Models\Image;
use App\Models\ShopSelectCondition;

use Helper, File, Session, Auth;

class GetController extends Controller
{
    public function login(Request $request)
    {   
        $arrDefault = [
            'id' => '',
            'username' => '',
            'fullname' => '',
            'email' => '',
            'type' => '',
            'phone' => '',
            'status' => '',
            'create_time' => '',
            'company_id' => '',
            'created_at' => '',
            'updated_at' => ''
        ];
        $info = $request->info;

        $dataArr  = json_decode($info, true);   
       
        if (Auth::validate($dataArr)) {

            if (Auth::attempt($dataArr)) {              
                $arrDefault = Auth::user();              
            }

        }
        return json_encode($arrDefault);
    }

    public function addPoint(Request $request)
    {          
        $info = $request->info;

        $dataArr  = json_decode($info, true);   
        
        $detailUser = Account::find($dataArr['user_id']);
        
        $dataArr['company_id'] = $detailUser->company_id;

        $wardDetail = Ward::find($dataArr['ward_id']);
        $districtDetail = District::find($dataArr['district_id']);
        $provinceDetail = Province::find($dataArr['province_id']);
        $dataArr['full_address'] = $dataArr['address']. ", ". $dataArr['street']. ", ". $wardDetail->name. ", ". $districtDetail->name. ", ". $provinceDetail->name ;
        $dataArr['add_time'] = date('Y-m-d H:i:s', time());        
        $rs = Shop::create($dataArr);
        if($rs->id ){         
            ShopSelectCondition::create(['shop_id' => $rs->id]);
            Image::create(['url' => $dataArr['image'], 'shop_id' => $rs->id]);   
            $result = "Successful";
        }else{
            $result = "fail";
        }
        return $result;
    }

    public function search(Request $request){
        
        $info = $request->info;
        
        $dataArr = json_decode($info, true);
        
        $shop_name = $dataArr['shop_name'];

        $user_id = $dataArr['user_id'];
        
        $index = isset($dataArr['index']) ? $dataArr['index'] : 1;
        $start = ( $index -1 )* 20;
        $result = Shop::where('user_id', $user_id)->where('shop_name', 'LIKE', '%'.$shop_name.'%')
            ->join('province', 'shop.province_id', '=', 'province.id')
            ->join('district', 'shop.district_id', '=', 'district.id')
            ->join('ward', 'shop.ward_id', '=', 'ward.id')
            ->join('image', 'shop.id', '=', 'image.shop_id')
            ->select('shop.*', 'ward.name as ward_name', 'district.name as district_name', 'province.name as province_name', 'image.url as image')
            ->offset($start)
            ->limit(20)
        ->get()->toArray();

        return json_encode($result);

    }

    public function province(Request $request){
        $rs = Province::select('id', 'name')->get()->toArray();
        return json_encode($rs);
    }
    public function shoptype(Request $request){
        $rs = ShopType::select('id', 'type')->orderBy('col_order')->get()->toArray();
        return json_encode($rs);
    }
    public function district(Request $request){
        $province_id = $request->province_id ? $request->province_id : null;
        
        if($province_id){
            $rs = District::where('province_id', $province_id)->select('id', 'name')->get()->toArray();
        }else{
            $rs = District::select('id', 'name', 'province_id')->get()->toArray();
        }
        return json_encode($rs);
    }
    public function ward(Request $request){
        $district_id = $request->district_id ? $request->district_id : null;
      
        if($district_id){
            $rs = Ward::where('district_id', $district_id)->select('id', 'name')->get()->toArray();
        }else{
            $rs = Ward::select('id', 'name', 'district_id')->get()->toArray();
        }
        return json_encode($rs);
    }
}
