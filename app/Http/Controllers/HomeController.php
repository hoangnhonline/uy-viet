<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 14/01/2017
 * Time: 9:58 CH
 */

namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use App\Quotation;
use App\Models\Settings;
use App\Models\Shop;
use App\Models\SelectCondition;

use Helper, Auth, Schema;

class HomeController
{

    public function initPage() {        
        $settingArr = $provinceArr = [];
        $tmpArr = Settings::all();
        foreach($tmpArr as $tmp){
            $settingArr[$tmp->name] = $tmp->value;
        }
        if(!Auth::check()){
            return redirect()->route('login-form');
        }
        $shopType = DB::select('select id,type, icon_url from shop_type where status = 1');
        $listProvince = DB::select('select id,name from province');        
        $conditionList = SelectCondition::orderBy('col_order')->get();

        $provinceHasShop = Shop::where('status', 1)
                //->whereRaw(' shop.type_id IN ( SELECT id FROM shop_type WHERE status = 1) ')
                ->select(DB::raw('MAX(`location`) as location'), 'province_id', DB::raw('COUNT(`id`) as total'))->groupBy('province_id')->get();
        foreach($provinceHasShop as $pro){
            $location = $pro->location;
            $tmp = explode(",", $location);            
            $provinceArr[$pro->province_id]['location'] = $tmp;
            $provinceArr[$pro->province_id]['total'] = $pro->total;

        }
       

        return view('layouts.master', [
            'shopType' => $shopType,
            'listProvince' => $listProvince,            
            'conditionList' => $conditionList,
            'settingArr' => $settingArr,
            'provinceArr' => $provinceArr
        ]);

    }

    public function loginForm()
    {
        /*User::create(array(
            'full_name'     => 'Andy',            
            'email'    => 'andy2016@gmail.com',
            'password' => Hash::make('matkhaucuatui'),
            'role' => 1,
            'status' => 1
        ));*/               
        return view('layouts.login');
    }

    public function findItem(Request $request) {
        $filter = $request->input();
        if ($filter['districtId'] =='' || $filter['districtId'] == 0 ){
            $location = DB::select('select shop.*, icon_url, shop_select_condition.* from shop, shop_type, shop_select_condition where (type_id = shop_type.id) and(user_id = ?) and (shop.id = shop_select_condition.shop_id) and (shop.province_id = ?)',[$filter['userId'],$filter['provinceId']]);
        }
        else{
            if ($filter['wardId'] == '' || $filter['wardId'] == 0) {
                $location = DB::select('select shop.*, icon_url, shop_select_condition.* from shop, shop_type, shop_select_condition where (type_id = shop_type.id) and(user_id = ?) and (shop.id = shop_select_condition.shop_id)
                                    and (shop.province_id = ?) and (shop.district_id = ?)',
                                    [$filter['userId'], $filter['provinceId'], $filter['districtId']]);
            }
            else {
                $location = DB::select('select shop.*, icon_url, shop_select_condition.* from shop, shop_type, shop_select_condition where (type_id = shop_type.id) and(user_id = ?) and (shop.id = shop_select_condition.shop_id)
                                    and (shop.province_id = ?) and (shop.district_id = ?) and (shop.ward_id = ?) ',
                                    [$filter['userId'], $filter['provinceId'], $filter['districtId'], $filter['wardId']]);
            }
        }

        return \Response::json($location);
    }

    public function getInfoShop(Request $request) {
        $shopId = $request->input('id');
        $infoLocation = DB::select('select shop.*, shop_select_condition.* from shop, shop_select_condition 
                                    where (shop.id = shop_select_condition.shop_id) and  shop.id = ?',[$shopId]);
        return \Response::json($infoLocation);
    }

    public function getDistrictList(Request $request) {
        $provinceId = $request->input('provinceId');
        $listDistrict = DB::select('select id, name from district where province_id = ?',[$provinceId]);
        return \Response::json($listDistrict);
    }

    public function getWardList(Request $request) {
        $districtId = $request->input('districtId');
        $listWard = DB::select('select id, name from ward where district_id = ?',[$districtId]);
        return \Response::json($listWard);
    }
    
    public function doLogin2(Request $request)
    {
        $info = $request->input();
        $passMd5 = md5($info['pass']);;
        $login = DB::select('select id, fullname from user where username = ? and password = ? limit 1', [$info['user'], $passMd5]);
        if (!empty($login)) {
            session(['userId' => $login[0]->id,
                'fullname' => $login[0]->fullname
            ]);
            return \Response::json(0);

        }
        else {
            return \Response::json(1);
        }
    }

    public function doLogin(Request $request)
    {
        $dataArr = $request->all();
        // if any error send back with message.
        if($request->username == '' || $request->password == ''){
            Session::flash('error', 'Vui lòng nhập đầy đủ Username và Mật khẩu'); 
            return redirect()->route('backend.login-form');
        }
        
        $dataArr = [
            'username' => $request->username,
            'password' => $request->password,
        ];
        if (Auth::validate($dataArr)) {

            if (Auth::attempt($dataArr)) {
              
                return redirect()->route('home');
              
            }

        }else {
            // if any error send back with message.
            Session::flash('error', 'Email hoặc mật khẩu không đúng.'); 
            return redirect()->route('login-form');
        }

        return redirect()->route('home');
    }


    public function doLogout() {
        Auth::logout();
        return redirect()->route('login-form');
    }

    public function doEditMarker(Request $request) {
        $info = $request->input();
        try {

            DB::table('shop')
                ->where('id', $info['id'])
                ->update(['shop_name' => $info['shop_name'],
                        'full_address' => $info['full_address'],
                        'namer' => $info['namer'],
                        'phone' => $info['phone'],
                ]);

            DB::table('shop_select_condition')
                ->where('shop_id', $info['id'])
                ->update(['quy_mo1480440358_id' => $info['quy_mo1480440358_id'],
                        'cap_do_1480213548_id' => $info['cap_do_1480213548_id'],
                        'tiem_nang1480213595_id' => $info['tiem_nang1480213595_id'],
                ]);
            return \Response::json(1);
        }catch(\Exception $e){
            return \Response::json(0);
        }

    }

    public function editMarkerUI($shopid){
        $info = DB::select('select id, location from shop where id = ?',[$shopid]);
        $marker = $info[0];
        return view('editMarker', ['marker' => $marker]);
    }

    public function updateMarker(Request $request){
        $info = $request->input();
        try {

            DB::table('shop')
                ->where('id', $info['shopId'])
                ->update(['location' => $info['position']]);

            return \Response::json(0);
        }catch(\Exception $e){
            return \Response::json(1);
        }

    }

    public function initPageWithMarker($shopid) {
        $initPage = $this->initPage()->getData();
        $init_location = DB::select('select shop.*, icon_url from shop, shop_type where (type_id = shop_type.id) and shop.id = ?',[$shopid]);
        return view('home', [
            'shopType' => $initPage['shopType'],
            'listProvince' => $initPage['listProvince'],
            'levels' => $initPage['levels'],
            'tiemnang' =>$initPage['tiemnang'],
            'quymo' => $initPage['quymo'],
            'init_location'=> $init_location[0],
        ]);
    }

    public function getRelateLocation (Request $request) {
        $shopId = $request->input('shopId');
        $detailRelate = DB::select('select * from shop where shop.id = ?',[$shopId]);
        $relateLocation = DB::select('select shop.*, icon_url from shop, shop_type where (type_id = shop_type.id) and shop.province_id= ? and shop.district_id= ?',[$detailRelate[0]->province_id,$detailRelate[0]->district_id]);
        return \Response::json($relateLocation);
    }

}
