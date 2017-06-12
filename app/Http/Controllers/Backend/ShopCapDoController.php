<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ShopCapDo;
use Helper, File, Session, Auth;

class ShopCapDoController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $items = ShopCapDo::all()->sortBy('col_order');
        return view('backend.shop-cap-do.index', compact( 'items' ));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        return view('backend.shop-cap-do.create');
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
            'type.required' => 'Bạn chưa nhập tên cấp độ',
            'color.required' => 'Bạn chưa nhập màu'
        ]);        
        $dataArr['col_order'] = Helper::getNextOrder('shop_cap_do_1480213548');
        ShopCapDo::create($dataArr);

        Session::flash('message', 'Tạo mới cấp độ thành công');

        return redirect()->route('shop-cap-do.index');
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
        $detail = ShopCapDo::find($id);

        return view('backend.shop-cap-do.edit', compact( 'detail' ));
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
            'type.required' => 'Bạn chưa nhập tên cấp độ',
            'color.required' => 'Bạn chưa nhập màu'
        ]);

        $model = ShopCapDo::find($dataArr['id']);

        $model->update($dataArr);

        Session::flash('message', 'Cập nhật cấp độ thành công');

        return redirect()->route('shop-cap-do.edit', $dataArr['id']);
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
        $model = ShopCapDo::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa cấp độ thành công');
        return redirect()->route('shop-cap-do.index');
    }
}
