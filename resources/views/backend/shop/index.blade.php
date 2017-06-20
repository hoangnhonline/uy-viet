@extends('layout.backend')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Shop
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route( 'shop.index' ) }}">Shop</a></li>
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
      <a href="{{ route('shop.create') }}" class="btn btn-info btn-sm" style="margin-bottom:5px">Tạo mới</a>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Bộ lọc</h3>
        </div>
        <div class="panel-body">
          <form class="form-inline" id="searchForm" role="form" method="GET" action="{{ route('shop.index') }}">           
            
            <div class="form-group">                                          
              @foreach($shopTypeList as $shopType)
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="type_id[]" class="type_id" value="{{ $shopType->id }}" {{ in_array($shopType->id, $arrSearch['type_id']) ? "checked" : "" }}>
                  {{ $shopType->type}}
                </label>
              </div>
              @endforeach
            </div>     
            <br> <br> 
            <div class="form-group">
              <select class="form-control" name="user_id" id="user_id" style="width:150px;">
                <option value="">--User  --</option>
                @foreach( $userList as $value )
                  <option value="{{ $value->id }}"
                  {{ $arrSearch['user_id'] == $value->id ? "selected" : "" }}                          

                  >{{ $value->fullname }}</option>
                  @endforeach
              </select>
            </div>       
            <div class="form-group">
              <select class="form-control" name="province_id" id="province_id" style="width:150px;">
                <option value="">--Tỉnh/Thành  --</option>
                @foreach( $provinceList as $value )
                  <option value="{{ $value->id }}"
                  {{ $arrSearch['province_id'] == $value->id ? "selected" : "" }}                          

                  >{{ $value->name }}</option>
                  @endforeach
              </select>
            </div>
            <div class="form-group">              
              <select class="form-control" name="district_id" id="district_id">
                <option value="">--Quận/Huyện--</option>
                  @foreach( $districtList as $value )
                    <option value="{{ $value->id }}"
                    {{ $arrSearch['district_id'] == $value->id ? "selected" : "" }}                        

                    >{{ $value->name }}</option>
                    @endforeach
              </select>
            </div>
            <div class="form-group">              
              <select class="form-control" name="ward_id" id="ward_id" style="width:100px">
                <option value="">--Phường/Xã--</option>
                @foreach( $wardList as $value )
                <option value="{{ $value->id }}"
                {{ $arrSearch['ward_id'] == $value->id ? "selected" : "" }}                       

                >{{ $value->name }}</option>
                @endforeach  
              </select>
            </div>
            <div class="form-group">              
              <input type="text" placeholder="Tên shop" class="form-control" name="shop_name" value="{{ $arrSearch['shop_name'] }}" style="width:140px">
            </div>                    
            
            <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
          </form>         
        </div>
      </div>
      
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Danh sách ( {{ $items->total() }} shop )</h3>
        </div>
        <?php 
        $page = \Request::get('page') ? \Request::get('page') : 1;
        ?>
        
        <!-- /.box-header -->
        <div class="box-body">
          <div style="text-align:center">
           {{ $items->appends( $arrSearch )->links() }}          
          </div>

            <table class="table table-bordered" id="table-list-data">
              <tr>
                <th style="width: 1%">#</th>                
                <th width="120px">Danh mục</th>                                           
                <th style="text-align:left">Thông tin shop</th>
                <th style="text-align:left">Địa chỉ</th>
                
                <th width="1%;white-space:nowrap">Thao tác</th>
              </tr>
              <tbody>
              @if( $items->count() > 0 )
                <?php $i = ($page  - 1 ) * 100 + 1; ?>
                @foreach( $items as $item )
                  
                <tr id="row-{{ $item->id }}">
                  <td><span class="order">{{ $i }}</span></td>                  
                  <td>                
                    <strong style="color:#337ab7"> {{ $item->type->type }}</strong>
                  </td>
                  <td>                  
                     <a style="color:#F9423A;font-weight:bold" href="{{ route( 'shop.edit', [ 'id' => $item->id ]) }}">{{ $item->shop_name }}</a>

                    @if($item->namer)
                  <br>
                    <i class="fa fa-user"></i><strong>
                      {{ $item->namer }} 
                    </strong>
                   <br><i class="fa fa-phone"></i> {{ $item->phone }}
                    @endif
                    <br>     <br>               
                    
                  </td>
                  <td>
                    <p>
                    <i class="fa fa-map-marker"></i>
                      @if($item->full_address)
                        {{ $item->full_address }}, &nbsp;
                      @else
                        {{ $item->address }} {{ $item->street }}, &nbsp;
                      @endif                      
                      @if($item->ward_id > 0)
                      {{ $item->ward->name }},&nbsp;
                      @endif
                      @if($item->district_id > 0)
                      {{ $item->district->name }},&nbsp;
                      @endif
                      @if($item->province_id > 0)
                      {{ $item->province->name }}
                      @endif

                    </p>
                  </td>
                  
                  <td style="white-space:nowrap; text-align:right">
             
                    <a href="{{ route( 'shop.edit', [ 'id' => $item->id ]) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></a>                 

                    <a onclick="return callDelete('{{ $item->name }}','{{ route( 'shop.destroy', [ 'id' => $item->id ]) }}');" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></a>

                  </td>
                </tr> 
                <?php $i ++; 

                  ?>
                @endforeach
              @else
              <tr>
                <td colspan="9">Không có dữ liệu.</td>
              </tr>
              @endif

            </tbody>
            </table>          
          <div style="text-align:center">
           {{ $items->appends( $arrSearch )->links() }}
          </div>  
        </div>        
      </div>
      <!-- /.box -->     
    </div>
    <!-- /.col -->  
  </div> 
</section>
<!-- /.content -->
</div>
<style type="text/css">
#searchForm div{
  margin-right: 7px;
}
</style>
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
  $('input.submitForm').click(function(){
    var obj = $(this);
    if(obj.prop('checked') == true){
      obj.val(1);      
    }else{
      obj.val(0);
    } 
    obj.parent().parent().parent().submit(); 
  });
  
  $('#province_id, #type, #district_id, #ward_id').change(function(){    
    $('#searchForm').submit();
  });  
  $('#is_hot').change(function(){
    $('#searchForm').submit();
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
            updateOrder("san_pham", strOrder);
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