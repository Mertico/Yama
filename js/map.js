ymaps.ready(init);
var myMap;
function init () {
    myMap = new ymaps.Map('map', {
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

function OpenMark(ID) {
  var objectState = objectManager.getObjectState(ID);
  if (objectState.isClustered) {
      // Сделаем так, чтобы указанный объект был "выбран" в балуне.
      objectManager.clusters.state.set('activeObject', objectManager.objects.getById(ID));
      // Все сгенерированные кластеры имеют уникальные идентификаторы.
      // Этот идентификатор нужно передать в менеджер балуна, чтобы указать,
      // на каком кластере нужно показать балун.
      objectManager.clusters.balloon.open(objectState.cluster.id);
  } else {
      objectManager.objects.balloon.open(ID);
  }
}
