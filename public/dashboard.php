<?php
require_once __DIR__."/../private/bootstrap.php";
if (!Auth::isLoggedIn())
{
	/**
	 * Everyday I'm error~ing.
	 */
	echo "You must be logged in to see this!";
	exit();
}

$user = Auth::getUser();

$projects = API::Request(API::GET, "/projects", array("fields" => "id,name,supervisor"));
$supervisors = API::Request(API::GET, "/supervisors");
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
                <h1> Dashboard </h1>
                <p> Start with this stuff... </p>
            </div>
        </div>
        <?php include 'includes/php/footer.php'; ?>
    </body>
</html>