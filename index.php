<?
require_once 'database.php';


use PostgreSQL\Connection as Connection;

try {
    $connection = new Connection;
    $json = $connection->AllMark();
    /*
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

    $res = $connection->query($query);
    $json = ["type" => "FeatureCollection",
             "features" => []
            ];
    $res->setFetchMode(PDO::FETCH_NUM);
    while ($row = $res->fetch())
    {
        $temp["type"] = "Feature";
        $temp["id"] = $row[0];
        $temp["geometry"]["type"] = "Point";
        $temp["geometry"]["coordinates"] = [(double)$row[3], (double)$row[4]];

        $temp["properties"]["balloonContent"] = $row[5];
        $temp["properties"]["clusterCaption"] = '№'.$row[0];
        $temp["properties"]["hintContent"] = 'Яма №'.$row[0];
        $json['features'][] = $temp;

        //$row[2] = date('m.d.Y H:i:s', strtotime($row[2]));
    }
    $json = json_encode($json, JSON_UNESCAPED_UNICODE);
    */
   var_dump($json);

} catch (PDOException $e) {
    echo $e->getMessage();
}
