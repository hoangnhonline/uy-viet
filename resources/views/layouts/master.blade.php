<!DOCTYPE html>
<!--[if lt IE 7 ]><html dir="ltr" lang="en-US" class="no-js ie ie6 lte7 lte8 lte9"><![endif]-->
<!--[if IE 7 ]><html dir="ltr" lang="en-US" class="no-js ie ie7 lte7 lte8 lte9"><![endif]-->
<!--[if IE 8 ]><html dir="ltr" lang="en-US" class="no-js ie ie8 lte8 lte9"><![endif]-->
<!--[if IE 9 ]><html dir="ltr" lang="en-US" class="no-js ie ie9 lte9"><![endif]-->
<!--[if IE 10 ]><html dir="ltr" lang="en-US" class="no-js ie ie10 lte10"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en" class="fonts-loaded">
<!--<![endif]-->

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">	
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Uy Việt</title>
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="robots" content="index,follow" />
	<link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}" type="image/x-icon">
	<link rel="icon" href="{{ URL::asset('assets/images/favicon.ico') }}" type="image/x-icon">
	<!-- ===== Style CSS ===== -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/home.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/responsive.css') }}">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn"t work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<link href="{{ URL::asset('assets/css/animations-ie-fix.css') }}" rel="stylesheet">
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond/js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body class="main">
	
	<div class="wrapper">
		
		<header class="main-header">
			<a href="./" class="logo">
                <!-- mini logo -->
                <span class="logo-mini"><b>U</b>V</span>
                <!-- logo -->
                <span class="logo-lg"> <center><img src="{{ URL::asset('assets/images/logo.png') }}" width="100px"></center></span>
            </a><!-- /.logo -->
            <div id="search_icon">
            	<button type="button" class="btn btn-primary"><span class="fa fa-search"></span></button>
            </div><!-- /#search -->
            <nav class="navbar navbar-static-top">
            	<a href="javascript:void(0)" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a><!-- /.sidebar-toggle -->
                <div class="row">
                	<form class="row form-select">
                        <div class="col-sm-12 group-list-drop-down">
                            <div class="form-group col-sm-2 list-drop-down">
                                <label class="col-sm-2 control-label" for="">Công Ty</label>
                                <div class="col-sm-10" id="company">
									<select id="standard" name="standard" class="selectpicker custom-select form-control" data-live-search="true">
										<option value="none">Tất cả</option>
										<option value="5">Hóa Sinh</option>
										<option value="0">Uy Việt</option>
									</select>
								</div>
                            </div>
                            <div class="form-group col-sm-3 list-drop-down">
                                <label class="col-sm-2 control-label" for="">Tỉnh / Thành Phố</label>
                                <div class="col-sm-10" id="province">
								<select id="province" class="selectpicker custom-select form-control"  title="Chọn tỉnh/thành" data-live-search="true" onchange="getListDistrict()">
									 @foreach($listProvince as $province)
				                    <option value="{{$province->id}}">{{$province->name}}</option>
				                    @endforeach
								</select>
							</div>
                            </div>
                            <div class="form-group col-sm-3 list-drop-down">
                                <label class="col-sm-2 control-label" for="">Quận / Huyện</label>
                                <div class="col-sm-10">
                                    <select id='district' name='district' class="selectpicker custom-select form-control" data-live-search="true" title="Chọn quận/huyện" onchange="getListWard()">      
                                    <option value='0'>Tất cả</option>                                 
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-sm-3 list-drop-down">
                                <label class="col-sm-2 control-label" for="">Xã / Phường</label>
                                <div class="col-sm-10">
                                    <select id='ward' name='standard' title="Chọn phường/xã" class="selectpicker custom-select form-control" data-live-search="true">
                                        <option value='0'>Tất cả</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-sm-1 btn-search-max">
                                <button type="button" style="width: 100%;" id="search"><span class="fa fa-search"></span></button>
                            </div>
                        </div>
                    </form>
                </div><!-- /.row -->
            </nav><!-- /nav -->
		</header><!-- /header -->

		<aside class="main-sidebar">
			<section class="sidebar">
				<div class="user-panel">
					<div class="pull-left image">
						<img src="{{ URL::asset('assets/images/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
					</div>
					<div class="pull-left info">
						<p>Hi , {{session('fullname')}}</p>
						<a href="#" title=""><i class="fa fa-circle text-success"></i> Online</a>
					</div>
				</div><!-- /.user-panel -->
				<ul class="sidebar-menu" data-widget="tree">
					<li class="active treeview menu-open">
						<a href="javascript:void(0)" title="">
							<i class="fa fa-dashboard"></i>
							<span>Danh mục cửa hàng</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu list-group checked-list-box" id="check-list-box">
							@foreach($shopType as $type)		                        
		                        <li class="active"><a href="javascript:void(0)" title="" value="{{$type->id}}" >
									<span><img src="{{ Helper::showImage($type->icon_url) }}" alt="{!! $type->type !!}"></span>
									{!! $type->type !!}
								</a></li>
		                    @endforeach							
						</ul>
					</li><!-- /.treeview -->
					<li class="treeview">
						<a href="#" title="">
							<i class="fa fa-th"></i>
							<span>Cấp độ</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="#" title="">
								<span><img src="{{ URL::asset('assets/images/icon-menu/10.jpg') }}" alt=""></span>
								Phòng Nha
							</a></li>
							<li><a href="#" title="">
								<span><img src="{{ URL::asset('assets/images/icon-menu/10.jpg') }}" alt=""></span>
								Phòng Nha
							</a></li>
							<li><a href="#" title="">
								<span><img src="{{ URL::asset('assets/images/icon-menu/10.jpg') }}" alt=""></span>
								Phòng Nha
							</a></li>
							<li><a href="#" title="">
								<span><img src="{{ URL::asset('assets/images/icon-menu/10.jpg') }}" alt=""></span>
								Phòng Nha
							</a></li>
							<li><a href="#" title="">
								<span><img src="{{ URL::asset('assets/images/icon-menu/10.jpg') }}" alt=""></span>
								Phòng Nha
							</a></li>
						</ul>
					</li><!-- /.treeview -->
					<li class="treeview">
						<a href="#" title="">
							<i class="fa fa-edit"></i>
							<span>Tiếm năng</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="#" title="">
								<span><img src="{{ URL::asset('assets/images/icon-menu/10.jpg') }}" alt=""></span>
								Phòng Nha
							</a></li>
							<li><a href="#" title="">
								<span><img src="{{ URL::asset('assets/images/icon-menu/10.jpg') }}" alt=""></span>
								Phòng Nha
							</a></li>
							<li><a href="#" title="">
								<span><img src="{{ URL::asset('assets/images/icon-menu/10.jpg') }}" alt=""></span>
								Phòng Nha
							</a></li>
							<li><a href="#" title="">
								<span><img src="{{ URL::asset('assets/images/icon-menu/10.jpg') }}" alt=""></span>
								Phòng Nha
							</a></li>
							<li><a href="#" title="">
								<span><img src="{{ URL::asset('assets/images/icon-menu/10.jpg') }}" alt=""></span>
								Phòng Nha
							</a></li>
						</ul>
					</li><!-- /.treeview -->
					<li class="treeview">
						<a href="#" title="">
							<i class="fa fa-pie-chart"></i>
							<span>Quy mô</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="#" title="">
								<span><img src="{{ URL::asset('assets/images/icon-menu/10.jpg') }}" alt=""></span>
								Phòng Nha
							</a></li>
							<li><a href="#" title="">
								<span><img src="{{ URL::asset('assets/images/icon-menu/10.jpg') }}" alt=""></span>
								Phòng Nha
							</a></li>
							<li><a href="#" title="">
								<span><img src="{{ URL::asset('assets/images/icon-menu/10.jpg') }}" alt=""></span>
								Phòng Nha
							</a></li>
							<li><a href="#" title="">
								<span><img src="{{ URL::asset('assets/images/icon-menu/10.jpg') }}" alt=""></span>
								Phòng Nha
							</a></li>
							<li><a href="#" title="">
								<span><img src="{{ URL::asset('assets/images/icon-menu/10.jpg') }}" alt=""></span>
								Phòng Nha
							</a></li>
						</ul>
					</li><!-- /.treeview -->
				</ul>
			</section><!-- /.sidebar -->
		</aside><!-- /main-sidebar -->

		<div class="content-wrapper">
			<div id="map">
				
			</div>
		</div><!-- /content-wrapper -->

		<footer class="main-footer">
			<a href="#" title="" class="link"><strong>uv.net.vn</strong></a>
		</footer>

	</div>
	<!-- /.wrapper -->

	<!-- ===== JS ===== -->
	<script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
	<!-- ===== JS Bootstrap ===== -->
	<script src="{{ URL::asset('assets/path/bootstrap/bootstrap.min.js') }}"></script>
	<!-- sticky -->
	<script src="{{ URL::asset('assets/path/sticky/jquery.sticky.js') }}"></script>
	<!-- sticky -->
	<script src="{{ URL::asset('assets/path/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
	<!-- Js Common -->
	<script src="{{ URL::asset('assets/js/aaaa.js') }}"></script>
	<!-- Js Common -->
	<script src="{{ URL::asset('assets/js/common.js') }}"></script>

	<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAo3ykqb8xloOHX36rgPXSd1zBQilLqy98&callback=initMap"></script>
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
	<script src="{{ URL::asset('js/home.js') }}"></script>
	<script src="{{ URL::asset('js/checkbox.js') }}"></script>
</body>
</html>