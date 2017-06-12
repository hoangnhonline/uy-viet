<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Ward;
use Helper, File, Session, Auth;

class WardController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $items = Ward::all()->sortBy('id', 'asc');
        return view('backend.ward.index', compact( 'items' ));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        return view('backend.ward.create');
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
            'name' => 'required',
            'district_id' => 'required'
        ],
        [
            'name.required' => 'Bạn chưa nhập tên',
            'district_id.required' => 'Bạn chưa chọn quận/huyện'            
        ]);        
        
        Ward::create($dataArr);

        Session::flash('message', 'Tạo mới phường/xã thành công');

        return redirect()->route('ward.index');
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
        $detail = Ward::find($id);

        return view('backend.ward.edit', compact( 'detail' ));
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
            'name' => 'required',
            'district_id' => 'required'
        ],
        [
            'name.required' => 'Bạn chưa nhập tên',
            'district_id.required' => 'Bạn chưa chọn quận/huyện'           
        ]);   

        $model = Ward::find($dataArr['id']);

        $model->update($dataArr);

        Session::flash('message', 'Cập nhật phường/xã thành công');

        return redirect()->route('ward.edit', $dataArr['id']);
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
        $model = Ward::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa phường/xã thành công');
        return redirect()->route('ward.index');
    }
}
