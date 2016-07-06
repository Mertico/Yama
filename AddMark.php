<?
require_once 'database.php';


use PostgreSQL\Connection as Connection;

try {
    $connection = new Connection;
    $json = $connection->AddMark($_POST['coords'], $_POST['about'], $_POST['address']);

} catch (PDOException $e) {
    echo $e->getMessage();
}
