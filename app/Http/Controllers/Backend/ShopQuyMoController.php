<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ShopQuyMo;
use Helper, File, Session, Auth;

class ShopQuyMoController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $items = ShopQuyMo::all()->sortBy('col_order');
        return view('backend.shop-quy-mo.index', compact( 'items' ));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        return view('backend.shop-quy-mo.create');
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
            'type.required' => 'Bạn chưa nhập tên loại vốn',
            'color.required' => 'Bạn chưa nhập màu'
        ]);        
        $dataArr['col_order'] = Helper::getNextOrder('shop_tiem_nang1480213595');
        unset($dataArr['_token']);
        ShopQuyMo::insert($dataArr);  

        Session::flash('message', 'Tạo mới loại vốn thành công');

        return redirect()->route('shop-quy-mo.index');
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
        $detail = ShopQuyMo::find($id);

        return view('backend.shop-quy-mo.edit', compact( 'detail' ));
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
            'type.required' => 'Bạn chưa nhập tên loại vốn',
            'color.required' => 'Bạn chưa nhập màu'
        ]);

        $model = ShopQuyMo::find($dataArr['id']);

        $model->update($dataArr);

        Session::flash('message', 'Cập nhật loại vốn thành công');

        return redirect()->route('shop-quy-mo.edit', $dataArr['id']);
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
        $model = ShopQuyMo::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa loại vốn thành công');
        return redirect()->route('shop-quy-mo.index');
    }
}
