<?php

/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */

require_once __DIR__ . "/../private/bootstrap.php";
if (Auth::isLoggedIn())
{
	redirect("/dashboard.php");
	exit(0);
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Kent Projects</title>
        <link rel="shortcut icon" href="/includes/img/kp.ico">
        <script src="/includes/js/landing.js" type="text/javascript"></script>
        <link href="/includes/css/lib/hint.css" rel="stylesheet">
        <link href="/includes/css/lib/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="/includes/css/lib/flat-ui-pro.min.css" rel="stylesheet">
        <link href="/includes/css/style.css" rel="stylesheet">
        <link href="/includes/css/landing.css" rel="stylesheet">
    </head>
    <body onload-"instaLoad()">
        <header class="translucent">
            <div class="container">
                <div class="row">
                    <div class="col-xs-7 col-sm-7 col-md-7 noRightPadding">
                        <h4 class="inlineHeading">Kent Projects</h4>
                    </div>
                    <div class="col-xs-5 col-sm-5 col-md-5 loginPosition noLeftPadding">
                        <a href="/login.php" class="btn btn-sm btn-info pull-right thinButton">Log in</a>
                        <a href="javascript:switchInfoVisibility();" id="btnAbout" class="btn btn-sm btn-info marginRight pull-right thinButton">About</a>
                    </div>
                </div>
            </div>
        </header>

        <div id="infoContainer" class="centeredDiv">
            <div id="infoCont" class="container centeredDiv roundedCorners translucent">
                <div id="divInfo" class="row text-center">
                    <h5 id="infoTitle">What is Kent Projects?</h5>
                    <p>
                        Welcome to Kent Projects, the new way to find a project for your final year.<br/>
                        We're building this portal to help you find the group to work in, and the right project to do.<br/>
                        Once you've agreed on a project with your supervisor we'll help you track your progress and submit your corpus at the end.
                    </p>
                </div>
            </div>
        </div>

        <footer class="fixedBottom translucent">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <p class="bigMargin softenText text-center"><b>&copy; 2014. James Dryden, Matt House, Matt Weeks</b></p>
                    </div>
                </div>
            </div>
        </footer>
        <div id="slideshowFront" class="slideshowDiv"></div>
        <div id="slideshowBack" class="slideshowDiv"></div>
    </body>
</html>
