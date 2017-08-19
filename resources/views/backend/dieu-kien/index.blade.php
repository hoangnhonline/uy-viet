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
    <li><a href="{{ route( 'dieu-kien.index' ) }}">Điều kiện</a></li>
    <li class="active">Danh sách</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      @if(Session::has('message'))
      <p class="alert alert-info" >{{ Session::get('message') }}</p>
      @endif
      <a href="{{ route('dieu-kien.create') }}" class="btn btn-info btn-sm" style="margin-bottom:5px">Tạo mới</a>
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Danh sách</h3>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">
        <form method="post" action={{ route('save-col-order')}} >
            {{ csrf_field() }}
            <input type="hidden" name="table" value="select_condition">
            <input type="hidden" name="return_url" value="{{ url()->current() }}">
            @if($items->count() > 0)
            <button type="submit" class="btn btn-warning btn-sm">Save thứ tự</button>
            @endif
          <table class="table table-bordered" id="table-list-data" data-table="select_condition" style="margin-top:5px">
            <tr>
              <th style="width: 1%">#</th>
              <th style="width: 1%;white-space:nowrap">Thứ tự</th>               
              <th style="white-space:nowrap">Tên hiển thị</th>
              <th>Table</th>
              <th class="text-center">HIỆN</th>
              <th width="1%" style="white-space:nowrap">Thao tác</th>
            </tr>
            <tbody>
            @if( $items->count() > 0 )
              <?php $i = 0; ?>
              @foreach( $items as $item )
                <?php $i ++; ?>
              <tr id="row-{{ $item->id }}">
                <td><span class="order">{{ $i }}</span></td>
                <td style="vertical-align:middle;text-align:center">
                  <input type="text" value="{{ $item->col_order }}" name="col_order[{{$item->id}}]" style="width:50px" class="form-control" />
                </td>
                <td>
                  {{ $item->display_name }}
                </td>
                <td>                  
                  <a href="{{ route( 'dieu-kien.edit', [ 'id' => $item->id ]) }}">{{ $item->name }}</a>
                </td>      
                
                <td style="text-align:center">
                  <input type="checkbox" data-id="{{ $item->id }}" data-col="status" data-table="select_condition" class="change-value" value="1" {{ $item->status == 1  ? "checked" : "" }}>
                </td>
                                          
                <td style="white-space:nowrap">
                  <a href="{{ route( 'dieu-kien.edit', [ 'id' => $item->id ]) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></a>                                  
                  
                  <a onclick="return callDelete('{{ $item->name }}','{{ route( 'dieu-kien.destroy', [ 'id' => $item->id ]) }}');" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></a>                                   
                </td>
              </tr> 
              @endforeach
            @else
            <tr>
              <td colspan="9">Không có dữ liệu.</td>
            </tr>
            @endif

          </tbody>
          </table>
          </form>
        </div>        
      </div>
      <!-- /.box -->     
    </div>
    <!-- /.col -->  
  </div> 
</section>
<!-- /.content -->
</div>
@stop
@section('javascript_page')
<script type="text/javascript">
function callDelete(name, url){  
  swal({
    title: 'Bạn muốn xóa "' + name +'"?',
    text: "Dữ liệu sẽ không thể phục hồi.",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then(function() {
    location.href= url;
  })
  return flag;
}
$(document).ready(function(){
  
});

</script>
@stop