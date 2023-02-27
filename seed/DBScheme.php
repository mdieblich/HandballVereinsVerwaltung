<?php

require_once __DIR__."/../dao/DBHandle.php";
require_once __DIR__."/../dao/VereinDAO.php";

class DBScheme {
    private $dbHandle;

    public function __construct($dbHandle){
        $this->dbHandle = $dbHandle;
    }

    public function drop(): void {
        $sql = "DROP TABLE IF EXISTS ".VereinDAO::tableName($this->dbHandle);
        $this->dbHandle->query($sql);
    }

    public function seed(): void {
        $sql = VereinDAO::tableCreation($this->dbHandle);
        $this->dbHandle->query($sql);
    }
}

?>