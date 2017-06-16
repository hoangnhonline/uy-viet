@extends('layouts.master')
<body>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<nav class="navbar navbar-default" >
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Uy Việt</a>
        </div>
        @if(session()->has('userId'))
        <ul class="nav navbar-nav" style="margin-left: 12%">
            <li class="selectnav">
                <div>
                    <input type="text" class="form-control input-lg search-input" placeholder="Nhập nội dung tìm kiếm" />
                </div>
            </li>
            <li class="selectnav">
                <select id="province" class="selectpicker" data-live-search="true" data-live-search-style="begins" title="Chọn tỉnh/thành phố" onchange="getListDistrict()">
                    @foreach($listProvince as $province)
                    <option value="{{$province->id}}">{{$province->name}}</option>
                    @endforeach
                </select>
            </li>
            <li class="selectnav">
                <select id='district' name='district' class='selectpicker' data-live-search="true" data-live-search-style="begins" title="Chọn quận/huyện" onchange="getListWard()">
                    <option value='0'>Tất cả</option>
                </select>
            </li>
            <li class="selectnav">
                <select id='ward' name='standard' class='selectpicker' title="Chọn phường/xã" >
                    <option value='0'>Tất cả</option>
                </select>
            </li>
            <li class="selectnav">
                <button class="btn btn-info btn-lg" type="button" style="padding: 4px 12px;" id="search">
                    <i class="glyphicon glyphicon-search"></i>
                </button>
            </li>
        </ul>
        <div class="pull-right">
            <label style="font-weight: bold; margin-top: 12px">Xin chào , {{session('fullname')}}</label>
            <button class="btn btn-info btn-md" onclick="window.location.href='/logout'">Logout</button>
        </div>
        @else
        <a class="pull-right btn btn-info btn-md selectnav " href="#" data-toggle="modal" data-target="#login-modal">Login</a>
        @endif

    </div>
</nav>
<div class="col-md-2 nav-side-menu" style="position: relative;">
    <div class="brand">Tìm kiếm</div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
    <div class="menu-list">
        <ul id="menu-content" class="menu-content collapse out">
            <li  data-toggle="collapse" data-target="#check-list-box" class="collapsed active">
                <a href="#"><i class="fa fa-gift fa-lg"></i> Danh mục cửa hàng <span class="arrow"></span></a>
            </li>
                <ul id="check-list-box" class="list-group checked-list-box sub-menu collapse">
                    @foreach($shopType as $type)
                        <li class="list-group-item" value="{{$type->id}}">{{$type->type}}</li>
                    @endforeach
                </ul>
            <li data-toggle="collapse" data-target="#check-list-box-level" class="collapsed">
                <a href="#"><i class="fa fa-industry fa-lg"></i> Cấp độ <span class="arrow"></span></a>
            </li>
            <ul id="check-list-box-level" class="list-group checked-list-box sub-menu collapse">
                @foreach($levels as $level)
                    <li class="list-group-item" value="{{$level->id}}">{{$level->type}}</li>
                @endforeach
            </ul>
            <ul class="sub-menu collapse" id="service">

            </ul>


            <li data-toggle="collapse" data-target="#check-list-box-tiemnang" class="collapsed">
                <a href="#"><i class="fa fa-industry fa-lg"></i> Tiềm năng <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse list-group checked-list-box" id="check-list-box-tiemnang">
                @foreach($tiemnang as $tiemnang_item)
                    <li class="list-group-item" value="{{$tiemnang_item->id}}">{{$tiemnang_item->type}}</li>
                @endforeach
            </ul>
            <li data-toggle="collapse" data-target="#check-list-box-quymo" class="collapsed">
                <a href="#"><i class="fa fa-industry fa-lg"></i> Quy Mô <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse list-group checked-list-box" id="check-list-box-quymo">
                @foreach($quymo as $quymo_item)
                    <li class="list-group-item" value="{{$quymo_item->id}}">{{$quymo_item->type}}</li>
                @endforeach
            </ul>
        </ul>
    </div>
</div>
<div id="map" class="col-md-10"></div>
@if(session()->has('userId'))
<script>
var userId = {{session('userId')}};
</script>
@endif
@if (!empty($init_location))
    <script>
        var updatePosition = '{{$init_location->location}}';
        var updateShopId = {{$init_location->id}};
    </script>
@else
    <script>
        var updatePosition = '15.961533, 107.856976';
    </script>
@endif
<script src="/js/home.js"></script>
<!-- EDIT INFO MODAL -->
<div class="modal fade" id="modal-edit" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Shop</h4>
            </div>
            <div class="modal-body">
                <form action="" class="form-horizontal" method="post">
                    <div class="box-body ">
                        <input type="hidden" name="id">
                        <input type="hidden" name="condition_id">
                        <div class="form-group">
                            <label class="controller-label col-sm-2 text-right">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="shop_name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="controller-label col-sm-2 text-right">Namer</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="namer" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="controller-label col-sm-2 text-right">Status</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="status">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="controller-label col-sm-2 text-right">Full Address</label>
                            <div class="col-sm-9">
                                <input type="tel" class="form-control" name="full_address" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="controller-label col-sm-2 text-right">Phone</label>
                            <div class="col-sm-9">
                                <input type="tel" class="form-control" name="phone" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="controller-label col-sm-2 text-right">Company</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="company_name" value="" readonly required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="controller-label col-sm-2 text-right">Cấp độ</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="level">
                                    @foreach($levels as $level)
                                        <option value="{{$level->id}}">{{$level->type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="controller-label col-sm-2 text-right">Quy Mô</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="quymo">
                                    @foreach($quymo as $quymo_item)
                                        <option value="{{$quymo_item->id}}">{{$quymo_item->type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="controller-label col-sm-2 text-right">Tiềm năng</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="tiemnang">
                                    @foreach($tiemnang as $tiemnang_item)
                                        <option value="{{$tiemnang_item->id}}">{{$tiemnang_item->type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info" onclick="editMarkerPosition()">Chỉnh marker</button>
                <button type="button" class="btn btn-primary" onclick="editMarker()">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- END EDIT INFO MODAL -->

<!-- SIGNIN MODAL -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="loginmodal-container">
        <h1>Đăng nhập</h1><br>
            <form >
            <input type="text" name="userLog" placeholder="Username" required>
            <input type="password" name="passLog" placeholder="Password" required>
            <input type="button" name="login" class="login loginmodal-submit" value="Login" onclick="doLogin()">
                <p name="loginFail" style="color:red" class="alert-warning" hidden>Tên đăng nhập hoặc mật khẩu không đúng !</p>
            </form>
        </div>
    </div>
</div>
</body>
</html>