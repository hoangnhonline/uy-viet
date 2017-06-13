<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ShopType;
use Helper, File, Session, Auth;

class ShopTypeController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $items = ShopType::all()->sortBy('col_order');
        return view('backend.shop-type.index', compact( 'items' ));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        return view('backend.shop-type.create');
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
            'icon_url' => 'required',
        ],
        [
            'type.required' => 'Bạn chưa nhập tên danh mục',
            'icon_url.required' => 'Bạn chưa upload icon'
        ]);      

        if($dataArr['icon_url'] && $dataArr['icon_name']){
            
            $tmp = explode('/', $dataArr['icon_url']);

            if(!is_dir('uploads/'.date('Y/m/d'))){
                mkdir('uploads/'.date('Y/m/d'), 0777, true);
            }

            $destionation = date('Y/m/d'). '/'. end($tmp);
            
            File::move(config('uv.upload_path').$dataArr['icon_url'], config('uv.upload_path').$destionation);
            
            $dataArr['icon_url'] = $destionation;
        }   

        unset($dataArr['_token']);
        unset($dataArr['icon_name']);

        $dataArr['col_order'] = Helper::getNextOrder('shop_type');
        
        ShopType::insert($dataArr);           

        Session::flash('message', 'Tạo mới danh mục thành công');

        return redirect()->route('shop-type.index');
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
        $detail = ShopType::find($id);

        return view('backend.shop-type.edit', compact( 'detail' ));
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
        
        $dataArr = $request->all();
        
        $this->validate($request,[
            'type' => 'required',
            'icon_url' => 'required',
        ],
        [
            'type.required' => 'Bạn chưa nhập tên danh mục',
            'icon_url.required' => 'Bạn chưa upload icon'
        ]);

        if($dataArr['icon_url'] && $dataArr['icon_name']){
            
            $tmp = explode('/', $dataArr['icon_url']);

            if(!is_dir('uploads/'.date('Y/m/d'))){
                mkdir('uploads/'.date('Y/m/d'), 0777, true);
            }

            $destionation = date('Y/m/d'). '/'. end($tmp);
            
            File::move(config('uv.upload_path').$dataArr['icon_url'], config('uv.upload_path').$destionation);
            
            $dataArr['icon_url'] = $destionation;
        }        
        
        $model = ShopType::find($dataArr['id']);

        $model->update($dataArr);

        Session::flash('message', 'Cập nhật danh mục thành công');

        return redirect()->route('shop-type.edit', $dataArr['id']);
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
        $model = ShopType::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa danh mục thành công');
        return redirect()->route('shop-type.index');
    }
}
