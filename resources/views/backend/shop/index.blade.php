@extends('backend.layout')
@section('content')
<style type="text/css">
  fieldset {
    border: 1px groove #fff !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #fff;
    box-shadow:  0px 0px 0px 0px #fff;
    padding-bottom: 5px !important;
    margin-bottom: 5px !important;
}

legend {
    font-size: 14px !important;    
    text-align: left !important;
    font-weight: bold;
    border-bottom: none;
    width:100px;
    margin-bottom: 0px;    
}
fieldset label{
  font-size: 14px !important;
}
</style>
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
        <div class="panel-body" style="padding-top:0px">
          <form class="form-inline" id="searchForm" role="form" method="GET" action="{{ route('shop.index') }}"> 
            <fieldset>
              <legend>Điều kiện</legend>
                @if($loginType == 1)
                <div class="form-group">     
                  <select class="form-control select2" name="company_id" id="company_id">                          
                    @foreach($companyList as $com)
                    <option value="{{ $com->id }}" {{ $arrSearch['company_id'] == $com->id ? "selected" : "" }}>{{ $com->company_name }}</option> 
                    @endforeach
                  </select>
                </div>  <!-- text input -->           
                @endif
              <div class="form-group">
                <select class="form-control select2" name="province_id" id="province_id" style="width:150px">
                  <option value="">--Tỉnh/Thành  --</option>
                  @foreach( $provinceList as $value )
                    <option value="{{ $value->id }}"
                    {{ $arrSearch['province_id'] == $value->id ? "selected" : "" }}                          

                    >{{ $value->name }}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">              
                <select class="form-control select2" name="district_id" id="district_id" style="width:150px">
                  <option value="">--Quận/Huyện--</option>
                    @foreach( $districtList as $value )
                      <option value="{{ $value->id }}"
                      {{ $arrSearch['district_id'] == $value->id ? "selected" : "" }}                        

                      >{{ $value->name }}</option>
                      @endforeach
                </select>
              </div>
              <div class="form-group">              
                <select class="form-control select2" name="ward_id" id="ward_id" style="width:160px">
                  <option value="">--Phường/Xã--</option>
                  @foreach( $wardList as $value )
                  <option value="{{ $value->id }}"
                  {{ $arrSearch['ward_id'] == $value->id ? "selected" : "" }}                       

                  >{{ $value->name }}</option>
                  @endforeach  
                </select>
              </div>
              <div class="form-group">              
                <input type="text" placeholder="Tên shop" class="form-control" name="shop_name" value="{{ $arrSearch['shop_name'] }}" style="width:140px;height:28px;">
              </div>    
            </fieldset>          
            <fieldset>
              <legend>Danh mục</legend>
               <div class="form-group parent">                                                          
                <div class="checkbox" style="margin-right:30px">
                  <label>
                    <input type="checkbox" class="checkbox_all" id="all_type_id" data-child="type_id">
                    <strong>ALL</strong>
                  </label>
                </div>
                @foreach($shopTypeList as $shopType)
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="type_id[]" class="checkbox_child type_id" value="{{ $shopType->id }}" {{ in_array($shopType->id, $arrSearch['type_id']) ? "checked" : "" }}>
                    {{ $shopType->type}}
                  </label>
                </div>
                @endforeach
              </div>     
            </fieldset>
            @if(!empty($userListLevel))
            @foreach($userListLevel as $level => $userList)
                <fieldset>
                  <legend>{{ ucfirst($level) }}</legend>
                   <div class="form-group parent" id="div_{{ ucfirst($level) }}">                                          
                   <div class="checkbox" style="margin-right:30px">
                      <label>
                        <input type="checkbox" class="checkbox_all" id="all_{{ ($level) }}" data-child="{{ ($level) }}">
                        <strong>ALL</strong>
                      </label>
                    </div>

                    @foreach($userList as $user)
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="user_id[]" class="checkbox_child {{ ($level) }}" data-parent='{{ ($level) }}' value="{{ $user->id }}" {{ in_array($user->id, $userIdSelected) ? "checked" : "" }}>
                        {{ $user->fullname}}
                      </label>
                    </div>
                    @endforeach
                  </div>     
                </fieldset>
            @endforeach
            @endif           
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
                <th style="text-align:center">Người tạo</th>
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
                  <td>{{ ($item->user_id) ? $userListId[$item->user_id]->fullname : "" }}</td>
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
.select2-container--default .select2-selection--single .select2-selection__rendered{
  line-height: 24px;  
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

  $('.checkbox_all').click(function(){
    var child = $(this).data('child');
    $('.' + child).prop('checked', $(this).prop('checked'));
  });
  $('.checkbox_child').change(function(){
    var parent = $(this).parents('div.parent');
    if(parent.find(".checkbox_child:not(':checked')").length == 0){
      parent.find('.checkbox_all').prop('checked', true);
    }else{
      parent.find('.checkbox_all').prop('checked', false);
    }
  });
  $('div.parent').each(function(){
    var parent = $(this);
    if(parent.find(".checkbox_child:not(':checked')").length == 0){
      parent.find('.checkbox_all').prop('checked', true);
    }else{
      parent.find('.checkbox_all').prop('checked', false);
    }
  })
  $('input.submitForm').click(function(){
    var obj = $(this);
    if(obj.prop('checked') == true){
      obj.val(1);      
    }else{
      obj.val(0);
    } 
    obj.parent().parent().parent().submit(); 
  });
  
  $('#user_type, #user_id, #province_id, #type, #district_id, #ward_id').change(function(){    
    $('#searchForm').submit();
  });
  $('#company_id').change(function(){
    $('#searchForm').find('.checkbox_child').prop('checked', false);
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