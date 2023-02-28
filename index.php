<?php

if((include_once __DIR__.'/config.php') != TRUE){
    echo "Die config.php muss noch erstellt werden. Bitte sehen Sie dazu in die config-sample.php.";
    exit;
}

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