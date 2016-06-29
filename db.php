<?

class Database {
    public $db;

    private static $db_host = 'localhost';
    private static $db_port = 5432;
    private static $db_name = '';
    private static $db_login = 'pastgres';
    private static $db_pass = '';
    private static $db_charset = 'SET NAMES utf8';

    static private $instance;

    public static function getInstance()
    {
        if(empty(self::$instance))
            self::$instance = new PDO('pgsql:host='.self::$db_host.';dbname='.self::$db_name, self::$db_login, self::$db_pass,
                              				array(
                              				PDO::MYSQL_ATTR_INIT_COMMAND => self::$db_charset,
                              				PDO::ATTR_PERSISTENT => false,
                              				PDO::ERRMODE_WARNING => true,
                              				PDO::ATTR_ERRMODE => true
                                    ));

        return self::$instance;
    }

    private function __construct() {}

    private function __clone(){}
}


$new = new PDO('pgsql:host='.self::$db_host.';dbname='.self::$db_name, self::$db_login, self::$db_pass,
                          array(
                          PDO::MYSQL_ATTR_INIT_COMMAND => self::$db_charset,
                          PDO::ATTR_PERSISTENT => false,
                          PDO::ERRMODE_WARNING => true,
                          PDO::ATTR_ERRMODE => true
                        )) or die('Fail');

//$obj = new Database('localhost','yama','postgres');
//echo $obj->getInstance();
