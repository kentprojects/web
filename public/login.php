<?php
require_once __DIR__."/../private/bootstrap.php";

/**
 * If the user is already logged in, then redirect to the Dashboard.
 */
if (Auth::isLoggedIn())
{
	redirect("/dashboard.php");
	exit();
}

/**
 * The REAL Kent SSO will automatically redirect at this point.
 * But we have our fake system. So there's that.
 */

if (!empty($_GET["success"]))
{
	Auth::confirm($_GET["success"]);
	/**
	 * Error handling needs to be better. Much better.
	 */
	echo "No user found. Please try again.";
	exit();
}

if (!empty($_GET["auth"]))
{
	Auth::redirect($_GET["auth"]);
	exit();
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> Kent Projects Login </title>
        <link rel="shortcut icon" href="/includes/img/kp.ico">
        <link href="/includes/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="/includes/css/flat-ui-pro.min.css" rel="stylesheet">
        <link href="/includes/css/style.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <h1 class="text-center"> Log in to Kent Projects! </h1>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4 big-margin">
                    <a href="?auth=f4dfeada0e91e1791a80da1bb26a7d96" class="btn btn-block btn-md btn-primary center-item restricted-width"> Log in as Convenor </a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 big-margin">
                    <a href="?auth=1e9a755d73865da9068f079d81402ce7" class="btn btn-block btn-md btn-primary center-item restricted-width"> Log in as Supervisor 1 </a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 big-margin">
                    <a href="?auth=6f2653c2a1c64220e3d2a713cc52b438" class="btn btn-block btn-md btn-primary center-item restricted-width"> Log in as Supervisor 2 </a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 big-margin">
                    <a href="?auth=1f18ed87771daf095e090916cb9423e4" class="btn btn-block btn-md btn-primary center-item restricted-width"> Log in as Student 1 </a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 big-margin">
                    <a href="?auth=1460357d62390ab9b3b33fa1a0618a8f" class="btn btn-block btn-md btn-primary center-item restricted-width"> Log in as Student 2 </a>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 big-margin">
                    <a href="?auth=930144ea545ce754789b15074106bc36" class="btn btn-block btn-md btn-primary center-item restricted-width"> Log in as Student 3 </a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4 big-margin center-in-row center-item">
                    <a href="/" class="btn btn-block btn-md btn-danger center-item restricted-width"> Back to landing page </a>
                </div>
            </div>
            <footer class="row">
                <hr/>
                <p class="big-margin soften-text text-center"> &copy; 2014. James Dryden, Matt House, Matt Weeks </p>
            </footer>
        </div>
    </body>
</html>