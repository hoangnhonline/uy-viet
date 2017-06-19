<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\SelectCondition;
use Helper, File, Session, Auth, Schema;

class DieuKienController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $items = SelectCondition::all()->sortBy('col_order');
        return view('backend.dieu-kien.index', compact( 'items' ));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        return view('backend.dieu-kien.create');
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
            'display_name' => 'required',
        ],
        [
            'name.required' => 'Bạn chưa nhập tên table',
            'display_name.required' => 'Bạn chưa nhập tên hiển thị'
        ]);        
        $dataArr['col_order'] = Helper::getNextOrder('select_condition');

        $dataArr['name'] = $name = $request->name.time();
        $table_name = "shop_".$request->name.time();
        
        Schema::create($table_name, function($table) {
            $table->increments('id');
            $table->string('type', 100);
            $table->string('color', 10);
            $table->tinyInteger("col_order");
            $table->boolean('status');
        });

        $col = $name."_id";
        Schema::table('shop_select_condition', function($table) use ($col) {
            $table->tinyInteger($col);                 
        });
        SelectCondition::create($dataArr);   

        Session::flash('message', 'Tạo mới Điều kiện thành công');

        return redirect()->route('dieu-kien.index');
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
        $detail = SelectCondition::find($id);

        return view('backend.dieu-kien.edit', compact( 'detail' ));
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
            'display_name' => 'required',
        ],
        [            
            'display_name.required' => 'Bạn chưa nhập tên hiển thị'
        ]);

        $model = SelectCondition::find($dataArr['id']);

        $model->update($dataArr);

        Session::flash('message', 'Cập nhật Điều kiện thành công');

        return redirect()->route('dieu-kien.index');
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
        $model = SelectCondition::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa Điều kiện thành công');
        return redirect()->route('dieu-kien.index');
    }
}
