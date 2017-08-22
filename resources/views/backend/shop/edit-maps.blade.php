@extends('backend.layout')
@section('content')
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Cập nhật maps
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
         <li><a href="{{ route('shop.index') }}">Shop</a></li>
         <li class="active">Cập nhật</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      
      <form role="form" method="POST" action="{{ route('shop.update') }}" id="formData">
<button type="submit" class="btn btn-primary btn-sm" id="btnSave" style="margin-top:-5px">Lưu</button>
      <a class="btn btn-default btn-sm btnBack" href="javascript:void(0)" style="margin-bottom:5px">Quay lại</a>

         <input type="hidden" name="id" value="{{ $detail->id }}">
         <input type="hidden" name="update_maps" value="1">
         <div class="row">
            <!-- left column -->
            <div class="col-md-12">
               <!-- general form elements -->
               <div class="box box-primary">
                  <div class="box-header with-border">
                     <h3 class="box-title">Cập nhật maps</h3>
                  </div>
                  <!-- /.box-header -->               
                  {!! csrf_field() !!}
                  <div class="box-body">                     
                  <h3>{{ $detail->shop_name }}</h3>
                  @if(Session::has('message'))
                  <p class="alert alert-info" >{{ Session::get('message') }}</p>
                  @endif
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
                        <a class="btn btn-default btn-sm btnBack"  href="javascript:void(0)">Hủy</a>
                     </div>
                  </div>
               </div>
               <!-- /.box -->     
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
   height: 600px;
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
           
   
   $(document).ready(function(){
       $('#formData').submit(function(){
         $('#btnSave').hide();
         $('#btnLoading').show();
       });      
       $('.btnBack').click(function(){
        //window.opener.location.reload(false);
        window.top.close();
       });
       @if(Session::has('message'))
       window.opener.location.reload(false);

       window.top.close();       

       @endif
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
       zoom: 19,
       mapTypeId: 'roadmap'
     });
    @if(!empty($markerArr))
    @foreach($markerArr as $marker)
    <?php 
      $tmpLocation = explode(',', $marker['location']);
      ?>
    marker = new google.maps.Marker({
              position: new google.maps.LatLng(parseFloat({{ $tmpLocation[0] }}), parseFloat({{ $tmpLocation[1] }})),
              map: map,
              title: '{{ $marker['shop_name'] }}',              
              icon: {
                  url: '{{ Helper::showImage($marker['icon_url']) }}',
                  size: new google.maps.Size(50, 50)
              },
              label: {text: '{{ $marker['shop_name'] }}', color: "red", labelClass : 'labels-marker'}

          });
    @endforeach
    @endif
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