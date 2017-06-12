<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\District;
use Helper, File, Session, Auth;

class DistrictController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $items = District::all()->sortBy('id', 'asc');
        return view('backend.district.index', compact( 'items' ));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        return view('backend.district.create');
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
            'province_id' => 'required'
        ],
        [
            'name.required' => 'Bạn chưa nhập tên',
            'province_id.required' => 'Bạn chưa chọn tỉnh/thành'            
        ]);        
        
        District::create($dataArr);

        Session::flash('message', 'Tạo mới quận/huyện thành công');

        return redirect()->route('district.index');
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
        $detail = District::find($id);

        return view('backend.district.edit', compact( 'detail' ));
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
            'province_id' => 'required'
        ],
        [
            'name.required' => 'Bạn chưa nhập tên',
            'province_id.required' => 'Bạn chưa chọn tỉnh/thành'           
        ]);   

        $model = District::find($dataArr['id']);

        $model->update($dataArr);

        Session::flash('message', 'Cập nhật quận/huyện thành công');

        return redirect()->route('district.edit', $dataArr['id']);
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
        $model = District::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa quận/huyện thành công');
        return redirect()->route('district.index');
    }
}
