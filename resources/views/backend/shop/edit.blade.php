@extends('backend.layout')
@section('content')
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Cập nhật shop
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
         <li><a href="{{ route('shop.index') }}">Shop</a></li>
         <li class="active">Cập nhật</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <a class="btn btn-default btn-sm" href="{{ route('shop.index') }}" style="margin-bottom:5px">Quay lại</a>
      <form role="form" method="POST" action="{{ route('shop.update') }}" id="formData">
         <input type="hidden" name="id" value="{{ $detail->id }}">
         <div class="row">
            <!-- left column -->
            <div class="col-md-6">
               <!-- general form elements -->
               <div class="box box-primary">
                  <div class="box-header with-border">
                     <h3 class="box-title">Cập nhật</h3>
                  </div>
                  <!-- /.box-header -->               
                  {!! csrf_field() !!}
                  <div class="box-body">
                     @if (count($errors) > 0)
                     <div class="alert alert-danger">
                        <ul>
                           @foreach ($errors->all() as $error)
                           <li>{{ $error }}</li>
                           @endforeach
                        </ul>
                     </div>
                     @endif            
                     <div class="form-group col-md-6">
                        <label>Company <span class="red-star">*</span></label>
                        <select class="form-control" name="company_id" id="company_id">
                           <option value="" >--Chọn--</option>
                           @foreach($companyList as $com)
                           <option value="{{ $com->id }}" {{ $com->id == $detail->company_id ? "selected" : "" }}>{{ $com->company_name }}</option>
                           @endforeach
                        </select>
                     </div>
                     <!-- text input -->
                     <div class="form-group col-md-6">
                        <label>Loại shop <span class="red-star">*</span></label>
                        <select class="form-control" name=" type_id" id=" type_id">
                           <option value="" >--Chọn--</option>
                           @foreach($shopTypeList as $com)
                           <option value="{{ $com->id }}" {{ $com->id == $detail->type_id ? "selected" : "" }}>{{ $com->type }}</option>
                           @endforeach
                        </select>
                     </div>
                     <!-- text input -->
                     <div class="form-group col-md-4">
                        <label> Tỉnh/Thành <span class="red-star">*</span></label>
                        <select class="form-control" name="province_id" id="province_id">
                           <option value="" >--Chọn--</option>
                           @foreach($provinceList as $province)
                           <option value="{{$province->id}}" {{ $province->id == $detail->province_id ? "selected" : "" }}>{{$province->name}}</option>
                           @endforeach
                        </select>
                     </div>
                     <div class="form-group col-md-4">
                        <label> Quận/Huyện <span class="red-star">*</span></label>
                        <select class="form-control" name="district_id" id="district_id">
                           <option value="" >--Chọn--</option>
                           @foreach($districtList as $district)
                           <option value="{{$district->id}}" {{ $district->id == $detail->district_id ? "selected" : "" }}>{{$district->name}}</option>
                           @endforeach
                        </select>
                     </div>
                     <div class="form-group col-md-4">
                        <label> Phường/Xã <span class="red-star">*</span></label>
                        <select class="form-control" name="ward_id" id="ward_id">
                           <option value="" >--Chọn--</option>
                           @foreach($wardList as $ward)
                           <option value="{{$ward->id}}" {{ $ward->id == $detail->ward_id ? "selected" : "" }}>{{$ward->name}}</option>
                           @endforeach
                        </select>
                     </div>
                     <div class="form-group col-md-12">
                        <label>Tên shop <span class="red-star">*</span></label>
                        <input type="text" class="form-control" name="shop_name" id="shop_name" value="{{ old('shop_name', $detail->shop_name) }}">
                     </div>
                     <div class="form-group col-md-6">
                        <label>Địa chỉ <span class="red-star">*</span></label>
                        <input type="text" class="form-control" name="address" id="address" value="{{ old('address', $detail->address) }}">
                     </div>
                     <div class="form-group col-md-6">
                        <label>Đường phố </label>
                        <input type="text" class="form-control" name="street" id="street"  value="{{ old('street', $detail->street) }}">
                     </div>
                     <div class="form-group col-md-12">
                        <label>Địa chỉ đầy đủ </label>
                        <input type="text" class="form-control" name="full_address" id="full_address" value="{{ old('full_address', $detail->full_address) }}">
                     </div>
                     <div class="form-group col-md-6">
                        <label>Người liên hệ </label>
                        <input type="text" class="form-control" name="namer" id="namer"  value="{{ old('namer', $detail->namer) }}">
                     </div>
                     <div class="form-group col-md-6">
                        <label>Số điện thoại </label>
                        <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', $detail->phone) }}">
                     </div>
                     <div class="form-group col-md-12">
                        <label>Trạng thái</label>
                        <select class="form-control" name="status" id="status">                                      
                        <option value="1" {{ old('status', $detail->status) == 1 ? "selected" : "" }}>Hiện </option>                  
                        <option value="2" {{ old('status', $detail->status) == 2 ? "selected" : "" }}>Ẩn</option>                  
                        </select>
                     </div>
                     <div class="clearfix"></div>
                     <div class="form-group col-md-12" style="margin-top:10px;margin-bottom:10px">
                        <input id="pac-input" class="controls" type="text" placeholder="Nhập địa chỉ để tìm kiếm">
                        <div id="map-abc"></div>
                     </div>
                     <div class="clearfix"></div>
                  </div>
                  <?php 
                     $tmp = explode(",",$detail->location);
                     $latt = $tmp[0] ? $tmp[0] : '10.7860332';
                     $longt = $tmp[1] ? $tmp[1] : '106.6950147';      
                     ?>
                  <input type="hidden" name="latt" id="latt" value="{{ $latt }}">
                  <input type="hidden" name="longt" id="longt" value="{{ $longt }}">
                  <div class="box-footer ">
                     <div class="col-md-12">
                        <button type="button" class="btn btn-default btn-sm" id="btnLoading" style="display:none"><i class="fa fa-spin fa-spinner"></i></button>
                        <button type="submit" class="btn btn-primary btn-sm" id="btnSave">Lưu</button>
                        <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="{{ route('shop.index')}}">Hủy</a>
                     </div>
                  </div>
               </div>
               <!-- /.box -->     
            </div>
            <div class="col-md-6">
               <div class="box box-primary">
                  <div class="box-header with-border">
                     <h3 class="box-title">Điều kiện</h3>
                  </div>
                  <div class="box-body">
                     @foreach($conditionList as $condition)
                      <div class="form-group col-md-6">
                        <label>{!! $condition->display_name !!}</label>
                        <?php 
                        $dataList = DB::table('shop_'. $condition->name)->where('status', 1)->get();
                        $key = $condition->name."_id";
                        ?>
                        <select class="form-control" name="cond[{{ $key }}]" id="{{ $condition->name }}_id">                                      
                        @foreach($dataList as $data)
                        <option value="{{ $data->id }}" {{ old('cond[$key]', $detail->$key ) == $data->id ? "selected" : "" }}>{{ $data->type }} </option>                  
                        @endforeach
                        </select>
                     </div>                     
                      @endforeach   
                     <div class="clearfix"></div>
                  </div>
               </div>
               <div class="box box-primary">
                  <div class="box-header with-border">
                     <h3 class="box-title">Hình ảnh</h3>
                  </div>
                  <div class="box-body">
                    <input type="hidden" name="folder" value="{{ $folder }}">
                     <div class="form-group" style="margin-top:10px;margin-bottom:10px">
                        <div class="col-md-12" style="text-align:center">
                           <input type="file" id="file-image"  style="display:none" multiple/>
                           <div style="text-align:left">
                              <button class="btn btn-primary btn-sm" id="btnUploadImage" type="button"><span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Upload</button>
                           </div>
                           <div class="clearfix"></div>
                           <div id="div-image" style="margin-top:10px">
                              @if( $hinhArr )
                              @foreach( $hinhArr as $k => $hinh)
                              <div class="col-md-3" style="border:1px solid #CCC">
                                 <div style="height:150px;overflow-y:hidden">
                                    <img src="{{ Helper::showImage($hinh) }}" style="width:100%">
                                 </div>
                                 <div class="checkbox">                                                                         
                                    <button class="btn btn-danger btn-sm remove-image" type="button" data-value="{{ config('uv.upload_path_shop')."UY_VIET_DINH_VI/".$folder."/".basename($hinh) }}" data-id="{{ $k }}" ><span class="glyphicon glyphicon-trash"></span></button>
                                 </div>
                              </div>
                              @endforeach
                              @endif
                           </div>
                        </div>
                        <div style="clear:both"></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!--/.col (left) -->      
</div>
</form>
<!-- /.row -->
</section>
<!-- /.content -->
</div>
<style type="text/css">
   .nav-tabs>li.active>a{
   color:#FFF !important;
   background-color: #3C8DBC !important;
   }
</style>
<style>
   #map-canvas, #map_canvas {
   height: 350px;
   width:100%;
   }
   @media print {
   html, body {
   height: auto;
   }
   #map-canvas, #map_canvas {
   height: 350px;
   width:100%;
   }
   }
   #panel {
   position: absolute;
   left: 60%;
   margin-left: -100px;
   z-index: 5;
   background-color: #fff;
   padding: 5px;
   border: 1px solid #999;
   }
   input {
   border: 1px solid  rgba(0, 0, 0, 0.5);
   }
   input.notfound {
   border: 2px solid  rgba(255, 0, 0, 0.4);
   }
</style>
<style>
   /* Always set the map height explicitly to define the size of the div
   * element that contains the map. */
   #map-abc {
   height: 400px;
   }
   #infowindow-content .title {
   font-weight: bold;
   }
   #infowindow-content {
   display: none;
   }
   #map-abc #infowindow-content {
   display: inline;
   }
   .pac-card {
   margin: 10px 10px 0 0;
   border-radius: 2px 0 0 2px;
   box-sizing: border-box;
   -moz-box-sizing: border-box;
   outline: none;
   box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
   background-color: #fff;
   font-family: Roboto;
   }
   #pac-container {
   padding-bottom: 12px;
   margin-right: 12px;
   }
   .pac-controls {
   display: inline-block;
   padding: 5px 11px;
   }
   .pac-controls label {
   font-family: Roboto;
   font-size: 13px;
   font-weight: 300;
   }
   #pac-input {
   background-color: #fff;
   font-family: Roboto;
   font-size: 15px;
   font-weight: 300;
   margin-left: 12px;
   padding: 0 11px 0 13px;
   text-overflow: ellipsis;
   width: 400px;
   height: 40px;
   }
   #pac-input:focus {
   border-color: #4d90fe;
   }     
</style>
<!-- Modal -->
@stop
@section('javascript_page')
<script type="text/javascript">
   $(document).on('click', '.remove-image', function(){
   
     var obj = $(this);
     if( confirm ("Bạn có chắc chắn không ?")){
        obj.parents('.col-md-3').remove();    
       $.ajax({
         url : "{{ route('delete-image') }}",
         type : "POST",
         data : {
           path : obj.data('value')
         },
         success: function(){
           
         }
       });
       
     }
   });
   
   $(document).on('click', '#btnSearchAjax', function(){
     filterAjax($('#search_type').val());
   });
   $(document).on('keypress', '#name_search', function(e){
     if(e.which == 13) {
         e.preventDefault();
         filterAjax($('#search_type').val());
     }
   });
   
   $(document).ready(function(){
      
         $('#btnUploadImage').click(function(){        
           $('#file-image').click();           
         }); 
        
         var files = "";
         $('#file-image').change(function(e){
            
            files = e.target.files;
            
            if(files != ''){
              var dataForm = new FormData();        
             $.each(files, function(key, value) {
                dataForm.append('file[]', value);
             });   
             
             dataForm.append('date_dir', 0);
             dataForm.append('folder', 'UY_VIET_DINH_VI/{{ $folder }}');
   
             $.ajax({
               url: $('#route_upload_tmp_image_multiple').val(),
               type: "POST",
               async: false,      
               data: dataForm,
               processData: false,
               contentType: false,
               success: function (response) {
                   $('#div-image').append(response);             
               }
             });
           }
         });
         
       });
           
   
   $(document).ready(function(){
         $('#formData').submit(function(){
           $('#btnSave').hide();
           $('#btnLoading').show();
         });
         @if($loginType == 3)
         $('#type').change(function(){
           if($(this).val() == 1){
             $('#chon_mod').show();
           }else{
             $('#chon_mod').hide();
           }
         });
         @endif
       });
       $('#province_id').change(function(){
            $('#district_id').empty();
             $.ajax({
                 method: "get",
                 url: "{{ route('get-district') }}",
                 data: {
                     provinceId : $("select#province_id").val(),
                 },
                 success: function (data) {
                     $('#district_id').append($('<option>', {
                         value: 0,
                         text: '--Chọn--',
   
                     }));
                     for (var i = 0; i < data.length; i++) {
                         $('#district_id').append($('<option>', {
                             value: data[i].id,
                             text: data[i].name,
   
                         }));
                     }               
                 }
             });
       });
       $('#district_id').change(function(){
            $('#ward_id').empty();
             $.ajax({
                 method: "get",
                 url: "{{ route('get-ward') }}",
                 data: {
                     districtId : $("select#district_id").val(),
                 },
                 success: function (data) {
                     $('#ward_id').append($('<option>', {
                         value: 0,
                         text: '--Chọn--',
   
                     }));
                     for (var i = 0; i < data.length; i++) {
                         $('#ward_id').append($('<option>', {
                             value: data[i].id,
                             text: data[i].name,
   
                         }));
                     }               
                 }
             });
       });
</script>
<script>
   // This example adds a search box to a map, using the Google Place Autocomplete
   // feature. People can enter geographical searches. The search box will return a
   // pick list containing a mix of places and predicted search terms.
   
   // This example requires the Places library. Include the libraries=places
   // parameter when you first load the API. For example:
   // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
   
   function initAutocomplete() {
     var map = new google.maps.Map(document.getElementById('map-abc'), {
       center: {lat: {{ $latt }}, lng: {{ $longt }} },
       zoom: 17,
       mapTypeId: 'roadmap'
     });
   
     // Create the search box and link it to the UI element.
     var input = document.getElementById('pac-input');
     var searchBox = new google.maps.places.SearchBox(input);
     map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
   
     // Bias the SearchBox results towards current map's viewport.
     map.addListener('bounds_changed', function() {
       searchBox.setBounds(map.getBounds());
        var marker = new google.maps.Marker({
           position: new google.maps.LatLng({{ $latt }}, {{ $longt }}),
           map: map,
           draggable:true
         });
        google.maps.event.addListener(marker,'dragend',function(event) {
             document.getElementById('latt').value = this.position.lat();
             document.getElementById('longt').value = this.position.lng();                
         });
     });
   
     var markers = [];       
     // Listen for the event fired when the user selects a prediction and retrieve
     // more details for that place.
     searchBox.addListener('places_changed', function() {
       var places = searchBox.getPlaces();
   
       if (places.length == 0) {
         return;
       }
   
       // Clear out the old markers.
       markers.forEach(function(marker) {
         marker.setMap(null);
       });
       markers = [];
   
       // For each place, get the icon, name and location.
       var bounds = new google.maps.LatLngBounds();
       places.forEach(function(place) {
         if (!place.geometry) {
           console.log("Returned place contains no geometry");
           return;
         }
         document.getElementById('latt').value = place.geometry.location.lat();
         document.getElementById('longt').value = place.geometry.location.lng();
         
         var icon = {
           url: place.icon,
           size: new google.maps.Size(128, 128),
           origin: new google.maps.Point(0, 0),
           anchor: new google.maps.Point(17, 34),
           scaledSize: new google.maps.Size(25, 25)
         };
   
         // Create a marker for each place.
         markers.push(new google.maps.Marker({
           map: map,
           icon: icon,
           title: place.name,
           draggable:true,
           position: place.geometry.location
         }));
   
         if (place.geometry.viewport) {
           // Only geocodes have viewport.
           bounds.union(place.geometry.viewport);
         } else {
           bounds.extend(place.geometry.location);
         }
   
          // Clear out the old markers.
       markers.forEach(function(marker) {
         google.maps.event.addListener(marker,'dragend',function(event) {
             document.getElementById('latt').value = this.position.lat();
             document.getElementById('longt').value = this.position.lng();                
         });
       });
         
       });
       map.fitBounds(bounds);
     });
   }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAhxs7FQ3DcyDm8Mt7nCGD05BjUskp_k7w&libraries=places&callback=initAutocomplete"
   async defer></script>
@stop