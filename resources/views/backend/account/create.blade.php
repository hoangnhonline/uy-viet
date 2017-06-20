@extends('layout.backend')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Tạo tài khoản
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('account.index') }}">Tài khoản</a></li>
      <li class="active">Tạo mới</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('account.index') }}" style="margin-bottom:5px">Quay lại</a>
    <form role="form" method="POST" action="{{ route('account.store') }}" id="formData">
    <div class="row">
      <!-- left column -->

      <div class="col-md-8">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Tạo mới</h3>
          </div>
          <!-- /.box-header -->               
            {!! csrf_field() !!}

            <div class="box-body">
              @if (count($errors) > 0)
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
                @if(Auth::user()->type == 1)
                <div class="form-group">
                  <label>Company</label>
                  <select class="form-control" name="company_id" id="company_id">      
                    <option value="" >--Chọn company--</option>
                    @foreach($companyList as $com)
                    <option value="{{ $com->id }}" {{ old('company_id') == $com->id ? "selected" : "" }}>{{ $com->company_name }}</option> 
                    @endforeach
                  </select>
                </div>  <!-- text input -->
                @else
                <input type="hidden" name="company_id" value="{{ Auth::user()->company_id }}">
                @endif
                <div class="form-group">
                  <label>Họ tên <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="fullname" id="fullname" value="{{ old('fullname') }}">
                </div>
                 <div class="form-group">
                  <label>Email <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                  <label>Điện thoại</label>
                  <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone') }}">
                </div>
                <div class="form-group">
                  <label>Username <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="username" id="username" value="{{ old('username') }}">
                </div>
                <div class="form-group">
                  <label>Mật khẩu <span class="red-star">*</span></label>
                  <input type="password" class="form-control" name="password" id="password" value="{{ old('password') }}">
                </div> 
                <div class="form-group">
                  <label>Nhập lại mật khẩu <span class="red-star">*</span></label>
                  <input type="password" class="form-control" name="re_password" id="re_password" value="{{ old('re_password') }}">
                </div>                
                <div class="form-group">
                  <label>Type <span class="red-star">*</span></label>
                  <select class="form-control" name="type" id="type">      
                    <option value="" >--Chọn type--</option>                       
                    @if(Auth::user()->type == 1)
                    <option value="2" {{ old('type') == 2 ? "selected" : "" }}>Company</option>                  
                    @endif                    
                    <option value="3" {{ old('type') == 3 ? "selected" : "" }}>Operator</option> 
                    <option value="4" {{ old('type') == 4 ? "selected" : "" }}>Executive</option>
                    <option value="5" {{ old('type') == 5 ? "selected" : "" }}>Supervisor</option>
                    <option value="6" {{ old('type') == 6 ? "selected" : "" }}>Sale</option>
                  </select>
                </div> 
                <div class="form-group">
                  <label>Khu vực</label>
                  <select class="form-control" name="group_user_id" id="group_user_id">      
                    <option value="" >--Chọn khu vực--</option>
                    @foreach($groupList as $group)
                    <option value="{{ $group->id }}" {{ old('group_user_id') == $group->id ? "selected" : "" }}>{{ $group->name }}</option> 
                    @endforeach
                  </select>
                </div>       
                <div class="form-group">
                    <label>Tỉnh / Thành</label>
                    <select class="form-control select2" name="province_id[]" id="province_id" multiple="multiple">                  
                      @if( $provinceList->count() > 0)
                        @foreach( $provinceList as $value )
                        <option value="{{ $value->id }}" {{ (in_array($value->id, old('tags', []))) ? "selected" : "" }}>{{ $value->name }}</option>
                        @endforeach
                      @endif
                    </select>                    
                  </div>         
                <div class="form-group">
                  <label>Trạng thái</label>
                  <select class="form-control" name="status" id="status">                                      
                    <option value="1" {{ old('status') == 1 || old('status') == NULL ? "selected" : "" }}>Mở</option>                  
                    <option value="2" {{ old('status') == 2 ? "selected" : "" }}>Khóa</option>                  
                  </select>
                </div>
            </div>
            <div class="box-footer">
              <button type="button" class="btn btn-default btn-sm" id="btnLoading" style="display:none"><i class="fa fa-spin fa-spinner"></i></button>
              <button type="submit" class="btn btn-primary btn-sm" id="btnSave">Lưu</button>
              <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="{{ route('account.index')}}">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      <div class="col-md-4">
      </div>
      <!--/.col (left) -->      
    </div>
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
@stop
@section('javascript_page')
<script type="text/javascript">
    $(document).ready(function(){
      $('#formData').submit(function(){
        $('#btnSave').hide();
        $('#btnLoading').show();
      });
      @if(Auth::user()->type == 3)
      $('#type').change(function(){
        if($(this).val() == 1){
          $('#chon_mod').show();
        }else{
          $('#chon_mod').hide();
        }
      });
      @endif
    });
    
</script>
@stop
