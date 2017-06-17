/**
 * Created by tuanh on 2/3/2017.
 */
var checkedItems = [];
$(function() {
    $('.list-group.checked-list-box .list-group-item').each(function () {

        // Settings
        var $widget = $(this),
            $checkbox = $('<input type="checkbox" class="hidden" />'),
            color = ($widget.data('color') ? $widget.data('color') : "primary"),
            style = ($widget.data('style') == "button" ? "btn-" : "list-group-item-"),
            settings = {
                on: {
                    icon: 'glyphicon glyphicon-check'
                },
                off: {
                    icon: 'glyphicon glyphicon-unchecked'
                }
            };

        $widget.css('cursor', 'pointer')
        $widget.append($checkbox);

        // Event Handlers
        $widget.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
        });
        $checkbox.on('change', function () {
            updateDisplay();
        });

        $("#search").click(function () {
            $checkbox.prop('checked', true);
            updateDisplay();
        });

        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');

            // Set the button's state
            $widget.data('state', (isChecked) ? "on" : "off");

            // Set the button's icon
            $widget.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$widget.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $widget.addClass(style + color + ' active');
            } else {
                $widget.removeClass(style + color + ' active');
            }
        }

        // Initialization
        function init() {

            if ($widget.data('checked') == true) {
                $checkbox.prop('checked', !$checkbox.is(':checked'));
            }

            updateDisplay();

            // Inject the icon if applicable
            if ($widget.find('.state-icon').length == 0) {
                $widget.prepend('<span class="state-icon ' + settings[$widget.data('state')].icon + '"></span>');
            }
        }
        init();
    });

    $('.check-list-box li a').on('click', function(event) {

        $(this).parent().toggleClass('active');
        
        event.preventDefault();
        
        var selectedArr = colArr = [];
        selectedArr['type_id'] = [];

        checkedItems = [], counter = 0;
        $('.checked_value').val('');
        $(".check-list-box li.active a").each(function(idx, li) {            
            var col = $(this).data('col');    
            var val = $(this).attr('value');
            var tmp = $('#' + col).val();
            $('#' + col).val(tmp + val  + ";");
        });        
       
        markerCluster.clearMarkers();
        markers = [];
        var markerFilter = [];              
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
                }                       
            });                 
            if(rs == true){                 
                markerFilter.push(markers_temp[i]);                     
            }
        }               
        if($(".check-list-box li.active a").length==0){
            markerFilter = [];
        }
        //return false;
        for (var i = 0; i < markerFilter.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(parseFloat(markerFilter[i].location.split(',')[0]), parseFloat(markerFilter[i].location.split(',')[1])),
                map: map,
                title: markerFilter[i].shop_name,
                data: markerFilter[i],
                icon: {
                    url: markerFilter[i].icon_url,
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
    });
});