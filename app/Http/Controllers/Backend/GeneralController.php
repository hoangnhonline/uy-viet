<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use DB, Session;
class GeneralController extends Controller
{
    public function updateOrder(Request $request){
        if ($request->ajax())
        {
        	$dataArr = $request->all();
        	$str_order = $dataArr['str_order'];        	
            $table = $dataArr['table'];        
            if( $str_order ){
            	$tmpArr = explode(";", $str_order);
            	$i = 0;
            	foreach ($tmpArr as $id) {
            		if( $id > 0 ){
            			$i++;
            			DB::table($table)
				        ->where('id', $id)				        
				        ->update(array('col_order' => $i));			
            		}
            	}
            }
        }        
    }
    public function changeValue(Request $request){
        $value = $request->value;
        $column = $request->column;
        $table = $request->table;     
        $id = $request->id;
        
            DB::table($table)->where('id', $id)->update([$column => $value]);       
        
        
        
    }
    public function delete(Request $request){
        $table = $request->table;
        $id = $request->id;
        DB::table($table)->where('id', $id)->delete();                
    }
    public function getSlug(Request $request){
    	$strReturn = '';
    	if( $request->ajax() ){
    		$str = $request->str;
    		if( $str ){
    			$strReturn = str_slug( $str );
    		}
    	}
    	return response()->json( ['str' => $strReturn] );
    }

    public function saveColOrder(Request $request){
        $data = $request->all();
        $table = $request->table;
        $return_url = $request->return_url;
        if(!empty($data['col_order'])){
            foreach ($data['col_order'] as $id => $col_order) {
                $model = DB::table($table)->where('id', $id)->update(['col_order' => $col_order]);                
            }
        }
        Session::flash('message', 'Cập nhật thứ tự tin thành công');

        return redirect()->to($return_url);
    }
}
