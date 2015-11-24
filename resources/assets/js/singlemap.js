L.mapbox.accessToken = 'pk.eyJ1IjoibHVkby1hdXJnIiwiYSI6IjE0QzlVekkifQ.FK86sgWfTNbDC-Z-O-hTww';
var map = L.mapbox.map('singlemap').setView([45.2, 5.7], 16);
var osm = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        "subdomains": 'abc',
        "attribution": " &copy; OpenStreetMap"
    }
);
var ggl = new L.Google('SATELLITE');

var currenturl = location.href;
var domain = location.protocol + '//' + location.host;
var url = currenturl.replace(domain,domain + '/geojson');
osm.addTo(map);


var featureLayer = L.mapbox.featureLayer().loadURL(url).addTo(map);
featureLayer.on('ready', function() {
    map.fitBounds(featureLayer.getBounds());
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
});

map.addControl(new L.Control.Layers( {'OSM':osm, 'Google':ggl}, {}));