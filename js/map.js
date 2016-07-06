ymaps.ready(init);

function init () {
    var myMap = new ymaps.Map('map', {
            center: [54.3375, 48.43],
            zoom: 13,
			controls: []
        }, {
            searchControlProvider: 'yandex#search'
        }),
        objectManager = new ymaps.ObjectManager({
            // Чтобы метки начали кластеризоваться, выставляем опцию.
            clusterize: true,
            // ObjectManager принимает те же опции, что и кластеризатор.
            gridSize: 32
        });
	  myMap.behaviors.disable('scrollZoom');
    myMap.controls.add('zoomControl', {
    size: "large"
	  });
    // Чтобы задать опции одиночным объектам и кластерам,
    // обратимся к дочерним коллекциям ObjectManager.
    objectManager.objects.options.set('preset', 'islands#greenDotIcon');
    objectManager.clusters.options.set('preset', 'islands#greenClusterIcons');
    myMap.geoObjects.add(objectManager);

    $.ajax({
        url: "http://yama/AllMark.php"
    }).done(function(data) {
        objectManager.add(data);
    });

}
