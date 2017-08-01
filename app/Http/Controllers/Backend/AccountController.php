<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Mail;
use Hash;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\GroupUser;
use App\Models\Company;
use App\Models\Province;
use App\Models\UserProvince;
use App\Models\Shop;
use Helper, File, Session, Auth;

class AccountController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {   
        $loginType = Auth::user()->type;
        $loginId = Auth::user()->id;
        
        if($loginType > 5){
            return redirect()->route('shop.index');
        }  
        $searchArr['company_id'] = $company_id = $request->company_id ? $request->company_id : null;
        $searchArr['company_user_id'] = $company_user_id = $request->company_user_id ? $request->company_user_id : null;
        $searchArr['operator_user_id'] = $operator_user_id = $request->operator_user_id ? $request->operator_user_id : null;
        $searchArr['executive_user_id'] = $executive_user_id = $request->executive_user_id ? $request->executive_user_id : null;
        $searchArr['supervisor_user_id'] = $supervisor_user_id = $request->supervisor_user_id ? $request->supervisor_user_id : null;

        if($loginType >= 2){
            $searchArr['company_id'] = $company_id = Auth::user()->company_id;
        }
        $loginType = Auth::user()->type;
        if($loginType == 2){
            $typeArrDefault = [3,4,5,6];
        }elseif($loginType == 3){
            $typeArrDefault = [4,5,6];
        }elseif($loginType == 4){
            $typeArrDefault = [5,6];
        }elseif($loginType==5){
            $typeArrDefault = [6];
        }else{
            $typeArrDefault = [2,3,4,5,6];
        }
        // get List User
        $query = Account::where('company_id', $company_id);
        
       // var_dump($loginId);
        if($loginType == 2){    
            $query->where('company_user_id', $loginId);
        }

        $listTmp = $query->get();
        $userList['admin'] = $userList['company'] = $userList['operator'] = $userList['executive'] = $userList['supervisor'] = $userList['sale'] = $userList['admin'] = [];
        foreach($listTmp as $user){
            if($user->type == 2){
                $userList['company'][] = $user;
            }elseif($user->type == 3){
                $userList['operator'][] = $user;
            }elseif($user->type == 4){
                $userList['executive'][] = $user;
            }elseif($user->type == 5){
                $userList['supervisor'][] = $user;
            }elseif($user->type == 6){
                $userList['sale'][] = $user;
            }          
        }



        $query = Account::where('status', '>', 0);
       
        if($company_id){            
            $query->where('company_id', $company_id);
        }
        if( $loginType == 1 ){
            $groupList = GroupUser::all();
            $companyList = Company::all();
            $type = $request->type ? $request->type : 0;
            
            $leader_id = $request->leader_id ? $request->leader_id : 0;
            if($leader_id > 0){
                $query->where('leader_id', $leader_id);
            }
        }elseif( $loginType == 2){
            $query->where(['company_user_id' => Auth::user()->id]);
            $groupList = GroupUser::where('company_id', Auth::user()->company_id)->get();
            $companyList = (object)[];
        }elseif( $loginType == 3){
            $query->where(['operator_user_id' => Auth::user()->id]);
            $groupList = GroupUser::where('company_id', Auth::user()->company_id)->get();
            $companyList = (object)[];

            $userList['executive'] = Account::where([
                                            'company_id' => $company_id, 
                                            'type' => 4, 
                                            'operator_user_id' => $loginId
                                            ])->get();
            $userList['supervisor'] = Account::where([
                                            'company_id' => $company_id, 
                                            'type' => 5, 
                                            'operator_user_id' => $loginId
                                            ])->get();

        }elseif( $loginType == 4){
            $query->where(['executive_user_id' => Auth::user()->id]);
            $groupList = GroupUser::where('company_id', Auth::user()->company_id)->get();
            $companyList = (object)[];
          
            $userList['supervisor'] = Account::where([
                                            'company_id' => $company_id, 
                                            'type' => 5, 
                                            'executive_user_id' => $loginId
                                            ])->get();

        }elseif( $loginType == 5){
            $query->where(['supervisor_user_id' => Auth::user()->id]);
            $groupList = GroupUser::where('company_id', Auth::user()->company_id)->get();
            $companyList = (object)[];
        }else{

        }
        

        
        $searchArr['type'] = $typeArr = $request->type ? $request->type : $typeArrDefault;
    
        $searchArr['username'] = $username = $request->username ? $request->username : null;
        $searchArr['email'] = $email = $request->email ? $request->email : null;
        if($typeArr){
            $query->whereIn('user.type', $typeArr);
        }
        if( $username != ''){
            $query->where('username', 'LIKE', '%'.$username.'%');
        }
        if( $email != ''){
            $query->where('email', 'LIKE', '%'.$email.'%');
        }
        if($company_user_id){
            $query->where('company_user_id', $company_user_id); 
            $userList['operator'] = Account::where([
                                            'company_id' => $company_id, 
                                            'type' => 3, 
                                            'company_user_id' => $company_user_id
                                            ])->get();
            $userList['executive'] = Account::where([
                                            'company_id' => $company_id, 
                                            'type' => 4, 
                                            'company_user_id' => $company_user_id
                                            ])->get();
            $userList['supervisor'] = Account::where([
                                            'company_id' => $company_id, 
                                            'type' => 5, 
                                            'company_user_id' => $company_user_id
                                            ])->get();
        }
        if($operator_user_id){
            $query->where('operator_user_id', $operator_user_id);

            $userList['executive'] = Account::where([
                                            'company_id' => $company_id, 
                                            'type' => 4, 
                                            'operator_user_id' => $operator_user_id
                                            ])->get();
            $userList['supervisor'] = Account::where([
                                            'company_id' => $company_id, 
                                            'type' => 5, 
                                            'operator_user_id' => $operator_user_id
                                            ])->get();
        }
        if($executive_user_id){
            $query->where('executive_user_id', $executive_user_id); 

            $userList['supervisor'] = Account::where([
                                            'company_id' => $company_id, 
                                            'type' => 5, 
                                            'executive_user_id' => $executive_user_id
                                            ])->get();  
        }
        if($supervisor_user_id){
            $query->where('supervisor_user_id', $supervisor_user_id);   
        }
        $items = $query->orderBy('user.type')->orderBy('id', 'desc')->get();             
        //var_dump($userList);
        $provinceList = Province::all();        
        return view('backend.account.index', compact('items', 'typeArr', 'leader_id', 'modList', 'groupList', 'companyList', 'provinceList', 'searchArr', 'userList'));
    }
    public function ajaxGetAccount(Request $request){
        $company_id = $request->company_id ? $request->company_id : Auth::user()->company_id;        
        $userList = Helper::getListUserByType($company_id);
        return \Response::json($userList);

    }
    public function ajaxGetAccountOwner(Request $request){
        $user_id = $request->user_id ? $request->user_id : Auth::user()->id;
        $column = $request->column;
        $company_id = $request->company_id ? $request->company_id : Auth::user()->company_id;        
        $userList = Helper::getListUserOwnerByType($user_id, $company_id, $column);
        return \Response::json($userList);
    }
    public function create()
    {       
        $loginType = Auth::user()->type; 
        if($loginType > 2){
            return redirect()->route('shop.index');
        }
        if(Auth::user()->type > 2){
            $groupList = GroupUser::where('company_id', Auth::user()->company_id)->get();         
            $provinceList = Province::whereRaw('id IN (SELECT province_id FROM user_province WHERE user_id='.Auth::user()->id.')')->get();
        }else{
            $groupList = GroupUser::all();
            $provinceList = Province::all();
        }

        $modList = Account::where(['type' => 2, 'status' => 1])->get();
        
        $companyList = Company::all();
        $userList = [];
        if($loginType > 1){
            $userList = Helper::getListUserByType(Auth::user()->company_id);
        }        
        return view('backend.account.create', compact('modList', 'groupList', 'companyList', 'provinceList', 'userList'));
    }
    public function changePass(){
        return view('backend.account.change-pass');   
    }

    public function storeNewPass(Request $request){
        $user_id = Auth::user()->id;
        $detail = Account::find($user_id);
        $old_pass = $request->old_pass;
        $new_pass = $request->new_pass;
        $new_pass_re = $request->new_pass_re;
        if( $old_pass == '' || $new_pass == "" || $new_pass_re == ""){
            return redirect()->back()->withErrors(["Chưa nhập đủ thông tin bắt buộc!"])->withInput();
        }
       
        if(!password_verify($old_pass, $detail->password)){
            return redirect()->back()->withErrors(["Nhập mật khẩu hiện tại không đúng!"])->withInput();
        }
        
        if($new_pass != $new_pass_re ){
            return redirect()->back()->withErrors("Xác nhận mật khẩu mới không đúng!")->withInput();   
        }

        $detail->password = Hash::make($new_pass);
        $detail->save();
        Session::flash('message', 'Đổi mật khẩu thành công');

        return redirect()->route('account.change-pass');

    }
    public function store(Request $request)
    {
       
        $dataArr = $request->all();
         
        $this->validate($request,[
            'type' => 'required',
            'company_id' => 'required',
            'fullname' => 'required',
            'email' => 'required|unique:user,email',
            'username' => 'required|unique:user,username',
            'password' => 'required',
            're_password' => 'required|same:password'            
        ],
        [
            'type.required' => 'Bạn chưa chọn loại tài khoản.',
            'company_id.required' => 'Bạn chưa chọn company',
            'fullname.required' => 'Bạn chưa nhập họ tên',
            'email.required' => 'Bạn chưa nhập email',
            'email.unique' => 'Email đã được sử dụng.',
            'username.required' => 'Bạn chưa nhập username',
            'username.unique' => 'Username đã được sử dụng.',
            'password.required' => 'Bạn chưa nhập mật khẩu',
            're_password.required' => 'Bạn chưa nhập lại mật khẩu',
            're_password.same' => 'Nhập khẩu nhập lại không khớp'                        
        ]);       
        
        $tmpPassword = str_random(10);        
        $dataArr['password'] = Hash::make($request->password);
        
        $dataArr['created_user'] = Auth::user()->id;

        $dataArr['updated_user'] = Auth::user()->id;
        $dataArr['group_user_id'] = (int) $dataArr['group_user_id'];
        
        $loginType = Auth::user()->type;
        $loginId = Auth::user()->id;
        $detailCurr = Account::find($loginId);

        $dataArr['company_user_id'] = $request->company_user_id ? $request->company_user_id : null;
        $dataArr['operator_user_id'] = $request->operator_user_id ? $request->operator_user_id : null;
        $dataArr['executive_user_id'] = $request->executive_user_id ? $request->executive_user_id : null;
        $dataArr['supervisor_user_id'] = $request->supervisor_user_id ? $request->supervisor_user_id : null;

        if($loginType == 2){
            $dataArr['company_user_id'] = $loginId;
        }elseif($loginType == 3){            
            $dataArr['company_user_id'] = $detailCurr->company_user_id;
            $dataArr['operator_user_id'] = $loginId;
        }elseif($loginType == 4){
            $dataArr['company_user_id'] = $detailCurr->company_user_id;
            $dataArr['operator_user_id'] = $detailCurr->operator_user_id;
            $dataArr['executive_user_id'] = $loginId;
        }elseif($loginType == 5){
            $dataArr['company_user_id'] = $detailCurr->company_user_id;
            $dataArr['operator_user_id'] = $detailCurr->operator_user_id;
            $dataArr['executive_user_id'] = $detailCurr->executive_user_id;
            $dataArr['supervisor_user_id'] = $loginId;
        }

        $rs = Account::create($dataArr);
        $user_id = $rs->id;
        // xu ly tags
        if( !empty( $dataArr['province_id'] ) && $user_id ){
            
            foreach ($dataArr['province_id'] as $province_id) {
                $model = new UserProvince;
                $model->user_id = $user_id;
                $model->province_id  = $province_id;                
                $model->save();
            }
        }
        /*
        if ( $rs->id > 0 ){
            Mail::send('backend.account.mail', ['full_name' => $request->full_name, 'password' => $tmpPassword, 'email' => $request->email], function ($message) use ($request) {
                $message->from( config('mail.username'), config('mail.name'));

                $message->to( $request->email, $request->full_name )->subject('Mật khẩu đăng nhập hệ thống');
            });   
        }*/

        Session::flash('message', 'Tạo mới tài khoản thành công.');

        return redirect()->route('account.index');
    }
    public function destroy($id)
    {
        $loginType = Auth::user()->type;
        if($loginType > 2){
            return redirect()->route('shop.index');
        }
        // delete
        $model = Account::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa tài khoản thành công');
        return redirect()->route('account.index');
    }
    public function edit($id)
    {
        $loginType = Auth::user()->type;
        if($loginType > 2){
            return redirect()->route('shop.index');
        }
        $detail = Account::find($id);
        /*
        if($detail->created_user !=  Auth::user()->id && Auth::user()->type == 2){
            return redirect()->route('shop.index');   
        } 
        */       
        $companyList = Company::all();        
        $tmp = UserProvince::where('user_id', $id)->get();
        $provinceSelected = [];
        if($tmp){
            foreach($tmp as $pro){
                $provinceSelected[] = $pro->province_id;
            }
        }
        
        $groupList = GroupUser::all();
        $provinceList = Province::all();
        $userList['company'] = $userList['operator'] = $userList['executive'] = $userList['supervisor'] = [];
        //get list province       
        if($detail->type == 6){
            $userList['company'] = Account::where([
                                            'company_id' => $detail->company_id, 
                                            'type' => 2
                                            ])->get();
            $userList['operator'] = Account::where([
                                            'company_id' => $detail->company_id, 
                                            'type' => 3, 
                                            'company_user_id' => $detail->company_user_id
                                            ])->get();
            $userList['executive'] = Account::where([
                                            'company_id' => $detail->company_id, 
                                            'type' => 4, 
                                            'company_user_id' => $detail->company_user_id, 
                                            'operator_user_id' => $detail->operator_user_id
                                            ])->get();
            $userList['supervisor'] = Account::where([
                                            'company_id' => $detail->company_id, 
                                            'type' => 5, 
                                            'company_user_id' => $detail->company_user_id, 
                                            'operator_user_id' => $detail->operator_user_id, 
                                            'executive_user_id' => $detail->executive_user_id
                                            ])->get();
            $provinceList = Province::whereRaw('id IN (SELECT province_id FROM user_province WHERE user_id='.$detail->supervisor_user_id.')')->get();
        }elseif($detail->type == 5){
            $userList['company'] = Account::where([
                                            'company_id' => $detail->company_id, 
                                            'type' => 2
                                            ])->get();
            $userList['operator'] = Account::where([
                                            'company_id' => $detail->company_id, 
                                            'type' => 3, 
                                            'company_user_id' => $detail->company_user_id
                                            ])->get();
            $userList['executive'] = Account::where([
                                            'company_id' => $detail->company_id, 
                                            'type' => 4, 
                                            'company_user_id' => $detail->company_user_id, 
                                            'operator_user_id' => $detail->operator_user_id
                                            ])->get();          
            $provinceList = Province::whereRaw('id IN (SELECT province_id FROM user_province WHERE user_id='.$detail->executive_user_id.')')->get();
        }elseif($detail->type == 4){
             $userList['company'] = Account::where([
                                            'company_id' => $detail->company_id, 
                                            'type' => 2
                                            ])->get();
            $userList['operator'] = Account::where([
                                            'company_id' => $detail->company_id, 
                                            'type' => 3, 
                                            'company_user_id' => $detail->company_user_id
                                            ])->get();
           
            $provinceList = Province::whereRaw('id IN (SELECT province_id FROM user_province WHERE user_id='.$detail->operator_user_id.')')->get();
        }
        if($detail->type > 2){
            $groupList = GroupUser::where('company_id', Auth::user()->company_id)->get();         
            $provinceTmp = Province::whereRaw('id IN (SELECT province_id FROM user_province WHERE user_id='.$detail->id.')')->get();
            foreach($provinceTmp as $tmp){
                $provinceSelected[] = $tmp->id;
            }
        }
        return view('backend.account.edit', compact( 'detail', 'groupList', 'companyList', 'provinceList', 'provinceSelected',
            'userList'));
    }
    public function ajaxGetListProvinceUser(Request $request){
        $user_id = $request->user_id;
        $provinceList = Province::whereRaw('id IN (SELECT province_id FROM user_province WHERE user_id='.$user_id.')')->get();
        $str = '';
        foreach($provinceList as $province){
            $str.= '<option value='.$province->id.'>'.$province->name.'</option>';
        }
        echo $str;
    }
    public function update(Request $request)
    {
        $dataArr = $request->all();
        
        $this->validate($request,[            
            'fullname' => 'required',
            'email' => 'required'
        ],
        [ 
            'fullname.required' => 'Bạn chưa nhập họ tên',            
            'email.required' => 'Bạn chưa nhập email'               
        ]);        
            

        $model = Account::find($dataArr['id']);

        $dataArr['updated_user'] = Auth::user()->id;
        $dataArr['group_user_id'] = (int) $dataArr['group_user_id'];
        
        $loginType = Auth::user()->type;
        $loginId = Auth::user()->id;
        $detailCurr = Account::find($loginId);

        $dataArr['company_user_id'] = $request->company_user_id ? $request->company_user_id : $model->company_user_id;
        $dataArr['operator_user_id'] = $request->operator_user_id ? $request->operator_user_id : $model->operator_user_id;
        $dataArr['executive_user_id'] = $request->executive_user_id ? $request->executive_user_id : $model->executive_user_id;
        $dataArr['supervisor_user_id'] = $request->supervisor_user_id ? $request->supervisor_user_id : $model->supervisor_user_id;

        if($loginType == 2){
            $dataArr['company_user_id'] = $loginId;
        }elseif($loginType == 3){            
            $dataArr['company_user_id'] = $detailCurr->company_user_id;
            $dataArr['operator_user_id'] = $loginId;
        }elseif($loginType == 4){
            $dataArr['company_user_id'] = $detailCurr->company_user_id;
            $dataArr['operator_user_id'] = $detailCurr->operator_user_id;
            $dataArr['executive_user_id'] = $loginId;
        }elseif($loginType == 5){
            $dataArr['company_user_id'] = $detailCurr->company_user_id;
            $dataArr['operator_user_id'] = $detailCurr->operator_user_id;
            $dataArr['executive_user_id'] = $detailCurr->executive_user_id;
            $dataArr['supervisor_user_id'] = $loginId;
        }

        $model->update($dataArr);

        UserProvince::where(['user_id' => $dataArr['id']])->delete();
        if( !empty( $dataArr['province_id'] ) &&  $dataArr['id'] ){
            

            foreach ($dataArr['province_id'] as $province_id) {
                $model = new UserProvince;
                $model->user_id =  $dataArr['id'];
                $model->province_id  = $province_id;                
                $model->save();
            }
        }

        Session::flash('message', 'Cập nhật tài khoản thành công');

        return redirect()->route('account.index');
    }
    public function updateStatus(Request $request)
    {       

        $model = Account::find( $request->id );

        
        $model->updated_user = Auth::user()->id;
        $model->status = $request->status;

        $model->save();
        $mess = $request->status == 1 ? "Mở khóa tài khoản thành công" : "Khóa tài khoản thành công";
        Session::flash('message', $mess);

        return redirect()->route('account.index');
    }
}
