<?
require_once 'database.php';


use PostgreSQL\Connection as Connection;

try {
    $connection = new Connection;
    $array = $connection->LastMark();

} catch (PDOException $e) {
    echo $e->getMessage();
}
