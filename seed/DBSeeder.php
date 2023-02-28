<?php

require_once __DIR__."/../dao/DBHandle.php";
require_once __DIR__."/../dao/VereinDAO.php";

class DBSeeder {
    private $dbHandle;

    public function __construct($dbHandle){
        $this->dbHandle = $dbHandle;
    }

    public function seed(): void{
        $heimVerein = new Verein();
        $heimVerein->name = VEREIN_NAME;
        $heimVerein->heimVerein = true;
        $heimVerein->nuligaClubId = VEREIN_NULIGA_ID;

        $vereinDAO = new VereinDAO($this->dbHandle);
        $vereinDAO->insert($heimVerein);
    }

    public function needsSeeding(): bool {
        try {
            $vereinDAO = new VereinDAO($this->dbHandle);
            $heimVerein = $vereinDAO->getHeimVerein();
            return empty($heimVerein);
        } catch (mysqli_sql_exception){
            return true;
        }
    }
}
?>