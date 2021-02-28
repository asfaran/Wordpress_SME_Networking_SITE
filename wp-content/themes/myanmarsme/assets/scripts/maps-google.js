var MapsGoogle = function () {

    
    var mapMarker = function () {
		var mapProp = {
				center:new google.maps.LatLng(22.262693, 114.130119), // <- Your LatLng
				zoom:18,
				mapTypeId:google.maps.MapTypeId.ROADMAP
			};
        var map = new google.maps.Map(document.getElementById("gmap_marker"),mapProp);
		
        /*map.addMarker({
            lat: -12.043333,
            lng: -77.03,
            title: 'Lima',
            details: {
                database_id: 42,
                author: 'HPNeo'
            },
            click: function (e) {
                if (console.log) console.log(e);
                alert('You clicked in this marker');
            }
        });
        map.addMarker({
            lat: -12.042,
            lng: -77.028333,
            title: 'Marker with InfoWindow',
            infoWindow: {
                content: '<span style="color:#000">HTML Content!</span>'
            }
        });*/
    }

    
   

    return {
        //main function to initiate map samples
        init: function () {
           // mapBasic();
            mapMarker();
           
        }

    };

}();