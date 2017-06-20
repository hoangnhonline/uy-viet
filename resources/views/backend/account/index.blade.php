@extends('layout.backend')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Tài khoản
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route( 'account.index' ) }}">Tài khoản</a></li>
    <li class="active">Danh sách</li>
  </ol>
</section>
<?php 
$loginType = Auth::user()->type;
$loginId = Auth::user()->id;
?>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      @if(Session::has('message'))
      <p class="alert alert-info" >{{ Session::get('message') }}</p>
      @endif
      <a href="{{ route('account.create') }}" class="btn btn-info btn-sm" style="margin-bottom:5px">Tạo mới</a>
      @if($loginType < 3)
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Bộ lọc</h3>
        </div>            
      <div class="panel-body">
        <form class="form-inline" role="form" method="GET" action="{{ route('account.index') }}">
        @if($loginType == 1)
        <div class="form-group">           
        
            <select class="form-control" name="company_id" id="company_id">      
              <option value="" >--Company--</option>              
               @foreach($companyList as $com)
                <option value="{{ $com->id }}" {{ ($searchArr['company_id'] == $com->id && $searchArr['company_id'] > -1) ? "selected" : "" }}>{{ $com->company_name }}</option> 
                @endforeach
            </select>
          </div>
        @endif
        <div class="form-group">            
            <select class="form-control" name="type" id="type">      
              <option value="" >--Type--</option>              
              @if(Auth::user()->type == 1)
              <option value="2" {{ $searchArr['type'] == 2 ? "selected" : "" }}>Company</option>                  
              @endif                    
              <option value="3" {{ $searchArr['type'] == 3 ? "selected" : "" }}>Operator</option> 
              <option value="4" {{ $searchArr['type'] == 4 ? "selected" : "" }}>Executive</option>
              <option value="5" {{ $searchArr['type'] == 5 ? "selected" : "" }}>Supervisor</option>
              <option value="6" {{ $searchArr['type'] == 6 ? "selected" : "" }}>Sale</option>
            </select>
        </div>
        <div class="form-group">            
            <input type="text" name="username" value="{{ $searchArr['username'] }}" class="form-control" placeholder="Username">
        </div>
        <div class="form-group">            
            <input type="text" name="email" value="{{ $searchArr['email'] }}" class="form-control" placeholder="Email">
        </div>
        <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
          </form>
      </div>
      </div>
      @endif

      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Danh sách ( {{ $items->count() }} user)</h3>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered" id="table-list-data">
            <tr>
              <th style="width: 1%">#</th>              
              <th>Họ Tên</th>
              <th>Email</th>
              <th>Role</th>
              <th>Trạng thái</th>
              <th>Shop</th>
              <th width="1%" style="white-space:nowrap">Thao tác</th>
            </tr>
            <tbody>
            @if( $items->count() > 0 )
              <?php $i = 0; ?>
              @foreach( $items as $item )
                <?php $i ++; ?>
                <tr id="row-{{ $item->id }}">
                  <td><span class="order">{{ $i }}</span></td>
                 
                  <td>                  
                    <a href="{{ route( 'account.edit', [ 'id' => $item->id ]) }}">{{ $item->fullname }}</a>                                
                  </td>
                  <td>{{ $item->email }}</td>
                  <td>
                  <?php                  
                  switch ($item->type) {
                    case 1:
                      echo "Admin";
                      break;
                    case 2:
                      echo "Company";
                      break;
                    case 3:
                      echo "Operator";
                      break;
                    case 4:
                      echo "Executive";
                      break;
                    case 5:
                      echo "Supervisor";
                      break;
                    case 6:
                      echo "Sale";
                      break;                      
                    
                    default:
                      # code...
                      break;
                  }
                  ?>
                  </td>
                  <td>{{ $item->status == 1 ? "Mở"  : "Khóa" }}</td>
                  <td>{{ $item->shops()->count()}}</td>
                  <td style="white-space:nowrap">  
                    @if($item->type != 1)
                    <a href="{{ route( 'account.update-status', ['status' => $item->status == 1 ? 2 : 1 , 'id' => $item->id ])}}" class="btn btn-sm {{ $item->status == 1 ? "btn-warning" : "btn-info" }}" 
                    @if( $item->status == 2)
                    onclick="return confirm('Bạn chắc chắn muốn MỞ khóa tài khoản này? '); "
                    @else
                    onclick="return confirm('Bạn chắc chắn muốn KHÓA tài khoản này? '); "
                    @endif
                    >{{ $item->status == 1 ? "Khóa TK" : "Mở khóa TK" }}</a>                
                    <a href="{{ route( 'account.edit', [ 'id' => $item->id ]) }}" class="btn-sm btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>                 
                    
                    <a onclick="return callDelete('{{ $item->name }}','{{ route( 'account.destroy', [ 'id' => $item->id ]) }}');" class="btn-sm btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
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
  $('#company_id, #type').change(function(){
    $(this).parents('form').submit();
  });
  $('#table-list-data tbody').sortable({
        placeholder: 'placeholder',
        handle: ".move",
        start: function (event, ui) {
                ui.item.toggleClass("highlight");
        },
        stop: function (event, ui) {
                ui.item.toggleClass("highlight");
        },          
        axis: "y",
        update: function() {
            var rows = $('#table-list-data tbody tr');
            var strOrder = '';
            var strTemp = '';
            for (var i=0; i<rows.length; i++) {
                strTemp = rows[i].id;
                strOrder += strTemp.replace('row-','') + ";";
            }     
            updateOrder("loai_sp", strOrder);
        }
    });
});
function updateOrder(table, strOrder){
  $.ajax({
      url: $('#route_update_order').val(),
      type: "POST",
      async: false,
      data: {          
          str_order : strOrder,
          table : table
      },
      success: function(data){
          var countRow = $('#table-list-data tbody tr span.order').length;
          for(var i = 0 ; i < countRow ; i ++ ){
              $('span.order').eq(i).html(i+1);
          }                        
      }
  });
}
</script>
@stop