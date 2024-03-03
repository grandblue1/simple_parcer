<?php 


namespace Src\Migrations;


class MigrationRunner {
    protected $pdo;

    public function __construct(\PDO $pdo){
        $this->pdo = $pdo;
    }

    public function run(Migration $migration){
        try {

            $migration->up($this->pdo);

        }catch(\PDOException $ex){
            echo "Migrating up failed for some reason: ".$ex.' ';
            $migration->down($this->pdo);
        }

    }
    public function rollback(Migration $migration){
        try{
            $migration->down($this->pdo);
        }
        catch(\PDOException $ex){
            echo "Migration rollback for some reason: ".$ex.' ';
        }
    }
}