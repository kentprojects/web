<?php
$includeDropZoneJs = !empty($includeDropZoneJs);
$title = empty($title) ? "KentProjects" : $title;
?>
<!DOCTYPE html>
<html lang="en">
<!--

    Hey there! We'd love you to have a poke around in our source code - it was our final year project and I'm sure
    we've made some mistakes! If you notice anything dodgy please let the current convenor for the module know.

    **ONE IMPORTANT THING TO NOTE, HOWEVER**
    As you will undoubtedly notice, this site is mostly written in JS (on the front-end), and therefore can be mucked
    about with in your browser. We've built this site like an app, communicating with the back-end via an API and you
    shouldn't, therefore, be able to do anything without the appropriate permissions, even if you can expose the
    functionality in the UI.

    Just a little FYI.

    We're sure you wouldn't even try that.

	If you do, however, and find that you can, it'd be awesome if you'd let the powers that be know about it. :)


    <3 JD, MH & MW.

-->

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<title> <?php print $title ?> </title>
	<link rel="shortcut icon" href="/../includes/img/kp.ico">
	<script src="/includes/js/lib/cheet.min.js"></script>
	<script src="/includes/js/dynamicCSS.js"></script>
	<!-- Bootstrap -->
	<link href="/includes/css/lib/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- Flat UI -->
	<link href="/includes/css/lib/flat-ui-pro.min.css" rel="stylesheet">
	<!-- Hint.css -->
	<link href="/includes/css/lib/hint.min.css" rel="stylesheet">
	<!-- jQuery -->
	<script src="/includes/js/lib/jquery-1.11.2.min.js" type="text/javascript"></script>

	<?php if ($includeDropZoneJs)
	{ ?>
		<link href="/includes/css/lib/dropzone.min.css" rel="stylesheet" type="text/css" />
		<script src="/includes/js/lib/dropzone.min.js" type="text/javascript"></script>
	<?php } ?>

	<!-- Our Styles -->
	<link href="/includes/css/style.css" rel="stylesheet">
	<!-- Our Scripts -->
	<script src="/includes/js/snippets.js" type="text/javascript"></script>
	<script>
		var $buoop = {
			vs: {c: 2},   // browser versions to notify
			reminder: 0,                   // atfer how many hours should the message reappear
			// 0 = show all the time
			reminderClosed: 1,             // if the user closes message it reappears after x hours
			onshow: function (infos) {
			},      // callback function after the bar has appeared
			onclick: function (infos) {
			},     // callback function if bar was clicked
			onclose: function (infos) {
			},     //

			l: false,                       // set a language for the message, e.g. "en"
											// overrides the default detection
			test: false,                    // true = always show the bar (for testing)
			text: "Your browser is outdated, and this site may not work as expected. Click here to learn more.", // custom notification html text
			text_xx: "",                    // custom notification text for language "xx"
											// e.g. text_de for german and text_it for italian
			newwindow: true                 // open link in new window/tab
		};

		function $buo_f() {
			var e = document.createElement("script");
			e.src = "//browser-update.org/update.js";
			document.body.appendChild(e);
		}
		;
		try {
			document.addEventListener("DOMContentLoaded", $buo_f, false)
		}
		catch (e) {
			window.attachEvent("onload", $buo_f)
		}
	</script>

</head>
<body>
<header class="kentBlueBackground">
	<div class="container">
		<div class="row">
			<div class="col-xs-7 col-sm-7 col-md-7 noRightPadding">
				<a href="/dashboard.php"><h4 class="inlineHeading smallerMobileHeading whiteText"> Kent Projects </h4>
				</a>
			</div>
			<div class="col-xs-5 col-sm-5 col-md-5 noLeftPadding text-right">
				<a href="/profile.php?shortcut=myProfile"><span class="fui-user smallerMobileHeading whiteText"></span></a>
				<a href="/settings.php"><span class="fui-gear marginLeft10 smallerMobileHeading whiteText"></span></a>
				<span class="fui-exit hoverHand marginLeft10 smallerMobileHeading whiteText"
					onclick="logoutUser()"></span>
			</div>
		</div>
	</div>
</header>
<script>
	/**
	 * No easter eggs here, no sir.
	 */
	cheet('↑ ↑ ↓ ↓ ← → ← → b a', function () {
		alert('Cool video game reference number 1!');
	});
	cheet('i d d q d', function () {
		alert('Cool video game reference number 2!');
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