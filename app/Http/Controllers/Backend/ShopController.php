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
        
        $arrSearch['status'] = $status = isset($request->status) ? $request->status : 1;         
        //$typeIdArr = ShopType::lists('id')->toArray();
        $shopTypeList = ShopType::all();
        
        foreach ($shopTypeList as $key => $value) {
            $typeIdDefault[] = $value->id;
        }        
        $arrSearch['type_id'] = $type_id = isset($request->type_id) ? $request->type_id : $typeIdDefault;     

        $arrSearch['district_id'] = $district_id = isset($request->district_id) ? $request->district_id : null;
        $arrSearch['ward_id'] = $ward_id = isset($request->ward_id) ? $request->ward_id : null;
        $arrSearch['user_id'] = $user_id = isset($request->user_id) ? $request->user_id : null;
        $arrSearch['condition_id'] = $condition_id = isset($request->condition_id) ? $request->condition_id : null;
        $arrSearch['province_id'] = $province_id = isset($request->province_id) ? $request->province_id : null;

        $arrSearch['shop_name'] = $shop_name = isset($request->shop_name) && trim($request->shop_name) != '' ? trim($request->shop_name) : '';
        
        $query = Shop::where('shop.status', $status);
        $wardList = (object) [];
        if( $user_id ){
            $query->where('shop.user_id', $user_id);
        }
        if( $type_id ){
            $query->whereIn('shop.type_id', $type_id);
        }
        if( $province_id ){
            $query->where('shop.province_id', $province_id);
        }
        if($loginType != 1){
            $query->whereRaw('shop.province_id IN (SELECT province_id FROM user_province WHERE user_id = '.$loginId.')');
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
            $provinceList = Province::all();
        }else{
            $provinceList = Province::whereRaw('province.id IN (SELECT province_id FROM user_province WHERE user_id = '.$loginId.')')->get();            
        }
        $districtList = District::where('province_id', $province_id)->get();
        
        if($loginType == 1){
            $userList = Account::where('type', '>', 1)->get();
        }else{
            $userList = Account::where('type', '>', $loginType)->where('created_user', $loginId)->get();
        }            
        return view('backend.shop.index', compact( 'items', 'arrSearch', 'provinceList', 'districtList', 'shopTypeList', 'wardList', 'userList'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        return view('backend.shop.create');
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
            'type' => 'required',
            'color' => 'required',
        ],
        [
            'type.required' => 'Bạn chưa nhập tên shop',
            'color.required' => 'Bạn chưa nhập màu'
        ]);        
        $dataArr['col_order'] = Helper::getNextOrder('shop_cap_do_1480213548');

        unset($dataArr['_token']);
        Shop::insert($dataArr);      

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
        $detail = Shop::find($id);

        return view('backend.shop.edit', compact( 'detail' ));
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
        
        $this->validate($request,[
            'type' => 'required',
            'color' => 'required',
        ],
        [
            'type.required' => 'Bạn chưa nhập tên shop',
            'color.required' => 'Bạn chưa nhập màu'
        ]);

        $model = Shop::find($dataArr['id']);

        $model->update($dataArr);

        Session::flash('message', 'Cập nhật shop thành công');

        return redirect()->route('shop.edit', $dataArr['id']);
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
