<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ShopVon;
use Helper, File, Session, Auth;

class ShopVonController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $items = ShopVon::all()->sortBy('col_order');
        return view('backend.shop-von.index', compact( 'items' ));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        return view('backend.shop-von.create');
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
        $dataArr['col_order'] = Helper::getNextOrder('shop_von1484471015');
        ShopVon::create($dataArr);

        Session::flash('message', 'Tạo mới loại vốn thành công');

        return redirect()->route('shop-von.index');
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
        $detail = ShopVon::find($id);

        return view('backend.shop-von.edit', compact( 'detail' ));
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
            'type.required' => 'Bạn chưa nhập tên loại vốn',
            'color.required' => 'Bạn chưa nhập màu'
        ]);

        $model = ShopVon::find($dataArr['id']);

        $model->update($dataArr);

        Session::flash('message', 'Cập nhật loại vốn thành công');

        return redirect()->route('shop-von.edit', $dataArr['id']);
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
        $model = ShopVon::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa loại vốn thành công');
        return redirect()->route('shop-von.index');
    }
}
