<!DOCTYPE html>
<html>

<body>

<div id="map" class="col-md-12" style="margin-bottom: 10px"></div>
<script>
    function initMap() {
        var lat, long;
        var marker_info = '<?php echo e($marker->location); ?>';
        var shopId = <?php echo e($marker->id); ?>;
        var latLong = new google.maps.LatLng(parseFloat(marker_info.split(',')[0]), parseFloat(marker_info.split(',')[1]));
        var mapOptions = {
            zoom: 14,
            center: latLong
        }
        var map = new google.maps.Map(document.getElementById("map"), mapOptions);
        var marker = new google.maps.Marker({
            position: latLong ,
            map: map,
            draggable:true,
            title : "Kéo, thả để đánh dấu"
        });
        google.maps.event.addListener(marker, 'dragend', function(event) {
            lat = event.latLng.lat();
            long = event.latLng.lng();

            $("#updateMarker").click(function (){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    data : {
                        position : lat +',' + long,
                        shopId : shopId
                    },
                    url: '/updatemarker',
                    success : function (data) {
                        if (data == 0){
                            alert("Cập nhật thành công");
                            window.location.href = '/'+ shopId;
                        }
                        else {
                            alert("Có lỗi xảy ra");
                        }

                    }
                })

            })

        });

    }


</script>
<div class="row" align="center" class="col-md-12">
    <button type="button" class="btn btn-info" id="updateMarker">Lưu</button>
</div>
</body>
</html>

<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>