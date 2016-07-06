<?
require_once 'database.php';


use PostgreSQL\Connection as Connection;

try {
    header("Location: /");
    $connection = new Connection;
    $json = $connection->AddMark($_POST['coords'], $_POST['about'], $_POST['address']);

    //var_dump($_POST,$_FILES);

} catch (PDOException $e) {
    echo $e->getMessage();
}
