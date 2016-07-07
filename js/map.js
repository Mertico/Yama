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


      myMap.events.add('click', function (e) {
          var coords = e.get('coords');
      var xhr = new XMLHttpRequest();
      xhr.open('GET', 'https://geocode-maps.yandex.ru/1.x/?format=json&sco=latlong&geocode='+[coords[0].toPrecision(12),coords[1].toPrecision(12)].join(','), false);
      xhr.send();
      var json_geo = JSON.parse(xhr.responseText);

      myMap.balloon.open(coords, {
                      contentHeader:'Добавление ямы',
                      contentBody:
                          '<form action="AddMark.php1" method="post" enctype="multipart/form-data">' +
                            '<input type="hidden" value="'+json_geo.response.GeoObjectCollection.featureMember[0].GeoObject['name']+'" class="add_adress-textbox" id="add_adress-textbox" name="address">' +
                            '<textarea style="width: auto;" cols="48" rows="8" placeholder="Описание" name="about" required></textarea>' +
                            '<div class="file_upload">' +
                                '<button type="button">Открыть</button>' +
                                '<div>Выберите картинку</div>' +
                                '<input type="file" name="image_field" size="32" required>' +
                            '</div>' +
                            '<input type="hidden" value="'+[coords[0].toPrecision(12),coords[1].toPrecision(12)].join(', ')+'" id="coords" name="coords">' +
                            '<input type="submit" value="Добавить" class="add-button">' +
                          '</form><br />',
                      contentFooter:'<sup>Если ошиблись щелкните еще раз</sup>'
                  });
      });

}

function OpenMark(ID) {

  myMap.setCenter([objectManager.objects.getById(ID)['geometry'].coordinates[0],objectManager.objects.getById(ID)['geometry'].coordinates[1]+0.025]);
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
/*
  );*/
  //console.log(objectManager.objects.getById(ID)['geometry'].coordinates);
}
