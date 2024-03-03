<?php 


namespace Src\Migrations;

use PDO;

interface Migration
{
    public function up(PDO $pdo);
    public function down(PDO $pdo);
}