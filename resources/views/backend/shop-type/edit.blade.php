@extends('layout.backend')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Danh mục  
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('shop-type.index') }}">Danh mục</a></li>
      <li class="active"><span class="glyphicon glyphicon-pencil"></span></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('shop-type.index') }}" style="margin-bottom:5px">Quay lại</a>   
    <form role="form" method="POST" action="{{ route('shop-type.update') }}">
    <div class="row">
      <!-- left column -->
      <input name="id" value="{{ $detail->id }}" type="hidden">
      <div class="col-md-7">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            Chỉnh sửa
          </div>
          <!-- /.box-header -->               
            {!! csrf_field() !!}

            <div class="box-body">
              @if(Session::has('message'))
              <p class="alert alert-info" >{{ Session::get('message') }}</p>
              @endif
              @if (count($errors) > 0)
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif                
                                           
                
                <div class="form-group" >
                  
                  <label>Tên danh mục <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="type" id="type" value="{{ $detail->type }}">
                </div>                                
                <div class="form-group" style="margin-top:10px;margin-bottom:10px">  
                  <label class="col-md-3 row">Icon ( 30 x 30px ) </label>    
                  <div class="col-md-9">
                    <img id="thumbnail_icon" src="{{ $detail->icon_url ? Helper::showImage($detail->icon_url ) : URL::asset('admin/dist/img/img.png') }}" class="img-thumbnail" width="60" height="60">
                    
                    <input type="file" id="file-icon" style="display:none" />
                 
                    <button class="btn btn-default btn-sm" id="btnUploadIcon" type="button"><span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Upload</button>
                  </div>
                  <div style="clear:both"></div>
                </div>
                <div style="clear:both"></div>                
                <div class="form-group">
                  <label>Ẩn/hiện</label>
                  <select class="form-control" name="status" id="status">                  
                    <option value="0" {{ $detail->status == 0 ? "selected" : "" }}>Ẩn</option>
                    <option value="1" {{ $detail->status == 1 ? "selected" : "" }}>Hiện</option>                  
                  </select>
                </div>                  
            </div>          
            <input type="hidden" name="icon_url" id="icon_url" value="{{ $detail->icon_url }}"/>          
            <input type="hidden" name="icon_name" id="icon_name" value=""/>
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
              <a class="btn btn-default btn-sm" href="{{ route('shop-type.index')}}">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      <div class="col-md-5">
             
    </div>
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<input type="hidden" id="route_upload_tmp_image" value="{{ route('image.tmp-upload') }}">

@stop
@section('javascript_page')
<script type="text/javascript">
    $(document).ready(function(){
      
      $('#btnUploadIcon').click(function(){        
        $('#file-icon').click();
      });      
      var files = "";
      $('#file-icon').change(function(e){
         files = e.target.files;
         
         if(files != ''){
           var dataForm = new FormData();        
          $.each(files, function(key, value) {
             dataForm.append('file', value);
          });   
          
          dataForm.append('date_dir', 1);
          dataForm.append('folder', 'tmp');

          $.ajax({
            url: $('#route_upload_tmp_image').val(),
            type: "POST",
            async: false,      
            data: dataForm,
            processData: false,
            contentType: false,
            success: function (response) {
              if(response.image_path){
                $('#thumbnail_icon').attr('src',$('#upload_url').val() + response.image_path);
                $( '#icon_url' ).val( response.image_path );
                $( '#icon_name' ).val( response.image_name );
              }
              console.log(response.image_path);
                //window.location.reload();
            },
            error: function(response){                             
                var errors = response.responseJSON;
                for (var key in errors) {
                  
                }
                //$('#btnLoading').hide();
                //$('#btnSave').show();
            }
          });
        }
      });
    
    });
    
</script>
@stop
