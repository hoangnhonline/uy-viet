<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Province;
use Helper, File, Session, Auth;

class ProvinceController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $items = Province::all()->sortBy('id', 'asc');
        return view('backend.province.index', compact( 'items' ));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        return view('backend.province.create');
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
            'name' => 'required'
        ],
        [
            'name.required' => 'Bạn chưa nhập tên'            
        ]);        
        
        Province::create($dataArr);

        Session::flash('message', 'Tạo mới tỉnh/thành thành công');

        return redirect()->route('province.index');
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
        $detail = Province::find($id);

        return view('backend.province.edit', compact( 'detail' ));
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
            'name' => 'required'
        ],
        [
            'name.required' => 'Bạn chưa nhập tên'            
        ]);   

        $model = Province::find($dataArr['id']);

        $model->update($dataArr);

        Session::flash('message', 'Cập nhật tỉnh/thành thành công');

        return redirect()->route('province.edit', $dataArr['id']);
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
        $model = Province::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa tỉnh/thành thành công');
        return redirect()->route('province.index');
    }
}
