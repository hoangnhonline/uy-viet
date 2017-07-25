@extends('backend.layout')
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
                @if($loginType == 1)
                <div class="form-group col-md-12">
                  <label>Company <span class="red-star">*</span></label>
                  <select class="form-control required" name="company_id" id="company_id">      
                    <option value="" >--Chọn--</option>
                    @foreach($companyList as $com)
                    <option value="{{ $com->id }}" {{ old('company_id') == $com->id ? "selected" : "" }}>{{ $com->company_name }}</option> 
                    @endforeach
                  </select>
                </div>  <!-- text input -->
                @else                
                <input type="hidden" class="required" id="company_id" name="company_id" value="{{ Auth::user()->company_id }}">
                @endif
                <div class="form-group col-md-12" id="div_type" style="display:none">
                  <label>Type <span class="red-star">*</span></label>
                  <select class="form-control required" name="type" id="type">      
                    <option value="" >--Chọn type--</option>                       
                    @if($loginType == 1)
                    <option value="2" {{ old('type') == 2 ? "selected" : "" }}>Company</option>
                    @endif              
                    @if($loginType <= 2)      
                    <option value="3" {{ old('type') == 3 ? "selected" : "" }}>Operator</option> 
                    @endif
                    @if($loginType <= 3)
                    <option value="4" {{ old('type') == 4 ? "selected" : "" }}>Executive</option>
                    @endif
                    @if($loginType <= 4)
                    <option value="5" {{ old('type') == 5 ? "selected" : "" }}>Supervisor</option>
                    @endif
                    @if($loginType <= 5)
                    <option value="6" {{ old('type') == 6 ? "selected" : "" }}>Sale</option>
                    @endif
                  </select>
                </div> 
                  <div class="clearfix"></div>
                  <div class="form-group col-md-6 role" id="div_company"  style="display:none">
                    <label>User Company <span class="red-star">*</span></label>
                    <select class="form-control role no-check-province" name="company_user_id" id="company_user_id">      
                      <option value="" >--Chọn--</option>                      
                    </select>
                  </div>
                  <div class="form-group col-md-6 role" id="div_operator"  style="display:none">
                    <label>User Operator <span class="red-star">*</span></label>
                    <select class="form-control role" name="operator_user_id" id="operator_user_id">      
                      <option value="" >--Chọn--</option>                      
                    </select>
                  </div>
                  <div class="form-group col-md-6 role" id="div_executive"  style="display:none">
                    <label>User Executive <span class="red-star">*</span></label>
                    <select class="form-control role" name="executive_user_id" id="executive_user_id">      
                      <option value="" >--Chọn--</option>                      
                    </select>
                  </div>
                  <div class="form-group col-md-6 role" id="div_supervisor"  style="display:none">
                    <label>User Supervisor<span class="red-star">*</span></label>
                    <select class="form-control role" name="supervisor_user_id" id="supervisor_user_id">      
                      <option value="" >--Chọn--</option>                      
                    </select>
                  </div>
               
                  <div class="clearfix"></div>
                <div class="form-group col-md-6">
                  <label>Họ tên <span class="red-star">*</span></label>
                  <input type="text" class="form-control required" name="fullname" id="fullname" value="{{ old('fullname') }}">
                </div>
                 <div class="form-group col-md-6">
                  <label>Email <span class="red-star">*</span></label>
                  <input type="email" class="form-control required" name="email" id="email" value="{{ old('email') }}">
                </div>                
                <div class="form-group col-md-6">
                  <label>Username <span class="red-star">*</span></label>
                  <input type="text" class="form-control required" name="username" id="username" value="{{ old('username') }}">
                </div>
                <div class="form-group col-md-6">
                  <label>Điện thoại</label>
                  <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone') }}">
                </div>
                <div class="form-group col-md-6">
                  <label>Mật khẩu <span class="red-star">*</span></label>
                  <input type="password" class="form-control required" name="password" id="password" value="{{ old('password') }}">
                </div> 
                <div class="form-group col-md-6">
                  <label>Nhập lại mật khẩu <span class="red-star">*</span></label>
                  <input type="password" class="form-control required" name="re_password" id="re_password" value="{{ old('re_password') }}">
                </div>                
                <div class="form-group col-md-6">
                  <label>Trạng thái</label>
                  <select class="form-control" name="status" id="status">                                      
                    <option value="1" {{ old('status') == 1 || old('status') == NULL ? "selected" : "" }}>Mở</option>                  
                    <option value="2" {{ old('status') == 2 ? "selected" : "" }}>Khóa</option>                  
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label>Khu vực</label>
                  <select class="form-control" name="group_user_id" id="group_user_id">      
                    <option value="" >--Chọn khu vực--</option>
                    @foreach($groupList as $group)
                    <option value="{{ $group->id }}" {{ old('group_user_id') == $group->id ? "selected" : "" }}>{{ $group->name }}</option> 
                    @endforeach
                  </select>
                </div>       
                <div class="form-group col-md-12">
                    <label>Tỉnh / Thành</label>
                    <select class="form-control select2" name="province_id[]" id="province_id" multiple="multiple">                  
                      @if( $provinceList->count() > 0)
                        @foreach( $provinceList as $value )
                        <option value="{{ $value->id }}" {{ (in_array($value->id, old('tags', []))) ? "selected" : "" }}>{{ $value->name }}</option>
                        @endforeach
                      @endif
                    </select>                    
                  </div>         
                
            </div>
            <div class="box-footer">
              <div class="col-md-12">
                <button type="button" class="btn btn-default btn-sm" id="btnLoading" style="display:none"><i class="fa fa-spin fa-spinner"></i></button>
                <button type="submit" class="btn btn-primary btn-sm" id="btnSave">Lưu</button>
                <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="{{ route('account.index')}}">Hủy</a>
              </div>
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
  <style type="text/css">
    .error{
      border:1px solid red;
    }
  </style>
</div>
@stop
@section('javascript_page')
<script type="text/javascript">
    $(document).ready(function(){
      $('#formData').submit(function(){
        $('#btnSave').hide();
        $('#btnLoading').show();
      });
      $('#type').change(function(){

      });
      $('#btnSave').click(function(){
        var err = err_pass = 0;
        $('#formData input.required, #formData select.required').each(function(){
          console.log($.trim($(this).val()));
          if($(this).val() == ''){
            $(this).addClass('error');
            err++;
          }else{
            $(this).removeClass('error');
          }
        });
        if($('#password').val() != $('#re_password').val()){
          err_pass++;
          $('#re_password').addClass('error');
        }
        if(err > 0){          
          return false;
        }
      });
      $('#formData input.required').blur(function(){
        if($.trim($(this).val()) != ''){
          $(this).removeClass('error');
        }
      });
       $('#formData select.required').change(function(){   
        if($.trim($(this).val()) != ''){
          $(this).removeClass('error');
        }
      });
      $('#company_id').change(function(){
        var company_id = $(this).val();
        if(company_id > 0){
          $('#div_type').show();
        }else{
          $('#div_type').hide();
        }
        $('#type').val('');
        $('#div_company, #div_operator, #div_executive, #div_supervisor').hide();
        $('#company_user_id, #operator_user_id, #executive_user_id, #supervisor_user_id').html('');
      });
      $('#type').change(function(){
        $('div.role').hide().find('select').val('');
        $('select.role').each(function(){
          if($(this).hasClass('required')){
            $(this).removeClass('required');
          }
        });        
        var company_id = $('#company_id').val();
        var type = $('#type').val();
        if(type > 0 && company_id > 0){
        $.ajax({
            url : "{{ route('account.get-user-list-by-type') }}",
            data : {
              company_id : company_id,
              type : type
            },
            type : "POST",
            success : function(data){              
              // company
              if(type > 2){
                $('#company_user_id').html('').append($('<option>', {
                    value: '',
                    text: '--chon--',

                }));
                for (var i = 0; i < data.company.length; i++) {
                    $('#company_user_id').append($('<option>', {
                        value: data.company[i].id,
                        text: data.company[i].fullname,
                    }));
                }
                $('#div_company').show();
                $('#company_user_id').addClass('required');
              }
              if(type > 3){
                $('#operator_user_id').html('').append($('<option>', {
                    value: '',
                    text: '--chon--',

                }));
                for (var i = 0; i < data.operator.length; i++) {
                    $('#operator_user_id').append($('<option>', {
                        value: data.operator[i].id,
                        text: data.operator[i].fullname,
                    }));
                }
                $('#operator_user_id').addClass('required');
                $('#div_operator').show();
              }
              if(type > 4){
                $('#executive_user_id').html('').append($('<option>', {
                    value: '',
                    text: '--chon--',

                }));
                for (var i = 0; i < data.executive.length; i++) {
                    $('#executive_user_id').append($('<option>', {
                        value: data.executive[i].id,
                        text: data.executive[i].fullname,
                    }));
                }
                $('#div_executive').show();
                $('#executive_user_id').addClass('required');
              }
              if(type > 5){
                $('#supervisor_user_id').html('').append($('<option>', {
                    value: '',
                    text: '--chon--',

                }));
                for (var i = 0; i < data.supervisor.length; i++) {
                    $('#supervisor_user_id').append($('<option>', {
                        value: data.supervisor[i].id,
                        text: data.supervisor[i].fullname,
                    }));
                }
                $('#div_supervisor').show();
                $('#supervisor_user_id').addClass('required');
              }
            }
          });
        }else{
          alert('Vui long chon company!');return false;
        }
      });
      $('#company_user_id').change(function(){
          if($('#type').val() > 3){
            $.ajax({
              url : "{{ route('account.get-user-list-by-owner') }}",
              data : {
                company_id : $('#company_id').val(),
                user_id : $('#company_user_id').val(),
                column : 'company_user_id'
              },
              type : "POST",
              success : function(data){   
                var type = $('#type').val();             
                if(type > 3){
                  $('#operator_user_id').html('').append($('<option>', {
                      value: 0,
                      text: '--chon--',

                  }));
                  for (var i = 0; i < data.operator.length; i++) {
                      $('#operator_user_id').append($('<option>', {
                          value: data.operator[i].id,
                          text: data.operator[i].fullname,
                      }));
                  }
                  $('#div_operator').show();
                }
                if(type > 4){
                  $('#executive_user_id').html('').append($('<option>', {
                      value: 0,
                      text: '--chon--',

                  }));
                  for (var i = 0; i < data.executive.length; i++) {
                      $('#executive_user_id').append($('<option>', {
                          value: data.executive[i].id,
                          text: data.executive[i].fullname,
                      }));
                  }
                  $('#div_executive').show();
                }
                if(type > 5){
                  $('#supervisor_user_id').html('').append($('<option>', {
                      value: 0,
                      text: '--chon--',

                  }));
                  for (var i = 0; i < data.supervisor.length; i++) {
                      $('#supervisor_user_id').append($('<option>', {
                          value: data.supervisor[i].id,
                          text: data.supervisor[i].fullname,
                      }));
                  }
                  $('#div_supervisor').show();
                }
            }
          });
          }
      });
      $('#operator_user_id').change(function(){
          if($('#type').val() > 4){
            $.ajax({
              url : "{{ route('account.get-user-list-by-owner') }}",
              data : {
                company_id : $('#company_id').val(),
                user_id : $('#operator_user_id').val(),
                column : 'operator_user_id'
              },
              type : "POST",
              success : function(data){   
                var type = $('#type').val();
                if(type > 4){
                  $('#executive_user_id').html('').append($('<option>', {
                      value: 0,
                      text: '--chon--',

                  }));
                  for (var i = 0; i < data.executive.length; i++) {
                      $('#executive_user_id').append($('<option>', {
                          value: data.executive[i].id,
                          text: data.executive[i].fullname,
                      }));
                  }
                  $('#div_executive').show();
                }
                if(type > 5){
                  $('#supervisor_user_id').html('').append($('<option>', {
                      value: 0,
                      text: '--chon--',

                  }));
                  for (var i = 0; i < data.supervisor.length; i++) {
                      $('#supervisor_user_id').append($('<option>', {
                          value: data.supervisor[i].id,
                          text: data.supervisor[i].fullname,
                      }));
                  }
                  $('#div_supervisor').show();
                }
              }
            });
          }
      });
      $('#executive_user_id').change(function(){
          if($('#type').val() > 5){
          $.ajax({
            url : "{{ route('account.get-user-list-by-owner') }}",
            data : {
              company_id : $('#company_id').val(),
              user_id : $('#executive_user_id').val(),
              column : 'executive_user_id'
            },
            type : "POST",
            success : function(data){   
              var type = $('#type').val();              
              if(type > 5){
                $('#supervisor_user_id').html('').append($('<option>', {
                    value: 0,
                    text: '--chon--',

                }));
                for (var i = 0; i < data.supervisor.length; i++) {
                    $('#supervisor_user_id').append($('<option>', {
                        value: data.supervisor[i].id,
                        text: data.supervisor[i].fullname,
                    }));
                }
                $('#div_supervisor').show();
              }
            }
          });
        }
      });
      $(document).on('change', 'select.role', function(){
        if($(this).hasClass('no-check-province') == false){
          getListProvince($(this).val());
        }
      });
      @if($loginType == 3)
      $('#type').change(function(){
        if($(this).val() == 1){
          $('#chon_mod').show();
        }else{
          $('#chon_mod').hide();
        }
      });
      @endif
    });
    function getListProvince(user_id){
      $.ajax({
            url : "{{ route('account.get-list-province-user') }}",
            data : {              
              user_id : user_id          
            },
            type : "POST",
            success : function(data){   
              $('#province_id').html(data).select2('refresh');
            }
          });
    }
</script>
@stop
