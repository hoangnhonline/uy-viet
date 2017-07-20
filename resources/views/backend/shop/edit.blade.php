@extends('layout.backend')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Cập nhật tài khoản
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('account.index') }}">Tài khoản</a></li>
      <li class="active">Cập nhật</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('account.index') }}" style="margin-bottom:5px">Quay lại</a>
    <form role="form" method="POST" action="{{ route('account.update') }}" id="formData">
    <input type="hidden" name="id" value="{{ $detail->id }}">
    <div class="row">
      <!-- left column -->

      <div class="col-md-8">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Cập nhật</h3>
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
                 
                <div class="form-group col-md-6">
                  <label>Company</label>
                  <select class="form-control" name="company_id" id="company_id">      
                    <option value="" >--Chọn--</option>
                    @foreach($companyList as $com)
                    <option value="{{ $com->id }}" {{ $com->id == $detail->company_id ? "selected" : "" }}>{{ $com->company_name }}</option>
                    @endforeach
                  </select>
                </div>  <!-- text input -->
                <div class="form-group col-md-6">
                  <label>Loại shop</label>
                  <select class="form-control" name=" type_id" id=" type_id">      
                    <option value="" >--Chọn--</option>
                    @foreach($shopTypeList as $com)
                    <option value="{{ $com->id }}" {{ $com->id == $detail->type_id ? "selected" : "" }}>{{ $com->type }}</option>
                    @endforeach
                  </select>
                </div>  <!-- text input -->
                <div class="form-group col-md-4">
                  <label> Tỉnh/Thành <span class="red-star">*</span></label>
                  <select class="form-control" name="province_id" id="province_id">      
                    <option value="" >--Chọn--</option>
                    @foreach($provinceList as $province)
                      <option value="{{$province->id}}" {{ $province->id == $detail->province_id ? "selected" : "" }}>{{$province->name}}</option>
                      @endforeach
                  </select>
                   
                </div>
                <div class="form-group col-md-4">
                  <label> Quận/Huyện <span class="red-star">*</span></label>
                  <select class="form-control" name="district_id" id="district_id">      
                    <option value="" >--Chọn--</option>
                    @foreach($districtList as $district)
                      <option value="{{$district->id}}" {{ $district->id == $detail->district_id ? "selected" : "" }}>{{$district->name}}</option>
                      @endforeach
                  </select>
                   
                </div>
                <div class="form-group col-md-4">
                  <label> Phường/Xã <span class="red-star">*</span></label>
                  <select class="form-control" name="ward_id" id="ward_id">      
                    <option value="" >--Chọn--</option>
                    @foreach($wardList as $ward)
                      <option value="{{$ward->id}}" {{ $ward->id == $detail->ward_id ? "selected" : "" }}>{{$ward->name}}</option>
                      @endforeach
                  </select>
                   
                </div>
                 <div class="form-group col-md-12">
                  <label>Tên shop <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="shop_name" id="shop_name" value="{{ old('shop_name', $detail->shop_name) }}">
                </div>
                <div class="form-group col-md-6">
                  <label>Địa chỉ <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="address" id="address" value="{{ old('address', $detail->address) }}">
                </div>
                <div class="form-group col-md-6">
                  <label>Đường phố </label>
                  <input type="text" class="form-control" name="street" id="street"  value="{{ old('street', $detail->street) }}">
                </div> 
                <div class="form-group col-md-12">
                  <label>Địa chỉ đầy đủ <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="full_address" id="full_address" value="{{ old('full_address', $detail->full_address) }}">
                </div>
                <div class="form-group col-md-6">
                  <label>Người liên hệ </label>
                  <input type="text" class="form-control" name="namer" id="namer"  value="{{ old('namer', $detail->namer) }}">
                </div> 
                <div class="form-group col-md-6">
                  <label>Số điện thoại <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', $detail->phone) }}">
                </div>                            
                <div class="form-group col-md-12">
                  <label>Trạng thái</label>
                  <select class="form-control" name="status" id="status">                                      
                    <option value="1" {{ old('status', $detail->status) == 1 ? "selected" : "" }}>Hiện </option>                  
                    <option value="2" {{ old('status', $detail->status) == 2 ? "selected" : "" }}>Ẩn</option>                  
                  </select>
                </div>
            </div>
            <div class="box-footer ">
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
