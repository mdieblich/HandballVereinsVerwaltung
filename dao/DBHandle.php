<?php

class DBHandle{

    private $mysqli;
    public string $prefix;

    public function __construct($databaseHost, $databaseUsername, $databasePassword, $databaseName){
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->mysqli = new mysqli($databaseHost, $databaseUsername, $databasePassword, $databaseName);
    }

    public function query(string $sql): bool {
        $result = $this->mysqli->query($sql);
        return $result !== false;
    }

    public function get_var($sql){
        $result = $this->mysqli->query($sql);
        $returned_row = $result->fetch_row();
        return $returned_row[0];
    }

    public function get_row_as_array($sql){
        $result = $this->mysqli->query($sql);
        return $result->fetch_assoc();
    }

    public function get_results_as_array($sql){
        $result = $this->mysqli->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function insert(string $table_name, array $assoc_array){
        
        // TODO SQL befüllen
        $sql = "INSERT INTO $table_name ($fieldNames) VALUES ($values)";
        
    }
}

?>