<?php
$prerequisites = array("authentication");
require_once __DIR__."/../private/bootstrap.php";

$user = Auth::getUser();
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> Template </title>
        <link rel="shortcut icon" href="/includes/img/kp.ico">
        <link href="/includes/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="/includes/css/flat-ui-pro.min.css" rel="stylesheet">
        <link href="/includes/css/style.css" rel="stylesheet">
    </head>
    <body>
        <?php include 'includes/php/header.php'; ?>
        <div class="container">
            <div class="row">
                <h1> Profile </h1>
                <p> This be your profile page, <?php echo $user->first_name;?> </p>
            </div>
        </div>
        <?php include 'includes/php/footer.php'; ?>
    </body>
</html>