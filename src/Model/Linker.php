<?php 

namespace Src\Model;

use  Src\Database\Database;
use PDO;

class Linker {
    private $db;
    private $price,$id,$link;

    public function __construct($link,$price) {
        $this->db = Database::getInstance()->getConnection();

        $this->link = $link;
        $this->price = $price;
    }

    public function addLink(){
        $stmt = $this->db->prepare("INSERT INTO linkers (link,price) VALUES (?,?)");

        if($stmt->execute([$this->link,$this->price])){
            $this->id = $this->db->lastInsertId();
            return $this->id;
        }else {
            return false;
        };
    }
    public function getIdByLink($link){
        $stmt = $this->db->prepare("SELECT id  FROM linkers WHERE link = ?");
        $stmt->execute([$link]);
        $result  = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if($result && $result['id']){
            return $result['id'];
        }
        return false;
    }
    public static function getAllLinks(){
        $links = [];

        $db = Database::getInstance();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT *  FROM linkers");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $link){
            $links[] = new Linker($link['link'],$link['price']);
        }
        return $links;
    }
    public function getPrice(){
        return $this->price;
    }
    public function getId(){
        return $this->id;
    }
    public function getLink(){
        return $this->link;
    }
    public function setPrice($price) {
        $this->price = $price;
        $stmt = $this->db->prepare("UPDATE linkers SET price = ? WHERE id = ?");
        $stmt->execute([$this->price, $this->getId()]);
    }
    public function update(){
        $stmt = $this->db->prepare("UPDATE linkers SET price = ? where id = ?");
        $stmt->execute([$this->price, $this->id]);
    }
}
