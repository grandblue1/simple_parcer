<?php 

namespace Src\Model;

use  Src\Database\Database;
use PDO;

class Subscription {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function subscribe($email,$linkerID){
        $stmt = $this->db->prepare("INSERT INTO subscriptions (email,linker_id) VALUES (?,?)");
        $stmt->execute([$email,$linkerID]);
    }

    public static function getSubscriptionByLinkerID($linkerID){
        $db = Database::getInstance();
        $conn = $db->getConnection();
        
        $subs = $conn->prepare("SELECT * FROM subscriptions WHERE linker_id = ?");
        $subs->execute(array($linkerID));

        return $subs->fetchAll(PDO::FETCH_ASSOC);
    }

}