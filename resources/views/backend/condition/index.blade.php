@extends('backend.layout')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    {{ $detailCond->display_name }}
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route( 'condition.index' ) }}">{{ $detailCond->display_name }}</a></li>
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
      <a href="{{ route('condition.create', ['table' => $detailCond->name ]) }}" class="btn btn-info btn-sm" style="margin-bottom:5px">Tạo mới</a>
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Danh sách</h3>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">
        <form method="post" action={{ route('save-col-order')}} >
            {{ csrf_field() }}
            <input type="hidden" name="table" value="shop_cap_do_1480213548">
            <input type="hidden" name="return_url" value="{{ url()->current() }}">
            @if($items->count() > 0)
            <button type="submit" class="btn btn-warning btn-sm">Save thứ tự</button>
            @endif
          <table class="table table-bordered" id="table-list-data" data-table="shop_cap_do_1480213548" style="margin-top:5px">
            <tr>
              <th style="width: 1%">#</th>
              <th style="width: 1%;white-space:nowrap">Thứ tự</th>
              <th>Tên</th> 
              <th width="1%" style="white-space:nowrap">Màu</th>                       
              <th width="1%" style="white-space:nowrap">Trạng thái</th>
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
                </form>
                <td>                  
                  <a href="{{ route( 'condition.edit', [ 'id' => $item->id ]) }}?table={{ $detailCond->name }}">{{ $item->type }}</a>
                </td>
                <td>
                  <div style="width:60px; height:30px; background-color:{{ $item->color }};padding:5px;color:#FFF">{{ $item->color }}</div>
                </td>  
                <td>
                  @if($item->status == 0)
                  <span class="label label-danger">Ẩn</span>
                  @else
                  <span class="label label-success">Hiện</span>
                  @endif
                </td>              
                <td style="white-space:nowrap">
                  <a href="{{ route( 'condition.edit', [ 'id' => $item->id ]) }}?table={{ $detailCond->name }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></a>
                  @if(DB::table('shop_select_condition')->where($detailCond->name."_id", $item->id)->count() == 0)
                  <a onclick="return callDelete('{{ $item->type }}','shop_{{ $detailCond->name }}', '{{ $item->id }}');" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></a>                 
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
function callDelete(name, table, id){  
  swal({
    title: 'Bạn muốn xóa "' + name +'"?',
    text: "Dữ liệu sẽ không thể phục hồi.",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then(function() {
    $.ajax({
      url : "{{ route('delete') }}",
      type : 'POST',
      data : {
        table : table,
        id : id
      },
      success : function(){
        $('#row-' + id).remove();
      }
    })
  })
  return flag;
}
$(document).ready(function(){
  
});

</script>
@stop