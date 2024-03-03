<?php

namespace Src\Migrations;

use PDO;

class SubscriptionTable  implements Migration
{
    public function up(PDO $pdo)
    {
        $stmt = $pdo->prepare("
            CREATE TABLE IF NOT EXISTS subscriptions (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) NOT NULL,
                linker_id INT UNSIGNED,
                FOREIGN KEY (linker_id) REFERENCES linkers(id) ON DELETE CASCADE ON UPDATE CASCADE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
        $stmt->execute();
    }

    public function down(PDO $pdo)
    {
        $stmt = $pdo->prepare("DROP TABLE IF EXISTS subscriptions");
        $stmt->execute();
    }
}
