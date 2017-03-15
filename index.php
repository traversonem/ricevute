<?php
require_once('lib/rb.php');

setlocale(LC_ALL, "it_IT");
date_default_timezone_set('Europe/Rome');

R::setup('mysql:host=127.0.0.1;dbname=es2', 'c06', 'pwd');
R::freeze(FALSE);

$pg = (empty($_REQUEST['p'])) ? 'home' : $_REQUEST['p'];
$pg = 'pgs/' . $pg . '.php';
?>
<!doctype html>
<html lang="it">
    <head>
        <title>Ricevute</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    </head>
    <body>
        <div id="all" class="all">
            <?php if (file_exists($pg)) include_once($pg); ?>
        </div>
        <script
            src="https://code.jquery.com/jquery-3.1.1.min.js"
            integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
        crossorigin="anonymous"></script>
        <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
    </body>
</html>
