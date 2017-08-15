var markerCluster, marker;
var markers_temp, markers = [];
var map;
var edit_link = "12";
var tempIW = '';
var current_shopId, latLong;
// lấy thông tin khi click vào marker
function getContent(data) {
    data = JSON.parse(data);    
    var html = '';
    $.ajax({
        url : $('#route_get_image_thumbnail').val(),
        type : 'GET',
        data : {
            id : data.shop_id
        },
        async: false,
        success : function (response){
            html = response;
        }
    });
   
    return html;
}   
$(document).on('click', '.view-more', function(){
    var obj = $(this);
    $.ajax({
        type: "GET",
        data : {
            id : obj.data('id'),
        } ,
        url: $('#route_gallery').val(),
        success: function(data) {
            $('#content_gallery').html(data);
            $('#myModalGallery').modal('show');
        }

    });
});
$(document).on('click', '.edit-shop', function(){
    var obj = $(this);
    $.ajax({
        type: "GET",
        data : {
            id : obj.data('id'),
            district_id : $('select#district').val()
        } ,
        url: $('#route_edit_fe').val(),
        success: function(data) {

            $('#content_edit_shop').html(data);
            $('#myModalShop').modal('show');
            $('#current_url_update').val($('#current_url').val());
        },

    });
});


function getListDistrict() {
    $('#district').empty();
    $.ajax({
            method: "get",
            url: '/getdistrict',
            data: {
                provinceId : $("select#province").val(),
            },
            success: function (data) {
                $('#district').append($('<option>', {
                    value: 0,
                    text: 'Tất cả',

                }));
                for (var i = 0; i < data.length; i++) {
                    $('#district').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name,

                    }));
                }
               $('#district').selectpicker('refresh');
            }
        });
}

function getListWard() {
    $('#ward').empty();
    $.ajax({
        method: "get",
        url: '/getward',
        data: {
            districtId : $("select#district").val(),
        },
        success: function (data) {
            $('#ward').append($('<option>', {
                value: 0,
                text: 'Tất cả',

            }));
            for (var i = 0; i < data.length; i++) {
                $('#ward').append($('<option>', {
                    value: data[i].id,
                    text: data[i].name,

                }));
            }
            $('#ward').selectpicker('refresh');
        }
    });

}

function editMarker() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        data : {
            id :current_shopId,
            full_address: $("input[name=full_address]").val(),
            shop_name: $("input[name=shop_name]").val(),
            namer : $("input[name=namer]").val(),
            phone: $("input[name=phone]").val(),
            cap_do_1480213548_id: $("select[name=level]").val(),
            quy_mo1480440358_id: $("select[name=quymo]").val(),
            tiem_nang1480213595_id: $("select[name=tiemnang]").val(),
            status : $("input[name=status]").prop('checked'),
        } ,
        url: '/doEdit',
        success: function(data) {
            if (data == 1) {
                alert("Cập nhật thành công");
            }
            else {
                alert("Có lỗi xảy ra!");
            }

        },

    });
}

function editMarkerPosition() {
    window.location.href = '/editMarker/'+ current_shopId;
}

function getRelateLocation() {
    $.ajax({
        method: "get",
        url: '/getRelate',
        data: {
            shopId: updateShopId
        },
        success: function (data) {
            markers_temp = data;
            for (var i = 0; i < markers_temp.length; i++) {
                // init markers
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(parseFloat(markers_temp[i].location.split(',')[0]), parseFloat(markers_temp[i].location.split(',')[1])),
                    map: map,
                    title: markers_temp[i].shop_name,
                    data : markers_temp[i],
                    icon: {
                        url: markers_temp[i].icon_url,
                        size: new google.maps.Size(50, 50),
                    },

                });
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
            markerCluster.addMarkers(markers);
            map.setCenter(latLong);
            map.setZoom(16);
            $('.selectpicker').selectpicker('val',markers_temp[0].province_id);
        }
    });

}

function doLogin() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "post",
        url: '/login',
        data: {
            user : $("input[name=userLog]").val(),
            pass: $("input[name=passLog]").val(),

        },
        success: function (data) {
            if ( data == 0 ) {
                location.reload();
            }
            else {
                $("p[name=loginFail]").show();
            }
        }
    });
}
