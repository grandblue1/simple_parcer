<?php 

require_once 'vendor/autoload.php';
require_once 'src/Migrations/create_linker_table.php';
require_once 'src/Migrations/create_subscription_table.php';
use Src\Database\Database;
use Src\Migrations\MigrationRunner;
use Src\Migrations\LinkerTable;
use Src\Migrations\SubscriptionTable;

$pdo = Database::getInstance()->getConnection();

$migration = new MigrationRunner($pdo);

echo "Migrate Linker table... \n";
$migration->run(new LinkerTable());

echo "Migrate Subscription table... \n";
$migration->run(new SubscriptionTable());