var google;
var geocoder;
var map;
var marker;
var eventMarker;

var mapObj = {
    
    mapElement: null,
    latElement: null,
    lngElement: null,
    
    initialize: function (mapElement, latElement, lngElement) {
        
        mapObj.latElement = latElement;
        mapObj.lngElement = lngElement;
      
        geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng($('#' + mapObj.latElement).val(), $('#' + mapObj.lngElement).val());
        var mapOptions = {
          zoom: 8,
          center: latlng
        };
        map = new google.maps.Map(document.getElementById(mapElement), mapOptions);
        marker = new google.maps.Marker({
          map: map,
          position: new google.maps.LatLng($('#' + mapObj.latElement).val(), $('#' + mapObj.lngElement).val())
        });

        $('#' + mapObj.latElement).val($('#' + mapObj.latElement).val());
        $('#' + mapObj.lngElement).val($('#' + mapObj.lngElement).val());
        
    },
    codeAddress: function (addressElement) {
        
        var address = document.getElementById(addressElement).value;
        geocoder.geocode( { 'address': address}, function(results, status) {
            
          if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            marker.setMap(map);
            marker.setPosition(results[0].geometry.location);

            $('#' + mapObj.latElement).val(results[0].geometry.location.lat());
            $('#' + mapObj.lngElement).val(results[0].geometry.location.lng());

          } else {
            alert("Geocode was not successful for the following reason: " + status);
          }
          
        });
        
    },
    placeMarker: function(lat, lng) {
      
        eventMarker = new google.maps.Marker({
          map: map,
          position: new google.maps.LatLng(lat, lng)
        });
        eventMarker.setMap(map);
        
    },
    showOnMap: function(lat, lng) {
        
        map.setCenter(new google.maps.LatLng(lat, lng), 8);
        marker.setMap(map);
        marker.setPosition(new google.maps.LatLng(lat, lng));
        
    },
    
    getLocation: function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                mapObj.setLocation(position);
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    },
    setLocation: function(position) {
        
         $('#'+mapObj.latElement).val(position.coords.latitude);
         $('#'+mapObj.lngElement).val(position.coords.longitude);
         
         mapObj.showOnMap(position.coords.latitude, position.coords.longitude);
    } 
}