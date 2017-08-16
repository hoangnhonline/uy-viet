@extends('backend.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Điều kiện     
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('dieu-kien.index') }}">Điều kiện</a></li>
      <li class="active">Tạo mới</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('dieu-kien.index') }}" style="margin-bottom:5px">Quay lại</a>
    <form role="form" method="POST" action="{{ route('dieu-kien.store') }}">
    <div class="row">
      <!-- left column -->

      <div class="col-md-7">
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
              
                 <!-- text input -->
                <div class="form-group">
                  <label>Tên Table<span class="red-star">*</span> ( cú pháp : abc_xyz )</label>
                  <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" maxlength="100">
                </div>
                <div class="form-group">
                  <label>Tên hiển thị <span class="red-star">*</span></label>
                  <input type="text" class="form-control"  max-length="20" name="display_name"  id="display_name" value="{{ old('display_name') }}">
                </div>
                 <div class="form-group">
                  <label>Ẩn/hiện</label>
                  <select class="form-control" name="status" id="status">                  
                    <option value="0" {{ old('status') == 0 ? "selected" : "" }}>Ẩn</option>
                    <option value="1" {{ old('status') == 1 || old('status') == NULL ? "selected" : "" }}>Hiện</option>                  
                  </select>
                </div>
            </div>                        
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
              <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="{{ route('dieu-kien.index')}}">Hủy</a>
            </div>            
        </div>
        <!-- /.box -->     

      </div>
      <div class="col-md-5">
        <!-- general form elements -->
        
      <!--/.col (left) -->      
    </div>
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
@stop