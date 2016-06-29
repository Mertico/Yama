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

        $stmt = $pdo->query('SELECT now()');
        while ($row = $stmt->fetch())
        {
            var_dump($row) . "\n";
        }

        return $pdo;
    }
    public function Query($query) {
      //return query($query)->fetchAll(\PDO::FETCH_COLUMN);
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
