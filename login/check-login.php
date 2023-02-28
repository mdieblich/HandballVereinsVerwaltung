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
}
?>
<!DOCTYPE html>
<html>
    <head>
        <link href="../assets/bootstrap.min.css" rel="stylesheet">

        <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
            font-size: 3.5rem;
            }
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        @media (min-width: 992px) {
            .rounded-lg-3 { border-radius: .3rem; }
        }
        </style>
    </head>
    <body onload="reduceCountDown()">
        <div class="px-4 py-5 my-5 text-center">
            <img class="d-block mx-auto mb-4" src="../assets/logo-hvv-error.svg" alt="" width="72" height="57">
            <h1 class="display-5 fw-bold">Passwort falsch</h1>
            <div class="col-lg-6 mx-auto">
                <p class="lead mb-4">Versuchen Sie es erneut.</p>
                <p class="lead mb-4">Wenn Sie das Passwort nicht mehr kennen, dann können Sie es über die config.php neu setzen.</p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <button type="button" class="btn btn-primary btn-lg px-4 gap-3" onclick="redirect()">Zur Anmeldeseite</button>
                </div>
                Weiterleitung in ... 
                <div class="progress" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 50%: text-align:center">
                    <div id="RedirectCountDown" class="progress-bar bg-secondary" style="width: 0%">3.0 s</div>
                </div>
            </div>
        </div>
        <script>
            redirectIn = 3000; // ms
            function reduceCountDown () {
                percentage = 100*(1-redirectIn/3000);
                document.getElementById('RedirectCountDown').style.width = percentage+"%";
                document.getElementById('RedirectCountDown').innerText = Math.floor(redirectIn/100)/10 + " s";

                redirectIn -= 100;
                if(redirectIn > 0){
                    setTimeout(reduceCountDown, 100);
                } else {
                    redirect();
                }
            }

            function redirect() {
                document.location.href = '.';
            }
        </script>
    </body>
</html>