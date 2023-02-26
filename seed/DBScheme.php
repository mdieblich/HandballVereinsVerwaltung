<?php

require_once __DIR__."/../dao/VereinDAO.php";

class DBScheme {
    private $dbhandle;

    public function __construct($dbhandle){
        $this->dbhandle = $dbhandle;
    }

    public function drop(): void {
        $sql = "DROP TABLE IF EXISTS ".VereinDAO::table_name($this->dbhandle);
        $this->dbhandle->query($sql);
    }
    public function seed(): void {
        $sql = VereinDAO::tableCreation($this->dbhandle);
        $this->dbhandle->query($sql);
    }
}

?>