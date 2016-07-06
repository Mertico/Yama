<?
require_once 'database.php';


use PostgreSQL\Connection as Connection;

try {
    $connection = new Connection;
    echo $connection->AllMark();

} catch (PDOException $e) {
    echo $e->getMessage();
}
