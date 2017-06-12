<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ShopTiemNang;
use Helper, File, Session, Auth;

class ShopTiemNangController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {        
        $items = ShopTiemNang::all()->sortBy('col_order');
        return view('backend.shop-tiem-nang.index', compact( 'items' ));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        return view('backend.shop-tiem-nang.create');
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
            'type.required' => 'Bạn chưa nhập tên tiềm năng',
            'color.required' => 'Bạn chưa nhập màu'
        ]);        
        
        $dataArr['col_order'] = Helper::getNextOrder('shop_tiem_nang1480213595');

        ShopTiemNang::create($dataArr);

        Session::flash('message', 'Tạo mới tiềm năng thành công');

        return redirect()->route('shop-tiem-nang.index');
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
        $detail = ShopTiemNang::find($id);

        return view('backend.shop-tiem-nang.edit', compact( 'detail' ));
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
            'type.required' => 'Bạn chưa nhập tên tiềm năng',
            'color.required' => 'Bạn chưa nhập màu'
        ]);

        $model = ShopTiemNang::find($dataArr['id']);

        $model->update($dataArr);

        Session::flash('message', 'Cập nhật tiềm năng thành công');

        return redirect()->route('shop-tiem-nang.edit', $dataArr['id']);
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
        $model = ShopTiemNang::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa tiềm năng thành công');
        return redirect()->route('shop-tiem-nang.index');
    }
}
