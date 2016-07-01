<?php
namespace PostgreSQL;

/**
 * Represent the Connection
 */
class Connection {

    /**
     * Connection
     * @var type
     */
    private static $conn;

    /**
     * Connect to the database and return an instance of \PDO object
     * @return \PDO
     * @throws \Exception
     */
    function __construct() {}
    public function connect() {

        // read parameters in the ini configuration file
        $params = parse_ini_file('database.ini');
        if ($params === false) {
            throw new Exception("Error reading database configuration file");
        }
        // connect to the postgresql database
        $conStr = sprintf("pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
                $params['host'],
                $params['port'],
                $params['database'],
                $params['user'],
                $params['password']);

        $pdo = new \PDO($conStr);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }
    public function AllMark()
    {
      $connection = $this->get()->connect();
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
               "features" => []];
      $res->setFetchMode(\PDO::FETCH_NUM);
      while ($row = $res->fetch())
      {
          $temp["type"] = "Feature";
          $temp["id"] = $row[0];
          $temp["geometry"]["type"] = "Point";
          $temp["geometry"]["coordinates"] = [(double)$row[3], (double)$row[4]];

          $temp["properties"]["balloonContent"] = 'Дата добавления: '.date('m.d.Y H:i:s', strtotime($row[2])).' <br />'.$row[5]."<br /> Фото: <br /><img height='100%' width='100%' src='foto.jpg'>";
          $temp["properties"]["clusterCaption"] = '№'.$row[0];
          $temp["properties"]["hintContent"] = 'Яма №'.$row[0];
          $json['features'][] = $temp;
      }
      $json = json_encode($json, JSON_UNESCAPED_UNICODE);
      return $json;
    }

    public function AddMark($cords, $about, $address)
    {
      if($cords != '') {
        $data['cords'] = explode(', ', $cords);
      } else {
        $json = 'https://geocode-maps.yandex.ru/1.x/?format=json&geocode=Ульяновск, '.$address;
        $json = json_decode(file_get_contents($json));
        $data['cords'] = explode(' ', $address->response->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos);
      }
      $data['about']=$about;
      $connection = $this->get()->connect();
      $query = 'INSERT INTO "yama"."pits" ("Address","X","Y","About") '.
            'VALUES (\''.$address.'\', '.(double)$data['cords'][0].' ,'.(double)$data['cords'][1].', \'Большая яма!\');';
      echo $query;
      $connection->query($query);
      $id = $db->lastInsertId('pit_ID_seq');
      require_once 'upload.php';
      return $data;
    }

    public function LastMark()
    {
      $connection = $this->get()->connect();
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
        pits."ID" DESC LIMIT 4';
      $res = $connection->query($query);
      $res->setFetchMode(\PDO::FETCH_NUM);
      while ($row = $res->fetch()) {
        #... вывод последних 4 ям
        # ABOUT, ID
      }

    }
    /**
     * return an instance of the Connection object
     * @return type
     */
    public static function get() {
        if (null === static::$conn) {
            static::$conn = new static();
        }
        return static::$conn;
    }
    private function __clone() {}
    private function __wakeup() {}
}
