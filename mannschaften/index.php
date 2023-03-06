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
    <style>
        .haelfte {
            display: inline-block;
            width: 45%;
            background-color: #fbb;
        }
        .mannschaft {
            display: inline-block;
            position: relative;
            height: 125px;
            width: 125px;
            border: 3px dotted silver;
            border-radius: 10px;
            margin: 10px;
            font-size: 2em;
            color: silver;
            box-shadow:  0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        .mannschaft:hover {
            width: 131px;
            height: 131px;
            border: 3px solid silver;
            margin: 7px;
            font-size: 2.2em;
            box-shadow:  0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 7px 22px 0 rgba(0, 0, 0, 0.19);
            cursor: pointer;
        }
        .mannschafts-kuerzel {
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }
    </style>
    <title>Mannschaften</title>
  </head>
  <body>
    <h1>Container</h1>

    <div class="haelfte">
        <div class="mannschaft">
            <div class="mannschafts-kuerzel">
                D1
            </div>
        </div>
        <div class="mannschaft">
            <div class="mannschafts-kuerzel">
                D2
            </div>
        </div>
        <div class="mannschaft">
            <div class="mannschafts-kuerzel">
                D3
            </div>
        </div>
    </div>
    <div class="haelfte">
        <div class="mannschaft">
            <div class="mannschafts-kuerzel">
                H1
            </div>
        </div>
        <div class="mannschaft">
            <div class="mannschafts-kuerzel">
                H2
            </div>
        </div>
        <div class="mannschaft">
            <div class="mannschafts-kuerzel">
                H3
            </div>
        </div>
    </div>


    <script src="../assets/bootstrap.bundle.min.js"></script>
  </body>
</html>
