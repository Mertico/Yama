<?
require_once 'database.php';


use PostgreSQL\Connection as Connection;

try {
    $connection = new Connection;
    $connection = $connection->get()->connect();
    echo 'A connection to the PostgreSQL database sever has been established successfully.';

    /*
    $connection->query('SELECT Address FROM pits');
    while ($row = $stmt->fetch())
    {
        echo $row['Address'] . "\n";
    }*/

} catch (PDOException $e) {
    echo $e->getMessage();
}
