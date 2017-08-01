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
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
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
	<style type="text/css">
		#map .labels {
		  color: red;
		  padding-top: 10px;
		  background-color: yellow;
		  font-family: "Lucida Grande", "Arial", sans-serif;
		  font-size: 10px;
		  text-align: center;
		  width: 30px;
		  white-space: nowrap;

		}
	</style>
</head>
<body class="main">
	
	<div class="wrapper">
		
		<header class="main-header">
			<a href="{{ route('home') }}" class="logo">
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
                        	@if(Auth::user()->type == 1)
                            <div class="form-group col-sm-2 list-drop-down">
                                <label class="col-sm-2 control-label" for="">Công Ty</label>
                                <div class="col-sm-10">
									<select id="company" name="company" class="selectpicker custom-select form-control" data-live-search="true">										
										@foreach($companyList as $com)
					                    <option value="{{ $com->id }}" {{ $company_id == $com->id ? "selected" : "" }}>{{ $com->company_name }}</option>
					                    @endforeach
									</select>
								</div>
                            </div>
                            @else
                            <input type="hidden" id="company" value="{{ Auth::user()->company_id }}">
                            @endif
                            <div class="form-group col-sm-3 list-drop-down">
                                <label class="col-sm-2 control-label" for="">Tỉnh / Thành Phố</label>
                                <div class="col-sm-10">
								<select id="province" class="selectpicker custom-select form-control"  title="Chọn tỉnh/thành" data-live-search="true" onchange="getListDistrict()">
									 @foreach($listProvince as $province)
				                    <option value="{{$province->id}}" {{ (isset($province_id) && $province_id == $province->id)  ? "selected"  : "" }}>{{$province->name}}</option>
				                    @endforeach
								</select>
							</div>
                            </div>
                            <div class="form-group col-sm-3 list-drop-down">
                                <label class="col-sm-2 control-label" for="">Quận / Huyện</label>
                                <div class="col-sm-10">
                                    <select id='district' name='district' class="selectpicker custom-select form-control" data-live-search="true" title="Chọn quận/huyện" onchange="getListWard()">      
                                    <option value='0'>Tất cả</option>
                                    @foreach($districtList as $district)
				                    <option value="{{$district->id}}" {{ (isset($district_id) && $district_id == $district->id)  ? "selected"  : "" }}>{{$district->name}}</option>
				                    @endforeach                                 
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-sm-3 list-drop-down">
                                <label class="col-sm-2 control-label" for="">Xã / Phường</label>
                                <div class="col-sm-10">
                                    <select id='ward' name='standard' title="Chọn phường/xã" class="selectpicker custom-select form-control" data-live-search="true">
                                        <option value='0'>Tất cả</option>
                                        @foreach($wardList as $ward)
					                    <option value="{{$ward->id}}" {{ (isset($ward_id) && $ward_id == $district->id)  ? "selected"  : "" }}>{{$ward->name}}</option>
					                    @endforeach   
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
						<p>Hi , {{ Auth::user()->fullname }}</p>
						<a href="{{ route('logout') }}" title="Logout" style="color:red"><i class="fa fa-circle text-danger"></i> Logout</a>
					</div>					
				</div><!-- /.user-panel -->
				<ul class="sidebar-menu" data-widget="tree">
					<li class="active treeview menu-open">
						<a href="javascript:void(0)" title="">
							<i class="fa fa-th"></i>
							<span>Danh mục cửa hàng</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu list-group checked-list-box check-list-box filter_type">
							<li class="active filter_all" data-filter="filter_type">
								<a href="javascript:void(0)" title="" value="" data-col="type_id">							
									<span><img src="{{ URL::asset('assets/images/all.png') }}" alt="Tất cả"></span>Tất cả
								</a>
							</li>
							@foreach($shopType as $type)		                        
		                        <li class="active filter_type" data-filter="filter_type"><a href="javascript:void(0)" title="" value="{{ $type->id }}" data-col="type_id">
									<span><img src="{{ Helper::showImage($type->icon_url) }}" alt="{!! $type->type !!}"></span>
									{!! $type->type !!}
								</a></li>
		                    @endforeach							
						</ul>
					</li><!-- /.treeview -->
					@foreach($conditionList as $condition)
					<li class="treeview">
						<a href="#" title="">
							<i class="fa fa-th"></i>
							<span>{!! $condition->display_name !!}</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<?php 
						$dataList = DB::table('shop_'. $condition->name)->where('status', 1)->get();
						?>
						<ul class="list-group checked-list-box treeview-menu treeview-border check-list-box filter_{{ $condition->name }}">
							<li class="active  filter_all" data-filter="filter_{{ $condition->name }}"><a href="#" title="" value="" data-col="{{ $condition->name }}_id" style="border-color: #41ADFF">Tất cả</a></li>
							@foreach($dataList as $data)
								<li class="active filter_{{ $condition->name }}" data-filter="filter_{{ $condition->name }}"><a href="#" title="" value="{{ $data->id }}" data-col="{{ $condition->name }}_id" style="border-color: {{ $data->color }};">{{ $data->type }}</a></li>
			                @endforeach
						</ul>
						
					</li><!-- /.treeview -->
					@endforeach		
					<li style="padding-left:10px;padding-top:20px">
						
						<label style="color:red">
							<input type="checkbox" id="check_show_label" {{ $settingArr['show_label'] == 1 ? "checked" : "" }}> Hiển thị tên shop
						</label>
						
					</li>			
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
	<div class="notFound" id="div_result" style="display:none">
		<p>
			<i class="fa fa-exclamation-circle"></i>
			<span id="txt_result"></span>
		</p>
	</div>

	@foreach($conditionList as $cond)
		<input type="hidden" id="{{ $cond->name }}_id" value="" class="checked_value">
	@endforeach
		<input type="hidden" id="type_id" value="" class="checked_value">	
		<input type="hidden" id="show_label" value="{{ $settingArr['show_label'] }}">
		<input type="hidden" id="is_search" value="0">
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
    @if(Auth::check())
	<script>
	var userId = {{ Auth::user()->id }};
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
	<script type="text/javascript">
	$(document).ready(function(){
		$('#check_show_label').click(function(){
			if($(this).prop('checked') == true){
				$('#show_label').val(1);				
			}else{
				$('#show_label').val(0);
			}
			$('#search').click();
		});
	});
	<?php
	$firstDistrict = !empty($wardArr) ? array_values($wardArr)[0] : [];

	?>
		 //tạo map, tạo marker
		function initMap() {
			@if(!empty($wardArr))
		    latLong = new google.maps.LatLng({{ $firstDistrict['location'][0] }}, {{ $firstDistrict['location'][1] }});
		    @else
		    latLong = new google.maps.LatLng(15.961533, 107.856976);
		    @endif

		    map = new google.maps.Map(document.getElementById('map'), {
		        zoom: @if(!empty($wardArr))  12 @else 6 @endif,
		        center: latLong
		    });
		    function setMapOnAll(map) {
		        for (var i = 0; i < markers.length; i++) {
		          markers[i].setMap(map);
		        }
		      }
		    markerCluster = new MarkerClusterer(map, markers,
		        {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});

		    $('#modal-edit').on('show.bs.modal', function(e) {
		        current_shopId = $(e.relatedTarget).data('id');

		    });
		
		    @foreach($wardArr as $ward_id => $pro)
				marker = new google.maps.Marker({
	                    position: new google.maps.LatLng({{ $pro['location'][0] }}, {{ $pro['location'][1] }}),
	                    map: map,
	                    ward_id : {{ $ward_id }},
	                    /*icon: {
	                        url: markerFilter[i].icon_url,
	                        size: new google.maps.Size(50, 50)
	                    },*/
	                    label: {text: '{{ $pro["total"] }}', color: "#FFF", labelClass : 'labels-marker'}

	                });
				markers.push(marker);
				marker.addListener('click', function() {
					$('#ward').val({{ $ward_id}}).selectpicker('refresh');
		         	$('#search').click();	
		        });
				
			@endforeach
			
		    $("#search").click(function (){
		    	var company  = $('#company').val();
		    	var province  = $('#province').val();
		    	var district  = $('#district').val();
		    	var ward  = $('#ward').val();
		    	
		    	if(company > 0 && province == '' && district == '' && ward == ''){
		    		location.href = '{{ route('home') }}?company_id=' + company;
		    	}
		    	if(company > 0 && province > 0 && district == '' && ward == ''){
		    		location.href = '{{ route('home') }}/district-' + province + '.html';
		    	}
		    	if(company > 0 && province > 0 && district > 0  && ward == ''){
		    		location.href = '{{ route('home') }}/ward-' + district + '.html';
		    	}
		    	
		    	setMapOnAll(null);
		    	$('#is_search').val(1);
		        markerCluster.clearMarkers();
		        markers = [];
		        $.ajax({
		            type: "GET",
		            url: '/location',
		            data: {
		                userId : userId,
		                provinceId : $("select#province").val(),
		                districtId : $("select#district").val(),
		                companyId : $("#company").val(),
		                wardId :  $("select#ward").val()
		            },
		            success: function(data) {
		                //$(".check-list-box li").addClass('active');
		                markers_temp = data;

		                var markerFilter = []; 
		                $('.checked_value').val('');
		                $(".check-list-box li.active a").each(function(idx, li) {            
		                    var col = $(this).data('col');    
		                    var val = $(this).attr('value');
		                    var tmp = $('#' + col).val();
		                    $('#' + col).val(tmp + val  + ";");
		                }); 

		                for (var i = 0; i < markers_temp.length; i++) {

		                    var rs = true;
		                    $('.checked_value').each(function(){                        
		                        var value = $(this).val();
		                        
		                        if(value != ''){
		                            var result = value.slice(0, -1);
		                            var tmpArr = result.split(';')
		                            var col = $(this).attr('id'); 
		                        
		                            if($.inArray(markers_temp[i][col].toString(), tmpArr) === -1){
		                                rs = false;
		                            }
		                        }else{
		                            rs = false;
		                        }                       
		                    });                 
		                    if(rs == true){                 
		                        markerFilter.push(markers_temp[i]);

		                    }

		                }

		                if($(".check-list-box li.active a").length==0){
		                    markerFilter = [];
		                }                
		                
		                for (var i = 0; i < markerFilter.length; i++) {		                    
		                    if($('#show_label').val() == 1){
		                        marker = new google.maps.Marker({
		                            position: new google.maps.LatLng(parseFloat(markerFilter[i].location.split(',')[0]), parseFloat(markerFilter[i].location.split(',')[1])),
		                            map: map,
		                            title: markerFilter[i].shop_name,
		                            data: markerFilter[i],
		                            icon: {
		                                url: markerFilter[i].icon_url,
		                                size: new google.maps.Size(50, 50)
		                            },
		                            label: {text: markers_temp[i].shop_name, color: "red", labelClass : 'labels-marker'}

		                        });
		                    }else{
		                        marker = new google.maps.Marker({
		                            position: new google.maps.LatLng(parseFloat(markerFilter[i].location.split(',')[0]), parseFloat(markerFilter[i].location.split(',')[1])),
		                            map: map,
		                            title: markerFilter[i].shop_name,
		                            data: markerFilter[i],
		                            icon: {
		                                url: markerFilter[i].icon_url,
		                                size: new google.maps.Size(50, 50)
		                            }
		                        });
		                    }
		                    markers.push(marker);
		                    (function(marker, i) {
		                        google.maps.event.addListener(marker, 'click', function() {
		                            infowindow = new google.maps.InfoWindow({
		                                content: getContent(marker.data)
		                            });
		                            if(tempIW)
		                                tempIW.close();
		                            infowindow.open(map, marker);
		                            tempIW = infowindow;
		                            google.maps.event.addListener(infowindow, 'domready', function() {
		                                $("#view-more").on("click", function() {
		                                    view_more($(this).attr("data"));
		                                });

		                            });
		                        });

		                    })(marker, i);
		                }

		                if(markerFilter.length > 0){
		                    markerCluster.addMarkers(markers);
		                    map.setCenter(new google.maps.LatLng(parseFloat(markerFilter[0].location.split(',')[0]), parseFloat(markerFilter[0].location.split(',')[1])));
		                    map.setZoom(14);

		                }
		                if($('#is_search').val() == 1){
			                $('#txt_result').html( markerFilter.length + ' kết quả');
			                $('#div_result').show();
			                setTimeout(function(){ $('#div_result').hide() }, 3000);
		            	}

		            },
		        });
		    });
			function getCountWard(){
				setMapOnAll(null);
		    	$('#is_search').val(1);
		        markerCluster.clearMarkers();
		        markers = [];
		        $.ajax({
		            type: "GET",
		            url: '/ward-marker',
		            data: {
		                userId : userId,
		                provinceId : $("select#province").val(),
		                districtId : $("select#district").val(),
		                companyId : $("#company").val(),
		                wardId :  $("select#ward").val()
		            },
		            success: function(data) {
		                //$(".check-list-box li").addClass('active');
		                markers_temp = data;

		                var markerFilter = []; 
		                $('.checked_value').val('');
		                $(".check-list-box li.active a").each(function(idx, li) {            
		                    var col = $(this).data('col');    
		                    var val = $(this).attr('value');
		                    var tmp = $('#' + col).val();
		                    $('#' + col).val(tmp + val  + ";");
		                }); 

		                for (var i = 0; i < markers_temp.length; i++) {

		                    var rs = true;
		                    $('.checked_value').each(function(){                        
		                        var value = $(this).val();
		                        
		                        if(value != ''){
		                            var result = value.slice(0, -1);
		                            var tmpArr = result.split(';')
		                            var col = $(this).attr('id'); 
		                        
		                            if($.inArray(markers_temp[i][col].toString(), tmpArr) === -1){
		                                rs = false;
		                            }
		                        }else{
		                            rs = false;
		                        }                       
		                    });                 
		                    if(rs == true){                 
		                        markerFilter.push(markers_temp[i]);

		                    }

		                }

		                if($(".check-list-box li.active a").length==0){
		                    markerFilter = [];
		                }                
		                
		                for (var i = 0; i < markerFilter.length; i++) {		                    
		                    if($('#show_label').val() == 1){
		                        marker = new google.maps.Marker({
		                            position: new google.maps.LatLng(parseFloat(markerFilter[i].location.split(',')[0]), parseFloat(markerFilter[i].location.split(',')[1])),
		                            map: map,
		                            title: markerFilter[i].shop_name,
		                            data: markerFilter[i],
		                            icon: {
		                                url: markerFilter[i].icon_url,
		                                size: new google.maps.Size(50, 50)
		                            },
		                            label: {text: markers_temp[i].shop_name, color: "red", labelClass : 'labels-marker'}

		                        });
		                    }else{
		                        marker = new google.maps.Marker({
		                            position: new google.maps.LatLng(parseFloat(markerFilter[i].location.split(',')[0]), parseFloat(markerFilter[i].location.split(',')[1])),
		                            map: map,
		                            title: markerFilter[i].shop_name,
		                            data: markerFilter[i],
		                            icon: {
		                                url: markerFilter[i].icon_url,
		                                size: new google.maps.Size(50, 50)
		                            }
		                        });
		                    }
		                    markers.push(marker);
		                    (function(marker, i) {
		                        google.maps.event.addListener(marker, 'click', function() {
		                            infowindow = new google.maps.InfoWindow({
		                                content: getContent(marker.data)
		                            });
		                            if(tempIW)
		                                tempIW.close();
		                            infowindow.open(map, marker);
		                            tempIW = infowindow;
		                            google.maps.event.addListener(infowindow, 'domready', function() {
		                                $("#view-more").on("click", function() {
		                                    view_more($(this).attr("data"));
		                                });

		                            });
		                        });

		                    })(marker, i);
		                }

		                if(markerFilter.length > 0){
		                    markerCluster.addMarkers(markers);
		                    map.setCenter(new google.maps.LatLng(parseFloat(markerFilter[0].location.split(',')[0]), parseFloat(markerFilter[0].location.split(',')[1])));
		                    map.setZoom(14);

		                }
		                if($('#is_search').val() == 1){
			                $('#txt_result').html( markerFilter.length + ' kết quả');
			                $('#div_result').show();
			                setTimeout(function(){ $('#div_result').hide() }, 3000);
		            	}

		            },
		        });
			}
		}
		$(document).ready(function(){
			
				
		});

	</script>
	@include('partials.modal-edit-gallery')

<script type="text/javascript">
	$(document).ready(function(){
		@if(Session::has('message'))     
			$('#txt_result').html( '{{ Session::get('message') }}' );
	        $('#div_result').show();
	        setTimeout(function(){ $('#div_result').hide() }, 3000);
        @endif

	});
</script>
<script type="text/javascript">
	$(document).ready(function(){
		@if(empty($wardArr))     
			$('#txt_result').html( '0 kết quả' );
	        $('#div_result').show();
	        setTimeout(function(){ $('#div_result').hide() }, 5000);
        @endif        
	});
</script>
</body>
</html>
