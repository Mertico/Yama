<?
require_once 'database.php';


use PostgreSQL\Connection as Connection;

try {
    $connection = new Connection;
    $connection = $connection->get()->connect();

    $query = 'SELECT
      pits."ID",
      pits."Address",
      pits."Time_Create",
      pits."X",
      pits."Y",
      pits."About"
    FROM
      yama.pits
    WHERE
      pits."ID" > 0
    ORDER BY
      pits."ID" ASC';

/*
      {
          "type": "FeatureCollection",
          "features": [
              {"type": "Feature",
                "id": 0,
                "geometry": {
                  "type": "Point",
                  "coordinates": [55.831903, 37.411961]
                },
                "properties": {
                  "balloonContent": "Содержимое балуна",
                  "clusterCaption": "Еще одна метка",
                  "hintContent": "Текст подсказки"}
                },
      };/*

    $res = $connection->query($query);
    $json = ["draw" => 1,
             "recordsTotal" => 0,
             "recordsFiltered" => 0,
             "data" => []
            ];
    $res->setFetchMode(PDO::FETCH_NUM);
    while ($row = $res->fetch())
    {
        $json['recordsFiltered']++;
        $row[2] = date('m.d.Y H:i:s', strtotime($row[2]));
        $json['data'][] = $row;

    }
    $json['recordsTotal'] = $connection->query('SELECT count(pits."ID") FROM yama.pits')->fetch()[0];
    $json = json_encode($json, JSON_UNESCAPED_UNICODE);


   echo $json;

} catch (PDOException $e) {
    echo $e->getMessage();
}
