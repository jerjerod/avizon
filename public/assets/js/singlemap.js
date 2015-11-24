L.mapbox.accessToken = 'pk.eyJ1IjoibHVkby1hdXJnIiwiYSI6IjE0QzlVekkifQ.FK86sgWfTNbDC-Z-O-hTww';
var osm = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        "subdomains": 'abc',
        "attribution": " &copy; OpenStreetMap"
    }
);
var ggl = new L.Google('SATELLITE');
var url = location.href;

$.post( url, function( data ) {
	var featureLayer = L.mapbox.featureLayer(data);
	var map = L.mapbox.map('singlemap').fitBounds(featureLayer.getBounds());
	var coords = featureLayer.getBounds().getCenter();
    var position = new google.maps.LatLng(coords.lat,coords.lng);
	var panoramaOptions = {
	    position: position,
	    pov: {
	      heading: 34,
	      pitch: 10
	    }
	  };
 	var panorama = new  google.maps.StreetViewPanorama(document.getElementById('pano'),panoramaOptions);
	featureLayer.addTo(map);
	osm.addTo(map);
	map.addControl(new L.Control.Layers( {'OSM':osm, 'Google':ggl}, {}));
},'json');
