<?php

if((include_once __DIR__.'/../config.php') != TRUE){
    echo "Die config.php muss noch erstellt werden. Bitte sehen Sie dazu in die config-sample.php.";
    exit;
}

session_start();
if(!isset($_SESSION['logged_in'])){
    // need to login
    header("Location: ../login");
    die();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../assets/bootstrap.min.css" rel="stylesheet">
    <title>Mannschaften</title>
  </head>
  <body>
    <h1>Container</h1>
    <div class="container mt-3 md-3">
        <div class="row">
            <div class="col">
                <div class="card shadow-lg text-center">
                    <div class="card-header">
                        <h5 class="card-title">Senioren</h5>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="card shadow text-center">
                                        <div class="card-header">
                                            <h5 class="card-title">Damen</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="card shadow-sm text-center">
                                                            1. Damen
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="card shadow-sm text-center">
                                                            2. Damen
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="card shadow-sm text-center">
                                                            3. Damen
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card shadow text-center">
                                        <div class="card-header">
                                            <h5 class="card-title">Herren</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="card shadow-sm text-center">
                                                            1. Herren
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="card shadow-sm text-center">
                                                            2. Herren
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="card shadow-sm text-center">
                                                            3. Herren
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-lg text-center">
                    <div class="card-header">
                        <h5 class="card-title">Jugend</h5>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                            <div class="col">
                                    <div class="card shadow text-center">
                                        <div class="card-header">
                                            <h5 class="card-title">Mädchen</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="card shadow-sm text-center">
                                                            wA1
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="card shadow-sm text-center">
                                                            wB1
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="card shadow-sm text-center">
                                                            wB2
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card shadow text-center">
                                        <div class="card-header">
                                            <h5 class="card-title">Jungen</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="card shadow-sm text-center">
                                                            mA1
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="card shadow-sm text-center">
                                                            mA2
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="card shadow-sm text-center">
                                                            mB1
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/bootstrap.bundle.min.js"></script>
  </body>
</html>
