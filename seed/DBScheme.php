<?php

require_once __DIR__."/../dao/DBHandle.php";

require_once __DIR__."/../dao/VereinDAO.php";
require_once __DIR__."/../dao/MannschaftDAO.php";

require_once __DIR__."/../dao/spielbetrieb/MeisterschaftDAO.php";
require_once __DIR__."/../dao/spielbetrieb/LigaDAO.php";
require_once __DIR__."/../dao/spielbetrieb/MannschaftsMeldungDAO.php";
require_once __DIR__."/../dao/spielbetrieb/SpielDAO.php";

require_once __DIR__."/../dao/dienst/DienstDAO.php";

class DBScheme {
    private $dbHandle;

    public function __construct($dbHandle){
        $this->dbHandle = $dbHandle;
    }

    public function dropAllTables(): void {
        $this->drop("Dienst");

        $this->drop("Spiel");
        $this->drop("MannschaftsMeldung");
        $this->drop("Liga");
        $this->drop("Meisterschaft");

        $this->drop("Mannschaft");
        $this->drop("Verein");
    }

    private function drop($entityName): void {
        $daoName = $entityName."DAO";
        $sql = "DROP TABLE IF EXISTS ".$daoName::tableName($this->dbHandle);
        $this->dbHandle->query($sql);
    }

    public function seed(): void {
        $this->create("Verein");
        $this->create("Mannschaft");

        $this->create("Meisterschaft");
        $this->create("Liga");
        $this->create("MannschaftsMeldung");
        $this->create("Spiel");

        $this->create("Dienst");
    }

    private function create(string $entityName){
        $daoName = $entityName."DAO";
        $sql = $daoName::tableCreation($this->dbHandle);
        $this->dbHandle->query($sql);
    }

    public function needsSeeding(): bool {
        $vereinTableName = VereinDAO::tableName($this->dbHandle);
        $tableExists = $this->dbHandle->get_var("SELECT EXISTS (SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA='testdb' AND TABLE_NAME='$vereinTableName')");
        $seedingNeeded = !$tableExists;
        return $seedingNeeded;
    }
}

?>