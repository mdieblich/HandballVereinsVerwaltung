<?php

if((include_once __DIR__.'/config.php') != TRUE){
    echo "Die config.php muss noch erstellt werden. Bitte sehen Sie dazu in die config-sample.php.";
    exit;
}
session_start();
if(!isset($_SESSION['logged_in'])){
    // need to login
    echo "Login benötigt";
    exit;
}
echo "Eingeloggt";

require_once __DIR__."/dao/DBhandle.php";
require_once __DIR__."/seed/DBSeeder.php";
require_once __DIR__."/seed/DBScheme.php";

$dbHandle = DBHandle::createFromConfig();
$dbSeeder = new DBSeeder($dbHandle);
if($dbSeeder->needsSeeding()){
    $dbScheme = new DBScheme($dbHandle);
    if($dbScheme->needsSeeding()){
        echo "Schema wird initialisiert<br>\n";
        $dbScheme->seed();
    }
    echo "Datenbankinhalt wird initialisiert<br>\n";
    $dbSeeder->seed();
}
?>