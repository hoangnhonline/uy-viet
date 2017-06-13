<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ShopSize;
use Helper, File, Session, Auth, DB;

class ShopSizeController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $items = ShopSize::all()->sortBy('col_order');
        return view('backend.shop-size.index', compact( 'items' ));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        return view('backend.shop-size.create');
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
            'type.required' => 'Bạn chưa nhập tên size',
            'color.required' => 'Bạn chưa nhập màu'
        ]);

        $dataArr['col_order'] = Helper::getNextOrder('shop_size');
        
        unset($dataArr['_token']);
        ShopSize::insert($dataArr);

        Session::flash('message', 'Tạo mới size thành công');

        return redirect()->route('shop-size.index');
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
        $detail = ShopSize::find($id);

        return view('backend.shop-size.edit', compact( 'detail' ));
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
            'color' => 'required',
        ],
        [
            'type.required' => 'Bạn chưa nhập tên size',
            'color.required' => 'Bạn chưa nhập màu'
        ]);

        $model = ShopSize::find($dataArr['id']);

        $model->update($dataArr);

        Session::flash('message', 'Cập nhật size thành công');

        return redirect()->route('shop-size.edit', $dataArr['id']);
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
        $model = ShopSize::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa size thành công');
        return redirect()->route('shop-size.index');
    }
}
