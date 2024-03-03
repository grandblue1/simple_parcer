<?php
namespace Src\Database;
require_once __DIR__.'/../database_config.php';
use PDO;

class Database {
    private static $instance;
    private $connection;

    private function __construct(){
        $db = getConfig();
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_TIMEOUT            => 5,
        ];

        $this->connection = new PDO('mysql:host='.$db['host'].';dbname='.$db['dbname'].'', $db['user'], $db['password'],$options);
    }

    public static function getInstance(){
        if(!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(){
        return $this->connection;
    }
}
