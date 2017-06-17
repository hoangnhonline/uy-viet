<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Condition;
use App\Models\SelectCondition;
use Helper, File, Session, Auth, DB;

class ConditionController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $table = "shop_". $request->table;
        if(!$table){
            return redirect()->route('shop.index');
        }
        $detailCond = SelectCondition::where('name', $request->table)->first();
        $items = DB::table($table)->orderBy('col_order')->get();
        return view('backend.condition.index', compact( 'items', 'detailCond'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {
        $table = "shop_". $request->table;
        if(!$table){
            return redirect()->route('shop.index');
        }
        $detailCond = SelectCondition::where('name', $request->table)->first();
        return view('backend.condition.create', compact('detailCond'));
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
        unset($dataArr['table']);
        $table = $request->table;
        DB::table($table)->insert($dataArr);
        //Condition::insert($dataArr);  
        $table_name = str_replace("shop_", '', $request->table);
        $detailCond = SelectCondition::where('name', $table_name)->first();
        
        Session::flash('message', 'Tạo mới '.$detailCond->display_name.' thành công');

        return redirect()->route('condition.index',['table' => $table_name ]);
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
    public function edit(Request $request, $id)
    {
        $table = "shop_". $request->table;
        if(!$table){
            return redirect()->route('shop.index');
        }
        $detailCond = SelectCondition::where('name', $request->table)->first();
        $detail = DB::table($table)->where('id', $id)->first();

        return view('backend.condition.edit', compact( 'detail', 'detailCond'));
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
        $table_name = str_replace("shop_", '', $request->table);
        $detailCond = SelectCondition::where('name', $table_name)->first();        
        $this->validate($request,[
            'type' => 'required',
            'color' => 'required',
        ],
        [
            'type.required' => 'Bạn chưa nhập tên',
            'color.required' => 'Bạn chưa nhập màu'
        ]);

        //$model = Condition::find($dataArr['id']);

        //$model->update($dataArr);

        $table = $request->table;
        unset($dataArr['table']);
        unset($dataArr['_token']);
        DB::table($table)->where('id', $dataArr['id'])->update($dataArr);
        //Condition::insert($dataArr);  
        $table_name = str_replace("shop_", '', $request->table);
        $detailCond = SelectCondition::where('name', $table_name)->first();        
        //Session::flash('message', 'Tạo mới '.$detailCond->display_name.' thành công');

        Session::flash('message', 'Cập nhật '.$detailCond->display_name.' thành công');

        return redirect()->route('condition.index', ['table' => $table_name]);
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
        $model = Condition::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa loại vốn thành công');
        return redirect()->route('condition.index');
    }
}
