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
        $settingArr = $provinceArr = [];
        $districtList = $wardList = District::where('province_id', 9999)->get();
        $loginType = Auth::user()->type;
        $loginId = Auth::user()->id;

        $province_id = $request->province_id ? $request->province_id : null;
        $district_id = $request->district_id ? $request->district_id : null;        
        $ward_id = $request->ward_id ? $request->ward_id : null;       

        // get typeArr 
        $tmpST = ShopType::where('status', 1)->select('id')->get();
        foreach ($tmpST as $key => $value) {
            $typeArrDefault[] = $value->id;
        }
        
        $typeArr = $request->type ? $request->type : $typeArrDefault;

        // condition 
         $conditionList = SelectCondition::orderBy('col_order')->get();
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
         //dd($arrSearch);
        if($loginType == 1){
            $company_id = $request->company_id ? $request->company_id : Company::first()->id;
        }else{
            $company_id = Auth::user()->company_id;
        }   

        //get list user
        $tmpUser = Account::getUserIdChild($loginId, $loginType, $company_id);
               
        $markerArr = [];
        if(!$province_id && !$district_id && !$ward_id){ // home
            $view = 'province';
            $conditionList = SelectCondition::orderBy('col_order')->get();
            if($loginType > 1){
                $markerHasShop = Shop::where('shop.status', 1)
                                ->whereIn('shop.user_id', $tmpUser['userId'])
                                ->where('shop.company_id', $company_id)
                                //->whereRaw(' shop.type_id IN ( SELECT id FROM shop_type WHERE status = 1) ')
                                ->whereIn('shop.type_id', $typeArr)
                                ->select(DB::raw('MAX(`location`) as location'), 'province_id', DB::raw('COUNT(`shop`.`id`) as total'))
                                ->whereRaw('province_id IN (SELECT province_id FROM user_province WHERE user_id = '.$loginId.')')
                                ->groupBy('province_id')
                                ->get();
            }else{
                $query = Shop::where('status', 1)->where('company_id', $company_id)
                //->whereRaw(' shop.type_id IN ( SELECT id FROM shop_type WHERE status = 1) ')
                ->select(DB::raw('MAX(`location`) as location'), 'shop.province_id', DB::raw('COUNT(`shop`.`id`) as total'))
                ->whereIn('shop.type_id', $typeArr);
                
                    $query->join('shop_select_condition', function ($join) use ($arrSearchCondition){
                    

                        $join->on('shop.id', '=', 'shop_select_condition.shop_id');
                        foreach($arrSearchCondition as $condition_column => $conditionArrValue){
                             $join->whereIn($condition_column, $conditionArrValue);
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
           // die('123');
            $view = 'district';
            $districtList = District::where('province_id', $province_id)->get();            
            //district marker
            $markerHasShop = Shop::where('status', 1)
                                ->where('province_id', $province_id)
                                ->whereIn('shop.user_id', $tmpUser['userId'])
                                ->where('company_id', $company_id)
                                ->whereIn('shop.type_id', $typeArr)                              
                                ->select(DB::raw('MAX(`location`) as location'), 'district_id', DB::raw('COUNT(`id`) as total'))
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
            $districtList = District::where('province_id', $province_id)->get();            
            $wardList = Ward::where('district_id', $district_id)->get();            
            $markerHasShop = Shop::where('status', 1)
                        ->where('district_id', $district_id)
                        ->whereIn('shop.user_id', $tmpUser['userId'])
                        ->where('company_id', $company_id)
                        ->whereIn('shop.type_id', $typeArr)
                        //->whereRaw(' shop.type_id IN ( SELECT id FROM shop_type WHERE status = 1) ')
                        ->select(DB::raw('MAX(`location`) as location'), 'ward_id', DB::raw('COUNT(`id`) as total'))
                        ->groupBy('ward_id')
                        ->get();            
            foreach($markerHasShop as $marker){
                $location = $marker->location;
                $tmp = explode(",", $location);            
                $markerArr[$marker->ward_id]['location'] = $tmp;
                $markerArr[$marker->ward_id]['total'] = $marker->total;
                $markerArr[$marker->ward_id]['slug'] = $marker->total;

            }  
        }elseif($province_id > 0 && $district_id > 0 && $ward_id > 0){
            $view = 'detail';
            $districtList = District::where('province_id', $province_id)->get();            
            $wardList = Ward::where('district_id', $district_id)->get();            
            // not admin
            $query =  Shop::where('shop.status', 1);
            
            $query->whereIn('user_id', $tmpUser['userId']);        
        
            $query->where('shop.company_id', $company_id);        
        
            $query->where('shop.province_id', $province_id);
        
            $query->where('shop.district_id', $district_id);            
            
            $query->where('shop.ward_id', $ward_id);

            $query->whereIn('shop.type_id', $typeArr);
            
            $query->join('shop_select_condition', 'shop_select_condition.shop_id', '=', 'shop.id');
            $query->join('shop_type', 'shop_type.id' , '=', 'shop.type_id');
            $query->select('shop.*', 'icon_url', 'shop_select_condition.*');
            $markerArr = $query->get()->toArray();
        }       
   
        $shopType = DB::select('select id,type, icon_url from shop_type where status = 1');

        
        $tmpArr = Settings::all();
        foreach($tmpArr as $tmp){
            $settingArr[$tmp->name] = $tmp->value;
        }
        if(!Auth::check()){
            return redirect()->route('login-form');
        }
          
        
        $tmpUser = Account::getUserIdChild($loginId, $loginType, $company_id);

        $provinceDetailArr = [];

        if($loginType > 1){
            $listProvince = Province::whereRaw('id IN (SELECT province_id FROM user_province WHERE user_id = '.$loginId.')')->get();
        }else{
            $listProvince = Province::all();        
        }
        foreach($listProvince as $pro){
            $provinceDetailArr[$pro->id] = $pro;
        }
        
       
        $companyList = Company::all();
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
            'arrSearch' => $arrSearchCondition
        ]);

    }
    
    public function districtMarker(Request $request) {        
        $province_id = $request->province_id;

        $settingArr = $provinceArr = [];
        $tmpArr = Settings::all();
        foreach($tmpArr as $tmp){
            $settingArr[$tmp->name] = $tmp->value;
        }
        if(!Auth::check()){
            return redirect()->route('login-form');
        }
        $loginType = Auth::user()->type;
        $loginId = Auth::user()->id;

        $shopType = DB::select('select id,type, icon_url from shop_type where status = 1');

        $company_id = $loginType > 1 ? Auth::user()->company_id : Company::first()->id;

        $tmpUser = Account::getUserIdChild($loginId, $loginType, $company_id);

        $provinceDetailArr = [];
        $districtArr = [];

        if($loginType > 1){
            $listProvince = Province::whereRaw('id IN (SELECT province_id FROM user_province WHERE user_id = '.$loginId.')')->get();
        }else{
            $listProvince = Province::all();        
        }
        foreach($listProvince as $pro){
            $provinceDetailArr[$pro->id] = $pro;
        }
      
        $conditionList = SelectCondition::orderBy('col_order')->get();
        //dd($company_id);
        $districtHasShop = Shop::where('status', 1)
                            ->where('province_id', $province_id)
                            ->whereIn('shop.user_id', $tmpUser['userId'])
                            ->where('company_id', $company_id)
                            //->whereRaw(' shop.type_id IN ( SELECT id FROM shop_type WHERE status = 1) ')
                            ->select(DB::raw('MAX(`location`) as location'), 'district_id', DB::raw('COUNT(`id`) as total'))
                            ->groupBy('district_id')
                            ->get();
        
        foreach($districtHasShop as $pro){
            $location = $pro->location;
            $tmp = explode(",", $location);            
            $districtArr[$pro->district_id]['location'] = $tmp;
            $districtArr[$pro->district_id]['total'] = $pro->total;
            $districtArr[$pro->district_id]['slug'] = $pro->total;

        }        
        $companyList = Company::all();
        $districtList = District::where('province_id', $province_id)->get();
        return view('layouts.district', [
            'shopType' => $shopType,
            'listProvince' => $listProvince,            
            'conditionList' => $conditionList,
            'settingArr' => $settingArr,
            'districtArr' => $districtArr,
            'companyList' => $companyList,
            'provinceDetailArr' => $provinceDetailArr,
            'province_id' => $province_id,
            'company_id' => $company_id,
            'districtList' => $districtList
        ]);

    }
    public function wardMarker(Request $request) {        
        $district_id = $request->district_id;        
        $districtDetail = District::find($district_id);
        $settingArr = $provinceArr = [];
        $tmpArr = Settings::all();
        foreach($tmpArr as $tmp){
            $settingArr[$tmp->name] = $tmp->value;
        }
        if(!Auth::check()){
            return redirect()->route('login-form');
        }
        $loginType = Auth::user()->type;
        $loginId = Auth::user()->id;
        $company_id = $loginType > 1 ? Auth::user()->company_id : Company::first()->id;

        $tmpUser = Account::getUserIdChild($loginId, $loginType, $company_id);
        
        $provinceDetailArr = [];

        $shopType = DB::select('select id,type, icon_url from shop_type where status = 1');
        if($loginType > 1){
            $listProvince = Province::whereRaw('id IN (SELECT province_id FROM user_province WHERE user_id = '.$loginId.')')->get();
        }else{
            $listProvince = Province::all();        
        }
        foreach($listProvince as $pro){
            $provinceDetailArr[$pro->id] = $pro;
        }        
        $province_id = $districtDetail->province_id;
        $districtList = District::where('province_id', $province_id)->get();
        $wardList = Ward::where('district_id', $district_id)->get();
        $conditionList = SelectCondition::orderBy('col_order')->get();
        
        $wardHasShop = Shop::where('status', 1)->where('district_id', $district_id)->whereIn('shop.user_id', $tmpUser['userId'])->where('company_id', $company_id)
        //->whereRaw(' shop.type_id IN ( SELECT id FROM shop_type WHERE status = 1) ')
        ->select(DB::raw('MAX(`location`) as location'), 'ward_id', DB::raw('COUNT(`id`) as total'))->groupBy('ward_id')->get();
        $wardArr = [];
        foreach($wardHasShop as $pro){
            $location = $pro->location;
            $tmp = explode(",", $location);            
            $wardArr[$pro->ward_id]['location'] = $tmp;
            $wardArr[$pro->ward_id]['total'] = $pro->total;
            $wardArr[$pro->ward_id]['slug'] = $pro->total;

        }      
        //dd($wardArr);  
        $companyList = Company::all();
       
        return view('layouts.ward', [
            'shopType' => $shopType,
            'listProvince' => $listProvince,            
            'conditionList' => $conditionList,
            'settingArr' => $settingArr,
            'wardArr' => $wardArr,
            'companyList' => $companyList,
            'provinceDetailArr' => $provinceDetailArr,
            'province_id' => $province_id,
            'district_id' => $district_id,
            'districtList' => $districtList,
            'wardList' => $wardList,
            'company_id' => $company_id            
        ]);

    }
    public function editShop(Request $request){
        $id = $request->id;
        $district_id = $request->district_id;
        $loginType = Auth::user()->type;
        $loginId = Auth::user()->id;
        if($loginType > 1){
            $provinceList = Province::whereRaw('id IN (SELECT province_id FROM user_province WHERE user_id = '.$loginId.')')->get();
        }else{
            $provinceList = Province::all();        
        }      
        
        $shopTypeList = ShopType::where('status', 1)->get();

        $conditionList = SelectCondition::orderBy('col_order')->get();
        
        $companyList = Company::all();
        
        $detail = Shop::where('shop.id', $id)
                ->join('shop_select_condition', 'shop_select_condition.shop_id', '=', 'shop.id')
                ->first();
                ;
        
        $districtList = (object)[];
        
        if($detail->province_id){
            $districtList = District::where('province_id', $detail->province_id)->get();
        }
        $wardList = (object)[];
        if($detail->district_id){
            $wardList = Ward::where('district_id', $detail->district_id)->get();
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

        $firstImage =  config('app.url').'/assets/images/no-image.png';

        $tmp = Image::where('shop_id', $id)->first();
        if($tmp){
            $folder = $tmp->url;
           
            $path = public_path()."/UY_VIET_DINH_VI/".$folder."/";

            if(is_dir($path)){
                $i = 0;
                foreach(glob($path.'*') as $filename){
                    $i++;
                    if($i == 1){
                        $firstImage = config('app.url')."/UY_VIET_DINH_VI/".$folder."/".basename($filename);
                    }                    
                }
            }
        }
        return $firstImage;
    }
    public function gallery(Request $request){
        $arr = [];
        $id = $request->id;

        $tmp = Image::where('shop_id', $id)->first();
        
            $folder = $tmp->url;
           
            $path = public_path()."/UY_VIET_DINH_VI/".$folder."/";

            if(is_dir($path)){                
                foreach(glob($path.'*') as $filename){                    
                    $arr[] = config('app.url')."/UY_VIET_DINH_VI/".$folder."/".basename($filename);                    
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

    public function findItem(Request $request) {
        
        $loginType = Auth::user()->type;
        $loginId = Auth::user()->id;

        $filter = $request->input();        
        $province_id = $request->provinceId ? $request->provinceId : null;
        $district_id = $request->districtId ? $request->districtId : null;
        
        if($loginType == 1){
            $company_id = $request->company_id ? $request->company_id : Company::first()->id;
        }else{
            $company_id = Auth::user()->company_id;
        }        
        
        $tmpUser = Account::getUserIdChild($loginId, $loginType, $company_id);

        $ward_id = $request->wardId ? $request->wardId : null; 
  
        $query =  Shop::where('shop.status', 1);
        // not admin
        if($loginType > 1){                
            $query->whereIn('user_id', $tmpUser['userId']);
        }       
        if($company_id){       
            $query->where('shop.company_id', $company_id);
        }
        if($province_id){
            $query->where('shop.province_id', $province_id);
        }
        if($district_id){
            $query->where('shop.district_id', $district_id);
        }
        if($ward_id){
            $query->where('shop.ward_id', $ward_id);
        }
        $query->join('shop_select_condition', 'shop_select_condition.shop_id', '=', 'shop.id');
        $query->join('shop_type', 'shop_type.id' , '=', 'shop.type_id');
        $query->select('shop.*', 'icon_url', 'shop_select_condition.*');
        $location = $query->get();

           

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
