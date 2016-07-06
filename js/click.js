//ymaps.ready(init_click);
var myMap;

function init_click () {
    myMap = new ymaps.Map("map_click", {
        center: [54.33, 48.43],
        zoom: 11,
		controls: []
    });
	
	myMap.controls.add('zoomControl', {
    size: "small"
	});
	
	myGeoObject = new ymaps.GeoObject({
        geometry: {
            type: "Point",
            coordinates: [54.33, 48.43]
        }
    }, {
        preset: 'islands#blackStretchyIcon',
        draggable: true
    });
	
    myMap.events.add('click', function (e) {
        var coords = e.get('coords');
		myMap.geoObjects.add(myGeoObject);
		myGeoObject.geometry.setCoordinates([coords[0].toPrecision(12),coords[1].toPrecision(12)]);
		document.getElementById('coords').value=[coords[0].toPrecision(12),coords[1].toPrecision(12)].join(', ')
    });
	
	myGeoObject.events.add('dragend', function(e) {
		   var thisPlacemark = e.get('target');
		   var coords = thisPlacemark.geometry.getCoordinates();
		   document.getElementById('coords').value=[coords[0].toPrecision(12),coords[1].toPrecision(12)].join(', ')
	});
}