<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> <?php print $title ?> </title>
        <link rel="shortcut icon" href="/../includes/img/kp.ico">
        <script src="../includes/js/cheet.min.js"></script>
        <link href="../includes/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="../includes/css/flat-ui-pro.min.css" rel="stylesheet">
        <link href="../includes/css/style.css" rel="stylesheet">
    </head>
    <body>
        <header class="kentBlueBackground">
            <div class="container">
                <div class="row">
                    <div class="col-xs-7 col-sm-7 col-md-7 noRightPadding">
                        <a href="/dashboard.php"><h4 class="inlineHeading smallerMobileHeading whiteText"> Kent Projects </h4></a>
                    </div>
                    <div class="col-xs-5 col-sm-5 col-md-5 noLeftPadding alignRight">
                        <a href="/profile.php"><span class="fui-user smallerMobileHeading whiteText"></span></a>
                        <a href="/settings.php"><span class="fui-gear marginLeft10 smallerMobileHeading whiteText"></span></a>
                        <span class="fui-exit hoverHand marginLeft10 smallerMobileHeading whiteText" onclick="logoutUser()"></span>
                    </div>
                </div>
            </div>
        </header>
        <script>
            /**
             * No easter eggs here, no sir.
             */
            cheet('↑ ↑ ↓ ↓ ← → ← → b a', function () {
                alert('You get full marks, congratulations.');
            });
            cheet('d e c 4 b a l l s', function () {
                alert('He sure is!');
            });
            cheet('i d d q d', function () {
                alert('Supervisor mode enabled');
            });
            /**
             * Confirm the user wants to log out, if so logs the user out of the system.
             */
            function logoutUser() {
                if (confirm("Are you sure you want to log out?")) {
                    window.location.href = ("/logout.php");
                }
            }
        </script>
        <div id="pageContent">