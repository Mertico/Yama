<?
require_once 'database.php';


use PostgreSQL\Connection as Connection;

try {
    $connection = new Connection;
    //$json = $connection->AllMark();
    //$json = $connection->AddMark('54.3333743720, 48.3377276611', 'большая яма', 'ул. Розы Люксембург, 26');

} catch (PDOException $e) {
    echo $e->getMessage();
}
