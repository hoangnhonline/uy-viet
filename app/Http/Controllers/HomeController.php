<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use App\Quotation;
use App\Models\Settings;
use App\Models\Shop;
use App\Models\SelectCondition;
use App\Models\Province;
use App\Models\Account;
use App\Models\Company;
use App\Models\District;
use App\Models\Ward;
use App\Models\Image;
use App\Models\ShopType;

use Helper, Auth, Schema, URL, Session;

class HomeController
{

    public function initPage(Request $request) {        
        if(!Auth::check()){
            return redirect()->route('login-form');
        }
        //dd($request->all());
        $total = 0;
        $arrMau = [];
        $is_color = 0;
        $column_mau = $request->column_mau ? $request->column_mau : null;
        $settingArr = $provinceArr = [];
        $districtList = $wardList = District::where('province_id', 9999)->get();
        $loginType = Auth::user()->type;
        $loginId = Auth::user()->id;

        $province_id = $request->province_id ? $request->province_id : null;
        $district_id = $request->district_id ? $request->district_id : null;        
        $ward_id = $request->ward_id ? $request->ward_id : null;       
        $keyword = $request->name ? $request->name : null;

        // get typeArr 
        $tmpST = ShopType::where('status', 1)->select('id')->get();
        foreach ($tmpST as $key => $value) {
            $typeArrDefault[] = $value->id;
        }
        
        $typeArr = $request->type ? $request->type : $typeArrDefault;

        // condition 
         $conditionList = SelectCondition::where('status', 1)->orderBy('col_order')->get();
         foreach($conditionList as $cond){
            $arrConditionName[] = $cond->name."_id";
         }

         foreach($arrConditionName as $condition_id){
            if($request->has($condition_id)){
                $arrSearchCondition[$condition_id] = $request->$condition_id;
            }else{
                $arrSearchCondition[$condition_id] = null;
            }
         }
         
        if($loginType == 1){
            $company_id = $request->company_id ? $request->company_id : Company::first()->id;
        }else{
            $company_id = Auth::user()->company_id;
        }   

        //get list user
        $tmpUser = Account::getUserIdChild($loginId, $loginType, $company_id);
      //  dd($tmpUser);
        $markerArr = [];
        if(!$province_id && !$district_id && !$ward_id){ // home
            $view = 'province';            
            if($loginType > 1){
                $query = Shop::where('shop.status', 1)
                                ->whereIn('shop.user_id', $tmpUser['userId'])
                                ->where('shop.company_id', $company_id)
                                //->whereRaw(' shop.type_id IN ( SELECT id FROM shop_type WHERE status = 1) ')
                                ->whereIn('shop.type_id', $typeArr);
                                if($keyword){
                                    $query->where('shop.shop_name', 'LIKE', '%'.$keyword."%");
                                }
                    $query->join('shop_select_condition', function ($join) use ($arrSearchCondition){
                

                        $join->on('shop.id', '=', 'shop_select_condition.shop_id');
                        
                        foreach($arrSearchCondition as $condition_column => $conditionArrValue){                             
                             if($conditionArrValue){
                                 $join->whereIn($condition_column, $conditionArrValue);
                            }
                        }

                    });

                    $query->select(DB::raw('MAX(`location`) as location'), 'province_id', DB::raw('COUNT(`shop`.`id`) as total'));
                    if($loginType > 2){
                    $query->whereRaw('province_id IN (SELECT province_id FROM user_province WHERE user_id = '.$loginId.')');
                    }
                    $query->groupBy('province_id');
                    $markerHasShop =  $query->get();
            }else{                
                $query = Shop::where('status', 1)->where('company_id', $company_id)
                //->whereRaw(' shop.type_id IN ( SELECT id FROM shop_type WHERE status = 1) ')
                ->select(DB::raw('MAX(`location`) as location'), 'shop.province_id', DB::raw('COUNT(`shop`.`id`) as total'))
                ->whereIn('shop.type_id', $typeArr);
                if($keyword){
                        $query->where('shop.shop_name', 'LIKE', '%'.$keyword."%");
                    }
                $query->join('shop_select_condition', function ($join) use ($arrSearchCondition){
                

                    $join->on('shop.id', '=', 'shop_select_condition.shop_id');
                    
                    foreach($arrSearchCondition as $condition_column => $conditionArrValue){                             
                         if($conditionArrValue){
                             $join->whereIn($condition_column, $conditionArrValue);
                        }
                    }

                });
                
                $query->groupBy('province_id');
                $markerHasShop = $query->get();
            }
            foreach($markerHasShop as $marker){
                $location = $marker->location;
                $tmp = explode(",", $location);            
                $markerArr[$marker->province_id]['location'] = $tmp;
                $markerArr[$marker->province_id]['total'] = $marker->total;
                $markerArr[$marker->province_id]['slug'] = $marker->slug;

            }
        }elseif($province_id > 0 && !$district_id && !$ward_id) { // search theo province_id
            //dd($company_id);
            $view = 'district';
            //dd($company_id);
            $districtList = District::where('province_id', $province_id)->orderBy('name')->get();            
            //district marker
            $query = Shop::where('status', 1)
                                ->where('province_id', $province_id);
                                if($loginType > 1){
                                    $query->whereIn('shop.user_id', $tmpUser['userId']);
                                }
                                $query->where('company_id', $company_id)
                                ->whereIn('shop.type_id', $typeArr);
                                if($keyword){
                                    $query->where('shop.shop_name', 'LIKE', '%'.$keyword."%");
                                }
                                $query->join('shop_select_condition', function ($join) use ($arrSearchCondition){
                

                        $join->on('shop.id', '=', 'shop_select_condition.shop_id');
                        
                        foreach($arrSearchCondition as $condition_column => $conditionArrValue){                             
                             if($conditionArrValue){
                                 $join->whereIn($condition_column, $conditionArrValue);
                            }
                        }

                    });                              
                    $markerHasShop = $query->select(DB::raw('MAX(`location`) as location'), 'district_id', DB::raw('COUNT(`shop`.`id`) as total'))
                                ->groupBy('district_id')
                                ->get();
            
            foreach($markerHasShop as $marker){
                $location = $marker->location;
                $tmp = explode(",", $location);            
                $markerArr[$marker->district_id]['location'] = $tmp;
                $markerArr[$marker->district_id]['total'] = $marker->total;
                $markerArr[$marker->district_id]['slug'] = $marker->total;

            }                    
        }elseif($province_id > 0 && $district_id > 0 && !$ward_id){
            $view = 'ward';
            $districtList = District::where('province_id', $province_id)->orderBy('name')->get();            
            $wardList = Ward::where('district_id', $district_id)->orderBy('name')->get();            
            $query = Shop::where('status', 1)
                        ->where('district_id', $district_id);
                        if($loginType > 1){
                            $query->whereIn('shop.user_id', $tmpUser['userId']);
                        }
                        $query->where('company_id', $company_id)
                        ->whereIn('shop.type_id', $typeArr);
                        if($keyword){
                                    $query->where('shop.shop_name', 'LIKE', '%'.$keyword."%");
                                }
                         $query->join('shop_select_condition', function ($join) use ($arrSearchCondition){
                

                        $join->on('shop.id', '=', 'shop_select_condition.shop_id');
                        
                        foreach($arrSearchCondition as $condition_column => $conditionArrValue){                             
                             if($conditionArrValue){
                                 $join->whereIn($condition_column, $conditionArrValue);
                            }
                        }

                    });   

                        //->whereRaw(' shop.type_id IN ( SELECT id FROM shop_type WHERE status = 1) ')
                     $markerHasShop = $query->select(DB::raw('MAX(`location`) as location'), 'ward_id', DB::raw('COUNT(`shop`.`id`) as total'))
                        ->groupBy('ward_id')
                        ->get();  
                        //dd($markerHasShop);          
            foreach($markerHasShop as $marker){
                $location = $marker->location;
                $tmp = explode(",", $location);            
                $markerArr[$marker->ward_id]['location'] = $tmp;
                $markerArr[$marker->ward_id]['total'] = $marker->total;
                $markerArr[$marker->ward_id]['slug'] = $marker->total;

            }  
        }elseif($province_id > 0 && $district_id > 0 && $ward_id > 0){
            $view = 'detail';
            if($column_mau){
                $table_mau = str_replace('_id', '', $column_mau);
                $mauList = DB::table("shop_".$table_mau)->select('id', 'color')->get();
                foreach($mauList as $tmpMau){
                    $arrMau[$tmpMau->id] = str_replace("#", "", $tmpMau->color);
                }          
                $is_color = 1;  
            }            

            $districtList = District::where('province_id', $province_id)->orderBy('name')->get();            
            $wardList = Ward::where('district_id', $district_id)->orderBy('name')->get();            
            // not admin
            $query =  Shop::where('shop.status', 1);
            if($loginType > 1){
                $query->whereIn('user_id', $tmpUser['userId']);        
            }
        
            $query->where('shop.company_id', $company_id);        
        
            $query->where('shop.province_id', $province_id);
        
            $query->where('shop.district_id', $district_id);            
            
            $query->where('shop.ward_id', $ward_id);

            $query->whereIn('shop.type_id', $typeArr);
            if($keyword){
                $query->where('shop.shop_name', 'LIKE', '%'.$keyword."%");
            }
            $query->join('shop_select_condition', function ($join) use ($arrSearchCondition){                

                $join->on('shop.id', '=', 'shop_select_condition.shop_id');
                    
                foreach($arrSearchCondition as $condition_column => $conditionArrValue){                             
                     if($conditionArrValue){
                         $join->whereIn($condition_column, $conditionArrValue);
                    }
                }
            });           
          
            $query->join('shop_type', 'shop_type.id' , '=', 'shop.type_id');
            $query->select('shop.*', 'icon_url', 'shop_select_condition.*', 'shop.id as shop_id');
            $markerArr = $query->get()->toArray();
            $total = count($markerArr);
        }       
   
        $shopType = DB::select('select id,type, icon_url from shop_type where status = 1');
        
        $tmpArr = Settings::all();

        foreach($tmpArr as $tmp){
            $settingArr[$tmp->name] = $tmp->value;
        }
        
        $tmpUser = Account::getUserIdChild($loginId, $loginType, $company_id);

        $provinceDetailArr = [];

        if($loginType > 2){
            $listProvince = Province::whereRaw('id IN (SELECT province_id FROM user_province WHERE user_id = '.$loginId.')')->orderBy('name')->get();
        }else{
            $listProvince = Province::orderBy('name')->get();        
        }
        foreach($listProvince as $pro){
            $provinceDetailArr[$pro->id] = $pro;
        }
        
       
        $companyList = Company::all();

        $show_label = $request->show_label;
   //    dd($column_mau);
        return view('layouts.master', [
            'shopType' => $shopType,
            'listProvince' => $listProvince,            
            'conditionList' => $conditionList,
            'settingArr' => $settingArr,
            'provinceArr' => $provinceArr,
            'companyList' => $companyList,
            'provinceDetailArr' => $provinceDetailArr,
            'company_id' => $company_id,
            'typeArr' => $typeArr,
            'markerArr' => $markerArr,
            'view' => $view,
            'province_id' => $province_id,
            'district_id' => $district_id,
            'ward_id' => $ward_id,
            'districtList' => $districtList,
            'wardList' => $wardList,
            'typeArrDefault' => $typeArrDefault,
            'arrSearch' => $arrSearchCondition,
            'show_label' => $show_label,
            'total' => $total,
            'keyword' => $keyword,
            'arrMau' => $arrMau,
            'is_color' => $is_color,
            'column_mau' => $column_mau
        ]);

    }
    
    public function editShop(Request $request){
        $id = $request->id;
        $district_id = $request->district_id;
        $loginType = Auth::user()->type;
        $loginId = Auth::user()->id;
        if($loginType > 1){
            $provinceList = Province::whereRaw('id IN (SELECT province_id FROM user_province WHERE user_id = '.$loginId.')')->orderBy('name')->get();
        }else{
            $provinceList = Province::orderBy('name')->get();        
        }      
        
        $shopTypeList = ShopType::where('status', 1)->get();

        $conditionList = SelectCondition::where('status', 1)->orderBy('col_order')->get();
        
        $companyList = Company::all();
        
        $detail = Shop::where('shop.id', $id)
                ->join('shop_select_condition', 'shop_select_condition.shop_id', '=', 'shop.id')
                ->first();
                ;
        
        $districtList = (object)[];
        
        if($detail->province_id){
            $districtList = District::where('province_id', $detail->province_id)->orderBy('name')->get();
        }
        $wardList = (object)[];
        if($detail->district_id){
            $wardList = Ward::where('district_id', $detail->district_id)->orderBy('name')->get();
        }
        $hinhArr = [];
        $tmp = Image::where('shop_id', $id)->first();
        $folder = '';
        if($tmp){
            $folder = $tmp->url;
           
            $path = public_path()."/UY_VIET_DINH_VI/".$folder."/";

            if(is_dir($path)){                
                foreach(glob($path.'*') as $filename){                    
                    $hinhArr[] = config('app.url')."/UY_VIET_DINH_VI/".$folder."/".basename($filename);                    
                }
            }
        }
        return view('ajax.edit-shop', compact( 'detail', 'shopTypeList', 'companyList', 'provinceList', 'conditionList', 'districtList', 'wardList', 'hinhArr', 'folder', 'district_id'));
    }
    public function getImageThumbnail(Request $request){
        $id = $request->id;

        $firstImage =  config('app.url').'/public/assets/images/no-image.png';
        $have_image = 0;
        $tmp = Image::where('shop_id', $id)->first();
        if($tmp){
            $folder = $tmp->url;
           
            $path = public_path()."/UY_VIET_DINH_VI/".$folder."/";

            if(is_dir($path)){
                $i = 0;
                foreach(glob($path.'*') as $filename){
                    $i++;
                    if($i == 1){
                        $firstImage = config('app.url')."/public/UY_VIET_DINH_VI/".$folder."/".basename($filename);
                        $have_image = 1;
                    }                    
                }
            }
        }
        $conditionList = SelectCondition::where('status', 1)->orderBy('col_order')->get();
        $detail = Shop::where('shop.id', $id)
                ->join('shop_select_condition', 'shop_select_condition.shop_id', '=', 'shop.id')
                ->first();
                ;

        return view('ajax.show-detail', compact('firstImage', 'detail', 'have_image', 'conditionList'));
    }
    public function gallery(Request $request){
        $arr = [];
        $id = $request->id;

        $tmp = Image::where('shop_id', $id)->first();
        
            $folder = $tmp->url;
           
            $path = public_path()."/UY_VIET_DINH_VI/".$folder."/";

            if(is_dir($path)){                
                foreach(glob($path.'*') as $filename){                    
                    $arr[] = config('app.url')."/public/UY_VIET_DINH_VI/".$folder."/".basename($filename);                    
                }
            }
        
        return view('ajax.gallery', [
            'arr' => $arr
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

}
