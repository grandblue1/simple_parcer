<?php

namespace Src\Migrations;

use PDO;

class LinkerTable implements Migration
{
    public function up(PDO $pdo)
    {
        $stmt = $pdo->prepare("
            CREATE TABLE IF NOT EXISTS linkers (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                link TEXT NOT NULL,
                price DECIMAL(10,2), 
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
        $stmt->execute();
    }

    public function down(PDO $pdo)
    {
        $stmt = $pdo->prepare("DROP TABLE IF EXISTS linkers");
        $stmt->execute();
    }
}
