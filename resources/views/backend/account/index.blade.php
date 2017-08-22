@extends('backend.layout')
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
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      @if(Session::has('message'))
      <p class="alert alert-info" >{{ Session::get('message') }}</p>
      @endif
      @if($loginType <= 2)
      <a href="{{ route('account.create') }}?url_return=<?php echo urlencode(url()->full()); ?>" class="btn btn-info btn-sm" style="margin-bottom:5px">Tạo mới</a>
      @endif

      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Bộ lọc</h3>
        </div>            
      <div class="panel-body">
        <form class="form-inline" role="form" method="GET" action="{{ route('account.index') }}">
        <div class="form-group">                                          
          @if($loginType < 2)  
          <div class="checkbox">
            <label>
              <input type="checkbox" name="type[]" class="type" value="2" {{ in_array(2, $searchArr['type']) ? "checked" : "" }}>
              Company
            </label>
          </div>
          @endif
          @if($loginType < 3)
          <div class="checkbox">
            <label>
              <input type="checkbox" name="type[]" class="type" value="3" {{ in_array(3, $searchArr['type']) ? "checked" : "" }}>
              Operator
            </label>
          </div>
          @endif
          @if($loginType < 4)
          <div class="checkbox">
            <label>
              <input type="checkbox" name="type[]" class="type" value="4" {{ in_array(4, $searchArr['type']) ? "checked" : "" }}>
              Executive
            </label>
          </div>
          @endif
          @if($loginType < 5)
          <div class="checkbox">
            <label>
              <input type="checkbox" name="type[]" class="type" value="5" {{ in_array(5, $searchArr['type']) ? "checked" : "" }}>
              Supervisor
            </label>
          </div>
          @endif
          @if($loginType < 6)
          <div class="checkbox">
            <label>
              <input type="checkbox" name="type[]" class="type" value="6" {{ in_array(6, $searchArr['type']) ? "checked" : "" }}>
              Sale
            </label>
          </div>          
          @endif
        </div>     
        <br> <br>
        @if($loginType == 1)
        <div class="form-group">           
        
            <select class="form-control" name="company_id" id="company_id">      
              <option value="" >--Company--</option>              
               @foreach($companyList as $com)
                <option value="{{ $com->id }}" {{ ($searchArr['company_id'] == $com->id && $searchArr['company_id'] > -1) ? "selected" : "" }}>{{ $com->company_name }}</option> 
                @endforeach
            </select>
          </div>

        <div class="form-group role" id="div_company">            
            <select class="form-control role no-check-province" name="company_user_id" id="company_user_id">      
              <option value="" >--All User Company--</option>
              @foreach($userList['company'] as $value)
              <option value="{{ $value->id }}" {{ $value->id == $searchArr['company_user_id'] ? "selected" : "" }} >{{ $value->fullname }}</option>
              @endforeach                   
            </select>
          </div>
        @endif
        @if($loginType < 3)
          <div class="form-group role" id="div_operator"  >            
            <select class="form-control role" name="operator_user_id" id="operator_user_id">      
              <option value="" >--All User Operator--</option>
              @foreach($userList['operator'] as $value)
                      <option value="{{ $value->id }}" {{ $value->id == $searchArr['operator_user_id'] ? "selected" : "" }} >{{ $value->fullname }}</option>
                      @endforeach              
            </select>
          </div>
          @endif
          @if($loginType < 4)
          <div class="form-group role" id="div_executive"  >            
            <select class="form-control role" name="executive_user_id" id="executive_user_id">      
              <option value="" >--All User Executive--</option>
              @foreach($userList['executive'] as $value)
                      <option value="{{ $value->id }}" {{ $value->id == $searchArr['executive_user_id'] ? "selected" : "" }} >{{ $value->fullname }}</option>
                      @endforeach                       
            </select>
          </div>
          @endif
          @if($loginType < 5)
          <div class="form-group role" id="div_supervisor"  >            
            <select class="form-control role" name="supervisor_user_id" id="supervisor_user_id">      
              <option value="" >--All User Supervisor--</option>
              @foreach($userList['supervisor'] as $value)
                      <option value="{{ $value->id }}" {{ $value->id == $searchArr['supervisor_user_id'] ? "selected" : "" }} >{{ $value->fullname }}</option>
                      @endforeach                           
            </select>
          </div>    
          @endif
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
              <th>Username</th>            
              <th style="text-align:center">Role</th>
              <th style="text-align:center">Trạng thái</th>
              <th style="text-align:center">Shop</th> 
              @if($loginType < 2)
              <th style="text-align:center">User Operator</th>
              @endif
              @if($loginType < 3)
              <th style="text-align:center">User Executive</th>
              @endif
              @if($loginType < 4)
              <th style="text-align:center">User Supervisor</th>
              @endif
              @if($loginType < 5)
              <th style="text-align:center">User Sale</th>
              @endif
              @if($loginType <= 2)
              <th width="1%" style="white-space:nowrap">Thao tác</th>
              @endif
            </tr>
            <tbody>
            @if( $items->count() > 0 )
              <?php $i = 0; ?>
              @foreach( $items as $item )
                <?php 
                switch ($item->type) {
                  case 2:
                    $column = 'company_user_id';
                    break;
                  case 3:
                    $column = 'operator_user_id';
                    break;
                  case 4:
                    $column = 'executive_user_id';
                    break;
                  case 5:
                    $column = 'supervisor_user_id';
                    break;
                  
                  default:
                    # code...
                    break;
                }
                if($item->type < 6){
                  $userList = Helper::getListUserOwnerByType($item->id, $item->company_id, $column);
                }
                
                ?>
                <?php $i ++; ?>
                <tr id="row-{{ $item->id }}">
                  <td><span class="order">{{ $i }}</span></td>
                 
                  <td>                  
                    <a href="{{ route( 'account.edit', [ 'id' => $item->id ]) }}">{{ $item->fullname }}</a>
                    <br>    {{ $item->email }}                            
                  </td>
                  <td>{{ $item->username }}</td>                  
                  <td style="text-align:center">
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
                  <td style="text-align:center">{{ $item->status == 1 ? "Mở"  : "Khóa" }}</td>
                  <td style="text-align:center">{{ $item->shops()->count()}}</td>                  
                  @if($loginType < 2)
                  <td style="text-align:center">
                  
                    @if($item->type <= 2 )
                    <a href="{{ route('account.index', ['type[]' => 3, $column => $item->id])}}" class="badge">
                      {{ count($userList['operator']) }}
                    </a>
                    @else
                    -
                    @endif
                  </td>
                  @endif
                  @if($loginType < 3)
                  <td style="text-align:center">
                    @if($item->type <= 3 )
                    <a href="{{ route('account.index', ['type[]' => 4, $column => $item->id])}}" class="badge">
                      {{ count($userList['executive']) }}
                    </a>
                    @else
                    -
                    @endif
                  </td>
                  @endif
                  @if($loginType < 4)
                  <td style="text-align:center">
                    @if($item->type <=4 )
                    <a href="{{ route('account.index', ['type[]' => 5, $column => $item->id])}}" class="badge">
                      {{ count($userList['supervisor']) }}
                    </a>
                    @else
                    -
                    @endif

                  </td>
                  @endif
                  @if($loginType < 5)
                  <td style="text-align:center">
                    @if($item->type <= 5 )
                    <a href="{{ route('account.index', ['type[]' => 6, $column => $item->id])}}" class="badge">
                      {{ count($userList['sale']) }}
                    </a>
                    @else
                    -
                    @endif

                  </td>
                  @endif
                  @if($loginType <= 2)
                  <td style="white-space:nowrap">  
                   
                    @if($item->type != 1)
                    <a href="{{ route( 'account.update-status', ['status' => $item->status == 1 ? 2 : 1 , 'id' => $item->id ])}}" class="btn-sm btn  {{ $item->status == 1 ? "btn-warning" : "btn-info" }}" 
                    @if( $item->status == 2)
                    onclick="return confirm('Bạn chắc chắn muốn MỞ khóa tài khoản này? '); "
                    @else
                    onclick="return confirm('Bạn chắc chắn muốn KHÓA tài khoản này? '); "
                    @endif
                    >{{ $item->status == 1 ? "Khóa TK" : "Mở khóa TK" }}</a>                
                    <a href="{{ route( 'account.edit', [ 'id' => $item->id ]) }}?url_return=<?php echo urlencode(url()->full()); ?>" class=" btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>                 
                    
                    <a onclick="return callDelete('{{ $item->name }}','{{ route( 'account.destroy', [ 'id' => $item->id ]) }}');" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                    @endif
                  </td>
                  @endif
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
<style type="text/css">
  .badge{
    font-size: 23px;
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
  $('form select, form .type').change(function(){
    $(this).parents('form').submit();
  });
});
</script>
@stop