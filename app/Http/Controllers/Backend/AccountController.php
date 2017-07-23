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
        if(Auth::user()->type > 2){
            return redirect()->route('shop.index');
        }
        $loginType = $leader_id = 0;
        
        $searchArr['company_id'] = $company_id = $request->company_id ? $request->company_id : null;
        
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

        $query = Account::where('status', '>', 0);
       
        if($company_id){            
            $query->where('company_id', $company_id);
        }
        if( $loginType == 2){            
            $query->where(['created_user' => Auth::user()->id]);
            $groupList = GroupUser::where('company_id', Auth::user()->company_id)->get();
            $companyList = (object)[];
        }else{
            $groupList = GroupUser::all();
            $companyList = Company::all();
            $type = $request->type ? $request->type : 0;
            
            $leader_id = $request->leader_id ? $request->leader_id : 0;
            if($leader_id > 0){
                $query->where('leader_id', $leader_id);
            }
        }
        
        
        $searchArr['type'] = $typeArr = $request->type ? $request->type : $typeArrDefault;
        var_dump($request->type);
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
        $items = $query->orderBy('user.type')->orderBy('id', 'desc')->get();
        $modList = Account::where(['type' => 2, 'status' => 1])->get();        
        
        $provinceList = Province::all();        
        return view('backend.account.index', compact('items', 'typeArr', 'leader_id', 'modList', 'groupList', 'companyList', 'provinceList', 'searchArr'));
    }
    public function ajaxGetAccount
    public function create()
    {        
        if(Auth::user()->type > 2){
            return redirect()->route('shop.index');
        }
        if(Auth::user()->type == 2){
            $groupList = GroupUser::where('company_id', Auth::user()->company_id)->get();         
            $provinceList = Province::whereRaw('id IN (SELECT province_id FROM user_province WHERE user_id='.Auth::user()->id.')')->get();
        }else{
            $groupList = GroupUser::all();
            $provinceList = Province::all();
        }

        $modList = Account::where(['type' => 2, 'status' => 1])->get();
        
        $companyList = Company::all();
        
        return view('backend.account.create', compact('modList', 'groupList', 'companyList', 'provinceList'));
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
            'company_id' => 'required',
            'fullname' => 'required',
            'email' => 'required|unique:user,email',
            'username' => 'required|unique:user,username',
            'password' => 'required',
            're_password' => 'required|same:password',            
            'type' => 'required'
        ],
        [
            'company_id.required' => 'Bạn chưa chọn company',
            'fullname.required' => 'Bạn chưa nhập họ tên',
            'username.required' => 'Bạn chưa nhập username',
            'username.unique' => 'Username đã được sử dụng.',
            'password.required' => 'Bạn chưa nhập mật khẩu',
            're_password.required' => 'Bạn chưa nhập lại mật khẩu',
            're_password.same' => 'Nhập khẩu nhập lại không khớp',            
            'email.required' => 'Bạn chưa nhập email',
            'email.unique' => 'Email đã được sử dụng.',
            'type.required' => 'Bạn chưa chọn loại tài khoản.'
        ]);       
        
        $tmpPassword = str_random(10);        
        $dataArr['password'] = Hash::make($request->password);
        
        $dataArr['created_user'] = Auth::user()->id;

        $dataArr['updated_user'] = Auth::user()->id;
        $dataArr['group_user_id'] = (int) $dataArr['group_user_id'];

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
        if(Auth::user()->type == 1){
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
        if(Auth::user()->type > 2){
            return redirect()->route('shop.index');
        }
        $detail = Account::find($id);
        if($detail->created_user !=  Auth::user()->id && Auth::user()->type == 2){
            return redirect()->route('shop.index');   
        }        
        $companyList = Company::all();        
        $tmp = UserProvince::where('user_id', $id)->get();
        $provinceSelected = [];
        if($tmp){
            foreach($tmp as $pro){
                $provinceSelected[] = $pro->province_id;
            }
        }
        if(Auth::user()->type == 2){
            $groupList = GroupUser::where('company_id', Auth::user()->company_id)->get();         
            $provinceList = Province::whereRaw('id IN (SELECT province_id FROM user_province WHERE user_id='.Auth::user()->id.')')->get();
        }else{
            $groupList = GroupUser::all();
            $provinceList = Province::all();
        }
        return view('backend.account.edit', compact( 'detail', 'groupList', 'companyList', 'provinceList', 'provinceSelected'));
    }
    public function update(Request $request)
    {
        $dataArr = $request->all();
        
        $this->validate($request,[
            'company_id' => 'required',
            'fullname' => 'required',
            'email' => 'required',                      
            'type' => 'required'
        ],
        [
            'company_id.required' => 'Bạn chưa chọn company',
            'fullname.required' => 'Bạn chưa nhập họ tên',                         
            'email.required' => 'Bạn chưa nhập email',            
            'type.required' => 'Bạn chưa chọn loại tài khoản.'
        ]);       
            

        $model = Account::find($dataArr['id']);

        $dataArr['updated_user'] = Auth::user()->id;
        $dataArr['group_user_id'] = (int) $dataArr['group_user_id'];
        
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
