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
    <li><a href="{{ route( 'shop-type.index' ) }}">Danh mục</a></li>
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
      <a href="{{ route('shop-type.create') }}" class="btn btn-info btn-sm" style="margin-bottom:5px">Tạo mới</a>
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Danh sách</h3>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">
          <form method="post" action={{ route('save-col-order')}} >
            {{ csrf_field() }}
            <input type="hidden" name="table" value="shop_type">
            <input type="hidden" name="return_url" value="{{ url()->current() }}">
            @if($items->count() > 0)
            <button type="submit" class="btn btn-warning btn-sm">Save thứ tự</button>
            @endif
          <table class="table table-bordered" id="table-list-data" data-table="shop_type" style="margin-top:5px">
            <tr>
              <th style="width: 1%">#</th>
              <th style="width: 1%;white-space:nowrap">Thứ tự</th>
              <th>Tên</th> 
              <th width="10%" style="white-space:nowrap;text-align:center">Icon</th>                       
              <th width="1%" style="white-space:nowrap" style="text-align:center">Trạng thái</th>
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
                  <a href="{{ route( 'shop-type.edit', [ 'id' => $item->id ]) }}">{{ $item->type }}</a>
                </td>
                <td style="text-align:center">
                  <img src="{{ Helper::showImage($item->icon_url) }}" />
                </td>  
                <td style="text-align:center">
                  @if($item->status == 0)
                  <span class="label label-danger">Ẩn</span>
                  @else
                  <span class="label label-success">Hiện</span>
                  @endif
                </td>              
                <td style="white-space:nowrap">
                  <a href="{{ route( 'shop-type.edit', [ 'id' => $item->id ]) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></a>                                  
                  @if($item->shops()->count() == 0)
                  <a onclick="return callDelete('{{ $item->type }}','{{ route( 'shop-type.destroy', [ 'id' => $item->id ]) }}');" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></a>                 
                  @endif
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