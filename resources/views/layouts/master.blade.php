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
		<form action="{{ url()->current() }}"  method="GET" id="searchForm">
		<header class="main-header">
			<div class="user-panel-top">
				<div class="pull-left image">
					<a href="{{ route('home') }}"><img src="{{ URL::asset('assets/images/logo_small.png') }}" class="" alt="{{ Auth::user()->fullname }}"></a>
				</div>
				<div class="info">
					<p>Hi , {{ Auth::user()->fullname }}</p>
					<a href="{{ route('logout') }}" title="Logout" style="color:red"><i class="fa fa-circle text-danger"></i> Logout</a>
				</div>
			</div><!-- /.user-panel -->					
            <div id="search_icon">
            	<button type="button" class="btn btn-primary"><span class="fa fa-search"></span></button>
            </div><!-- /#search -->
            <nav class="navbar navbar-static-top">
            	<a href="javascript:void(0)" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a><!-- /.sidebar-toggle -->
                <div class="row">
                	<div class="row form-select">
                        <div class="col-sm-12 group-list-drop-down">
                        	@if(Auth::user()->type == 1)
                            <div class="form-group col-sm-2 list-drop-down">
                                <label class="col-sm-2 control-label" for="">Công Ty</label>
                                <div class="col-sm-10">
									<select id="company" name="company_id" class="selectpicker custom-select form-control" data-live-search="true">										
										@foreach($companyList as $com)
					                    <option value="{{ $com->id }}" {{ $company_id == $com->id ? "selected" : "" }}>{{ $com->company_name }}</option>
					                    @endforeach
									</select>
								</div>
                            </div>
                            @else
                            <input type="hidden" id="company" name="company_id" value="{{ Auth::user()->company_id }}">
                            @endif
                            <div class="form-group col-sm-3 list-drop-down">                            
                                <label class="col-sm-2 control-label" for="">Tỉnh / Thành Phố</label>
                                <div class="col-sm-10">
								<select id="province" name="province_id" class="selectpicker custom-select form-control"  title="Chọn tỉnh/thành" data-live-search="true">
									<option value='0'>Tất cả</option>
									 @foreach($listProvince as $province)
				                    <option value="{{$province->id}}" {{ (isset($province_id) && $province_id == $province->id)  ? "selected"  : "" }}>{{$province->name}}</option>
				                    @endforeach
								</select>
							</div>
                            </div>
                            <div class="form-group col-sm-3 list-drop-down">
                                <label class="col-sm-2 control-label" for="district">Quận / Huyện</label>
                                <div class="col-sm-10">
                                    <select id='district' name='district_id' class="selectpicker custom-select form-control" data-live-search="true" title="Chọn quận/huyện">      
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
                                    <select id='ward' name='ward_id' title="Chọn phường/xã" class="selectpicker custom-select form-control" data-live-search="true">
                                        <option value='0'>Tất cả</option>
                                        @foreach($wardList as $ward)
					                    <option value="{{$ward->id}}" {{ (isset($ward_id) && $ward_id == $ward->id)  ? "selected"  : "" }}>{{$ward->name}}</option>
					                    @endforeach   
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-sm-3 list-drop-down">
		                        <label class="col-sm-2 control-label" for="">Tên shop</label>
		                        <div class="col-sm-10" id="ward">
		                            <input type="text" name="name" value="{{ isset($keyword) ? $keyword : "" }}" placeholder="Tên shop..." class="form-control">
		                        </div>
		                    </div><!-- /list-drop-down -->
                            <div class="form-group col-sm-1 btn-search-max">
                                <button type="submit" style="width: 100%;" id="search"><span class="fa fa-search"></span></button>
                            </div>
                        </div>
                    </div>              
                </div><!-- /.row -->
            </nav><!-- /nav -->
		</header><!-- /header -->

		<aside class="main-sidebar">
			<section class="sidebar">
			 	<div class="user-panel user-panel-user">
					<div class="pull-left image">
						<a href="{{ route('home') }}"><img src="{{ URL::asset('assets/images/logo_small.png') }}" class="img-circle" alt="User Image"></a>
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
							<li class="@if($typeArrDefault == $typeArr ) active @endif filter_all" data-filter="filter_type">
								<a href="javascript:void(0)" title="" value="" data-col="type_id">							
									<span><img src="{{ URL::asset('assets/images/all.png') }}" alt="Tất cả"></span>Tất cả
								</a>
							</li>
							@foreach($shopType as $type)		                        
		                        <li class="{{ in_array($type->id, $typeArr) ? "active" : "" }} filter_type filter" data-filter="filter_type" data-value="{{ $type->id }}"><a href="javascript:void(0)" title=""  value="{{ $type->id }}" data-col="type_id">
									<span><img src="{{ Helper::showImage($type->icon_url) }}" alt="{!! $type->type !!}"></span>
									{!! $type->type !!}
								</a>
								<input type="hidden" class="value" name="type[]" value="{{ in_array($type->id, $typeArr) ? $type->id : "" }}">
								</li>
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
							<li class="@if(!$arrSearch[$condition->name."_id"] )active  @endif filter_all" data-filter="filter_{{ $condition->name }}"><a href="#" title="" value="" data-col="{{ $condition->name }}_id" style="border-color: #41ADFF">Tất cả</a></li>
							@foreach($dataList as $data)
								<?php 
								$checked = !$arrSearch[$condition->name."_id"] || in_array($data->id, $arrSearch[$condition->name."_id"]) ? true : false;
								?>
								<li class="@if($checked) active @endif filter_{{ $condition->name }} filter" data-value="{{ $data->id }}" data-filter="filter_{{ $condition->name }}"><a href="#" title="" value="{{ $data->id }}" data-col="{{ $condition->name }}_id" style="border-color: {{ $data->color }};">{{ $data->type }}</a>
								<input type="hidden" class="value" name="{{ $condition->name }}_id[]" value="@if($checked){{ $data->id }}@endif">
								</li>
			                @endforeach
						</ul>
						
					</li><!-- /.treeview -->
					@endforeach		
					<li style="padding-left:10px;padding-top:20px">
						
						<label style="color:red">
							<input type="checkbox" id="check_show_label" {{  $show_label == 1 ? "checked" : "" }}> Hiển thị tên shop
						</label>
						
					</li>			
				</ul>
				<input type="hidden" id="show_label" name="show_label" value="{{ $show_label }}">
			</section><!-- /.sidebar -->
		</aside><!-- /main-sidebar -->
		</form>
		<div class="content-wrapper">
			<div id="map">
				
			</div>
		</div><!-- /content-wrapper -->
	</div>
	<div class="notFound" id="div_result" style="display:none">
		<p>
			<i class="fa fa-exclamation-circle"></i>
			<span id="txt_result"></span>
		</p>
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
    @if(Auth::check())
	<script>
	var userId = {{ Auth::user()->id }};
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
			$('#searchForm').submit();
		});
		$('li.filter').click(function(){
			var obj = $(this);
			if(obj.hasClass('active')){				
				obj.children('.value').val(obj.data('value'));
			}else{				
				obj.children('.value').val('');
			}
			
			obj.parents('form').submit();
		});		
		$('#company').change(function(){
			removeHidden();
			$('#province, #district, #ward').val('').selectpicker('refresh');
			$(this).parents('form').submit();
		});
		$('#province').change(function(){			
			$('#district, #ward').val('').selectpicker('refresh');
			$(this).parents('form').submit();
		});
		$('#district').change(function(){			
			$('#ward').val('').selectpicker('refresh');
			$(this).parents('form').submit();
		});
		$('#ward').change(function(){			
			$(this).parents('form').submit();
		});
	});
	function removeHidden(){
		$('input.value[value=""]').remove();
	}



		<?php
	if($view != 'detail' ){
		$firstMarker = !empty($markerArr) ? array_values($markerArr)[0] : [];
	}else{		
		$tmpFirstMarker = $markerArr ? $markerArr[0] : [];		
		if(!empty($tmpFirstMarker)){
			$firstMarker['location'] = explode(',', $tmpFirstMarker['location']);
		}
	}
	if($view == 'province'){
		$zoom = 6;
	}elseif($view == 'district'){
		$zoom = 9;
	}elseif($view == 'ward'){
		$zoom = 12;
	}else{
		$zoom = 14;
	}
	if(empty($markerArr)){
		$zoom = 6;
	}
	?>
		 //tạo map, tạo marker
		function initMap() {
			
			@if(!empty($firstMarker))				
		    latLong = new google.maps.LatLng({{ $firstMarker['location'][0] }}, {{ $firstMarker['location'][1] }});
		    @else
		    latLong = new google.maps.LatLng(15.961533, 107.856976);
		    @endif
		    
		    map = new google.maps.Map(document.getElementById('map'), {
		        zoom: {{ $zoom }},
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

		    if (window.location.pathname != '/') {
		        getRelateLocation();

		    }
		    @if($view != 'detail')
		    @foreach($markerArr as $id => $marker)
		    	<?php $total+= $marker["total"];?>
				marker = new google.maps.Marker({
	                    position: new google.maps.LatLng({{ $marker['location'][0] }}, {{ $marker['location'][1] }}),
	                    map: map,
	                    province_id : {{ $id }},	                    
	                    label: {text: '{{ $marker["total"] }}', color: "#FFF", labelClass : 'labels-marker'}

	                });
				markers.push(marker);
				marker.addListener('click', function() {
					@if($view == 'province')			
		         	$('select#province').val({{ $id }}).selectpicker('refresh');
		         	@elseif($view == 'district')
		         	$('select#district').val({{ $id }}).selectpicker('refresh');
		         	@elseif($view == 'ward')
		         	$('select#ward').val({{ $id }}).selectpicker('refresh');
		         	@endif
		         	$('#searchForm').submit();     	
		        });
				
			@endforeach
			@else
			<?php $i = 0; ?>
			@foreach($markerArr as $marker)
			<?php $i++; ?>
			var data = '<?php echo json_encode($marker); ?>';
				var i = {{ $i }};
				<?php 
				$tmpLocation = explode(',', $marker['location']);
				?>
                if($('#show_label').val() == 1){
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(parseFloat({{ $tmpLocation[0] }}), parseFloat({{ $tmpLocation[1] }})),
                        map: map,
                        title: '{{ $marker['shop_name'] }}',
                        data: data,
                        icon: {
                            url: '{{ Helper::showImage($marker['icon_url']) }}',
                            size: new google.maps.Size(50, 50)
                        },
                        label: {text: '{{ $marker['shop_name'] }}', color: "red", labelClass : 'labels-marker'}

                    });
                }else{
                	
                     marker = new google.maps.Marker({
                        position: new google.maps.LatLng(parseFloat({{ $tmpLocation[0] }}), parseFloat({{ $tmpLocation[1] }})),
                        map: map,
                        title: '{{ $marker['shop_name'] }}',
                        data: data,
                        icon: {
                            url: '{{ Helper::showImage($marker['icon_url']) }}',
                            size: new google.maps.Size(50, 50)
                        }

                    });
                }
                markers.push(marker);
                (function(marker, i) {
                    google.maps.event.addListener(marker, 'click', function() {
                    	console.log(marker.data);
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

          	@endforeach
          	if(markers.length > 0){
                markerCluster.addMarkers(markers);
                
              //  map.setZoom(12);

            }
			@endif
		   
			
		}	

	</script>
	@include('partials.modal-edit-gallery')
	<input type="hidden" id="current_url" value="{{ urlencode(url()->full()) }}">
	<div class="notFound" id="div_result" style="display:none">
		<p>
			<i class="fa fa-exclamation-circle"></i>
			<span id="txt_result"></span>
		</p>
	</div>
	<script type="text/javascript">
		<?php $total = isset($total) ? $total : 0 ; ?>
		$(document).ready(function(){
			$('#txt_result').html( '{{ $total }} &nbsp; kết quả' );
	        $('#div_result').show();
	        setTimeout(function(){ $('#div_result').hide() }, 4000);
		});
	</script>
</body>
</html>
