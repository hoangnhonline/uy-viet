<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\Account;
use App\Models\ShopType;
use App\Models\ShopCapDo;
use App\Models\ShopTiemNang;
use App\Models\ShopQuyMo;
use App\Models\ShopSize;
use App\Models\ShopVon;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use App\Models\SelectCondition;
use App\Models\ShopSelectCondition;
use App\Models\Image;
use App\Models\Company;

use Helper, File, Session, Auth;

class ShopController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $loginType = Auth::user()->type;
        $loginId = Auth::user()->id;
        
        $companyList = Company::all();
        $arrSearch['status'] = $status = isset($request->status) ? $request->status : 1;   
        //$typeIdArr = ShopType::lists('id')->toArray();
        $shopTypeList = ShopType::all();
        
        foreach ($shopTypeList as $key => $value) {
            $typeIdDefault[] = $value->id;
        }        
        $arrSearch['type_id'] = $type_id = isset($request->type_id) ? $request->type_id : $typeIdDefault;     

        $arrSearch['company_id'] = $company_id = $request->company_id ? $request->company_id : Company::first()->id;       

        if($loginType >= 2){
            $arrSearch['company_id'] = $company_id = Auth::user()->company_id;
        }
        
        $tmpUser = Account::getUserIdChild($loginId, $loginType, $company_id);      

        $arrSearch['district_id'] = $district_id = isset($request->district_id) ? $request->district_id : null;
        $arrSearch['ward_id'] = $ward_id = isset($request->ward_id) ? $request->ward_id : null;
        $arrSearch['user_id'] = $userIdSelected = isset($request->user_id) ? $request->user_id : [];
        $arrSearch['condition_id'] = $condition_id = isset($request->condition_id) ? $request->condition_id : null;
        $arrSearch['province_id'] = $province_id = isset($request->province_id) ? $request->province_id : null;

        $arrSearch['user_type'] = $user_type = isset($request->user_type) ? $request->user_type : null;        
        

        $arrSearch['shop_name'] = $shop_name = isset($request->shop_name) && trim($request->shop_name) != '' ? trim($request->shop_name) : '';
        
        $query = Shop::where('shop.status', $status)->where('company_id', $company_id);

        $wardList = (object) [];
        if( $userIdSelected ){
            
            $userIdSelected[] = $loginId;
            
            $query->whereIn('shop.user_id', $userIdSelected);
        }else{
            $userIdSelected = $tmpUser['userId'];
            
            $userIdSelected[] = $loginId;
            
            $query->whereIn('shop.user_id', $userIdSelected);
        }
        if( $type_id ){
            $query->whereIn('shop.type_id', $type_id);
        }
        if( $province_id ){
            $query->where('shop.province_id', $province_id);
        }            
        if( $district_id ){
            $query->where('shop.district_id', $district_id);
            $wardList = Ward::where('district_id', $district_id)->get();
        }
        if( $ward_id ){
            $query->where('shop.ward_id', $ward_id);
        }       
        if( $condition_id ){
            $query->where('shop.condition_id', $condition_id);
        }        
        if( $shop_name != ''){
            $query->where('shop.shop_name', 'LIKE', '%'.$shop_name.'%');            
        }
        
        $query->orderBy('shop.id', 'desc');   
        $items = $query->paginate(100);
        $shopTypeList = ShopType::all();
        if($loginType == 1){
            $provinceList = Province::orderBy('name')->get();
        }else{
            $provinceList = Province::whereRaw('province.id IN (SELECT province_id FROM user_province WHERE user_id = '.$loginId.')')->orderBy('name')->get();            
        }
        $districtList = District::where('province_id', $province_id)->orderBy('name')->get();        
        
        $userListLevel = $tmpUser['userList'];

        return view('backend.shop.index', compact( 
                                            'items', 
                                            'arrSearch', 
                                            'provinceList', 
                                            'districtList', 
                                            'shopTypeList', 
                                            'wardList', 
                                            'companyList', 
                                            'userListLevel', 
                                            'userIdSelected'));
    }
    public function getListUser($company_id, $user_type){
        return $userList = Account::where(['company_id' => $company_id, 'type' => $user_type])->get();
    }
    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        $loginType = Auth::user()->type;
        $loginId = Auth::user()->id;
        if($loginType > 1){
            $provinceList = Province::whereRaw('id IN (SELECT province_id FROM user_province WHERE user_id = '.$loginId.')')->orderBy('name')->get();
        }else{
            $provinceList = Province::orderBy('name')->get();        
        }      
        
        $shopTypeList = ShopType::where('status', 1)->get();

        $conditionList = SelectCondition::orderBy('col_order')->get();
        $max_id = Shop::max('id');
        $folder = "UV_".$max_id.time();        
        $companyList = Company::all();
        return view('backend.shop.create', compact(
            'provinceList',
            'shopTypeList',
            'conditionList',
            'companyList',
            'folder'
            ));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  Request  $request
    * @return Response
    */
    public function store(Request $request)
    {
        $dataArr = $request->all();
        
        $this->validate($request,[            
            'type_id' => 'required',            
            'province_id' => 'required',
            'district_id' => 'required',            
            'ward_id' => 'required',     
            'shop_name' => 'required'                        
        ],
        [            
            'type_id.required' => 'Bạn chưa chọn loại shop',
            'province_id.required' => 'Bạn chưa chọn tỉnh/thành',
            'district_id.required' => 'Bạn chưa chọn Quận/Huyện',
            'ward_id.required' => 'Bạn chưa chọn phường/xã',
            'shop_name.required' => 'Bạn chưa nhập tên shop'           
        ]);
        $dataArr['location'] = $dataArr['latt'].",".$dataArr['longt'];
        $dataArr['user_id'] = Auth::user()->id;
        $dataArr['add_time'] = date('Y-m-d H:i:s', time());
        $dataArr['condition_id'] = 0;
        $wardDetail = Ward::find($dataArr['ward_id']);
        $districtDetail = District::find($dataArr['district_id']);
        $provinceDetail = Province::find($dataArr['province_id']);
        $dataArr['full_address'] = $dataArr['address']. ", ". $dataArr['street']. ", ". $wardDetail->name. ", ". $districtDetail->name. ", ". $provinceDetail->name ;
        $dataArr['company_id'] = isset($dataArr['company_id']) ? $dataArr['company_id'] : Auth::user()->company_id;
        $rs = Shop::create($dataArr);

        $id = $rs->id;
        
        $arrCond = [];

        if(!empty($dataArr['cond'])){
            $arrCond['shop_id'] = $id;
            foreach ($dataArr['cond'] as $column => $value) {
                
                $arrCond[$column] = $value;

            }
            ShopSelectCondition::create($arrCond);
        }
        Image::create([
            'url' => $dataArr['folder'],
            'shop_id' => $id
            ]);
        Session::flash('message', 'Tạo mới shop thành công');

        return redirect()->route('shop.index');
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function show($id)
    {
    //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function edit($id)
    {       
        $loginType = Auth::user()->type;
        $loginId = Auth::user()->id;

        $user_id_list = Account::getUserIdChild($loginId, $loginType, Auth::user()->company_id);

        if($loginType > 1){
            $provinceList = Province::whereRaw('id IN (SELECT province_id FROM user_province WHERE user_id = '.$loginId.')')->orderBy('name')->get();
        }else{
            $provinceList = Province::orderBy('name')->get();        
        }      
        
        $shopTypeList = ShopType::where('status', 1)->get();

        $conditionList = SelectCondition::orderBy('col_order')->get();
        
        $companyList = Company::all();
        
        $detail = Shop::where('shop.id', $id)
                ->join('shop_select_condition', 'shop_select_condition.shop_id', '=', 'shop.id')
                ->first();
                ;                

        if(!in_array($detail->user_id, $user_id_list) && $loginType > 1){ // ko co quyen truy cap
            return redirect()->route('shop.index');
        }
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
        
        return view('backend.shop.edit', compact( 'detail', 'shopTypeList', 'companyList', 'provinceList', 'conditionList', 'districtList', 'wardList', 'hinhArr', 'folder'));
    }
    public function editMaps($id)
    {       
        $loginType = Auth::user()->type;
        $loginId = Auth::user()->id;

        $detail = Shop::find($id);

        $tmpUser = Account::getUserIdChild($loginId, $loginType, $detail->company_id);
        // not admin
        $query =  Shop::where('shop.status', 1);
        
        $query->whereIn('user_id', $tmpUser['userId']);        
    
        $query->where('shop.company_id', $detail->company_id);        
    
        $query->where('shop.province_id', $detail->province_id);
    
        $query->where('shop.district_id', $detail->district_id);            
        
        $query->where('shop.ward_id', $detail->ward_id);
        $query->where('shop.id', '<>', $id);
        $query->join('shop_type', 'shop_type.id' , '=', 'shop.type_id');
            $query->select('shop.*', 'icon_url');
        $markerArr = $query->get()->toArray();
        return view('backend.shop.edit-maps', compact( 'detail', 'markerArr'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  Request  $request
    * @param  int  $id
    * @return Response
    */
    public function update(Request $request)
    {
        $dataArr = $request->all(); 

        if($dataArr['update_maps'] == 0){
            $this->validate($request,[            
                'type_id' => 'required',            
                'province_id' => 'required',
                'district_id' => 'required',            
                'ward_id' => 'required',     
                'shop_name' => 'required'                        
            ],
            [            
                'type_id.required' => 'Bạn chưa chọn loại shop',
                'province_id.required' => 'Bạn chưa chọn tỉnh/thành',
                'district_id.required' => 'Bạn chưa chọn Quận/Huyện',
                'ward_id.required' => 'Bạn chưa chọn phường/xã',
                'shop_name.required' => 'Bạn chưa nhập tên shop'           
            ]);

            if(!empty($dataArr['cond'])){
                $model = ShopSelectCondition::where('shop_id', $dataArr['id'])->first();
                foreach ($dataArr['cond'] as $column => $value) {
                    
                    $model->$column = $value;

                }
                $model->save();
            }
            $wardDetail = Ward::find($dataArr['ward_id']);
            $districtDetail = District::find($dataArr['district_id']);
            $provinceDetail = Province::find($dataArr['province_id']);
            $dataArr['full_address'] = $dataArr['address']. ", ". $dataArr['street']. ", ". $wardDetail->name. ", ". $districtDetail->name. ", ". $provinceDetail->name ;

        }
        
        $model = Shop::find($dataArr['id']);
        $dataArr['location'] = $dataArr['latt'].",".$dataArr['longt'];
        $model->update($dataArr);
        
        Session::flash('message', 'Cập nhật shop thành công');
        if(isset($dataArr['curr_url'])){
            return redirect(urldecode($dataArr['curr_url']));
        }
        if(isset($dataArr['url_return'])){
            return redirect(urldecode($dataArr['url_return']));   
        }
        if($dataArr['update_maps'] == 0){
            return redirect()->route('shop.edit', $dataArr['id']);
        }else{
            return redirect()->route('shop.edit-maps', $dataArr['id']);
        }
    }    

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {
        // delete
        $model = Shop::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa shop thành công');
        return redirect()->route('shop.index');
    }
}
