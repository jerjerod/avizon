L.mapbox.accessToken = 'pk.eyJ1IjoibHVkby1hdXJnIiwiYSI6IjE0QzlVekkifQ.FK86sgWfTNbDC-Z-O-hTww';

//url
var currenturl = location.href;
var domain = location.protocol + '//' + location.host;
var url = currenturl;



//Couches rasters
var osm = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        "subdomains": 'abc',
        "attribution": " &copy; OpenStreetMap"
    }
);
var irstea = L.tileLayer('http://195.221.110.240/mapcache/tms/1.0.0/osm@g/{z}/{x}/{y}.jpg',
        {
            tms:true,
            attribution: "Relief ©2015 IRSTEA OSM"
        }
);
var rm =L.tileLayer.wms('http://psql9.grenoble.cemagref.fr/cgi-bin/mapserv?map=/var/www/module_wms_wfs/projet_stations/wms_stations.map',
        {
            layers: 'enneigement_2006_2007,rm_alpes,dsa,alpine_pistes',
            version:'1.3.0',
            tiled: true,
            format: 'image/png',
            transparent: true,
            crs:L.CRS.EPSG900913,
            theme:'couche_wms',
            attribution: " remontées mécaniques © 2015 IRSTEA"
        }
);
var ggl = new L.Google('SATELLITE');
//Couche de données
var markers = new L.MarkerClusterGroup({
    animateAddingMarkers:true,
    disableClusteringAtZoom:18
});
var haveMarkers = {};


//couche quartiers prioritaires de la ville

var qpville = L.mapbox.featureLayer().loadURL('/js/geom/copropriete/qpville.geojson')
            .on('ready', function() {
                qpville.eachLayer(function(layer) {
                var content = '<h2>Quartier de la politique de la ville <\/h2>' +
                    '<p> Code: ' + layer.feature.properties.code + '<br \/>' +
                    'Nom: ' + layer.feature.properties.nom + '<\/p>';
                layer.bindPopup(content);
            });
    });


$.getJSON(url, function(data) {
    var geojson = L.geoJson(data, {
        onEachFeature: function (feature, layer) {
            markers.addLayer(layer);
            haveMarkers[L.Util.stamp(layer)] = true;
            layer.on('click', function (e) {
                $.getJSON(domain+'/copropriete/'+feature.properties.id, function(data) {
                    if (typeof data.meta.posi_marche !== 'undefined') {
                        if(data.meta.posi_marche > 0){
                            var color = 'text-success';
                        }else if(data.meta.posi_marche == 0){
                            var color = '';
                        }else{
                            var color = 'text-danger';
                        }
                        var marche = '<div class="col-xs-6">\
                                        <div><i class="fa fa-money fa-4x"></i></div> ' + data.meta.prix_marche + '€/m²\
                                    </div>\
                                    <div class="col-xs-6">\
                                        <div><i class="fa fa-line-chart fa-4x ' + color + '"></i></div> ' + data.meta.posi_marche + '% (iris)' + '\
                                    </div>';
                    }else{
                        var marche = '';
                    };
                    var adresse ='<ul>';
                    for (var i = 0; i < data.meta.adresse.length; i++) {
                        adresse += '<li>' + data.meta.adresse[i] + '</li>';
                    }; 
                    adresse +='</ul>';
                    var link = domain+'/copropriete/'+ data.url + '/' + data.post.slug;

                    var popupContent =  '<div class="row text-center">\
                                            <div class="col-xs-6">\
                                                <div><i class="fa fa-envelope fa-2x"></i></div>' + adresse +'\
                                            </div>\
                                            <div class="col-xs-6">\
                                                <div><i class="fa fa-institution fa-2x"></i></div>' + data.terms.commune.name + '\
                                            </div>\
                                        </div>\
                                        <div class="row text-center">\
                                            <div class="col-xs-6">\
                                                <div><i class="fa fa-wrench fa-2x"></i></div>' + data.meta.date_construction + '\
                                            </div>\
                                            <div class="col-xs-6">\
                                                <div><i class="fa fa-building fa-4x"></i></div>' + data.meta.nb_log + ' logement(s)\
                                            </div>\
                                        </div>\
                                        <div class="row text-center">\
                                            '+ marche +'\
                                        </div>\
                                        <div class="text-right"><a href="'+ link +'/polygon">En savoir plus...</a></div>';
                    layer.bindPopup(popupContent).openPopup();
                });
            });
        }
    });
    
    // CONSTRUCT THE MAP
    function menu(layer, name, zIndex) {
        layer.setZIndex(zIndex).addTo(map);
        // Create a simple layer switcher that toggles layers on
        // and off.
        var ui = document.getElementById('map-ui');
        var item = document.createElement('li');
        var link = document.createElement('a');
        link.href = '#';
        link.className = 'active';
        link.innerHTML = name;

        link.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (map.hasLayer(layer)) {
                map.removeLayer(layer);
                this.className = '';
            } else {
                map.addLayer(layer);
                this.className = 'active';
            }
        };
        item.appendChild(link);
        ui.appendChild(item);
    };
    $('.container-full .alert').show();
    $('.results').html($.map(haveMarkers, function(n, i) { return i; }).length + ' résultat(s) pour cette recherche');
    $('#loading').hide();
    var map = L.mapbox.map('map',{maxZoom: 18}).fitBounds(markers.getBounds());
    var output = document.getElementById('output');
    markers.addTo(map);
    menu(markers, 'Copropriétés', 1);
    menu(qpville, 'Quartiers de la politique de la ville', 2);
    // Initialize the geocoder control and add it to the map.
var geocoderControl = L.mapbox.geocoderControl('mapbox.places');
geocoderControl.addTo(map);

// Listen for the `found` result and display the first result
// in the output container. For all available events, see
// https://www.mapbox.com/mapbox.js/api/v2.1.8/l-mapbox-geocodercontrol/#section-geocodercontrol-on
geocoderControl.on('found', function(res) {
    output.innerHTML = JSON.stringify(res.results.features[0]);
});
    osm.addTo(map);
    map.addControl(new L.Control.Layers( {'OSM':osm, 'Google':ggl,'irstea':irstea}, {}));
   
});




















