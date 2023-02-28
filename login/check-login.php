<?php
if((include_once __DIR__.'/../config.php') != TRUE){
    echo "Die config.php muss noch erstellt werden. Bitte sehen Sie dazu in die config-sample.php.";
    exit;
}
if(!isset($_POST['password'])){
    header("Location: .");
    die();
}
if(password_verify($_POST['password'], ADMIN_PASSWORD_HASH)){
    session_start();
    $_SESSION['logged_in'] = true;
    header("Location: .");
    die();
} else {
    echo "Passwort falsch";
}
?>