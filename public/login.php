<?php
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */
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

$loginAsCas = isset($_GET["cas"]) || isset($_GET["CAS"]);

/**
 * This will be set to true when we are going live.
 */
if (false && !$loginAsCas)
{
	Auth::redirect();
	exit();
}



$people = array(
	"f4dfeada0e91e1791a80da1bb26a7d96" => array(
		"role" => "convenor",
		"username" => "Julio"
	),
	"1e9a755d73865da9068f079d81402ce7" => array(
		"role" => "staff",
		"username" => "John"
	),
	"6f2653c2a1c64220e3d2a713cc52b438" => array(
		"role" => "staff",
		"username" => "Stuart"
	),
	"1f18ed87771daf095e090916cb9423e4" => array(
		"role" => "student",
		"username" => "House"
	),
	"1460357d62390ab9b3b33fa1a0618a8f" => array(
		"role" => "student",
		"username" => "Dryden"
	),
	"930144ea545ce754789b15074106bc36" => array(
		"role" => "student",
		"username" => "Weeks"
	),
);
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>KentProjects Login</title>
        <link rel="shortcut icon" href="/includes/img/kp.ico">
        <link href="/includes/css/lib/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="/includes/css/lib/flat-ui-pro.min.css" rel="stylesheet">
        <link href="/includes/css/style.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
	    	<?php if ($loginAsCas) { ?>
	        <div class="row">
                <h2 class="text-center">KentProjects CAS office login:</h2>
            </div>
			<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-4 bigMargin centerInRow centerItem">
							<div class="login-form">
                                <form action="<?php echo API::GetURL();?>/auth/cas" method="POST">
                                    <div class="form-group">
                                        <input type="text" class="form-control login-field" value="" placeholder="Username" id="login-name" />
                                        <label class="login-field-icon fui-user" for="login-name"></label>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control login-field" value="" placeholder="Password" id="login-pass" />
                                        <label class="login-field-icon fui-lock" for="login-pass"></label>
                                    </div>
                                    <button class="btn btn-primary btn-lg btn-block">Login</button>
                                </form>
							</div>
					</div>
			</div>
				<?php } else { ?>
			<div class="row">
                <h2 class="text-center">KentProjects Beta Login</h2>
                <p class="text-center text-info">This is only temporary. If you see this after September 2015, tell Julio.</p>
            </div>

			<?php if (empty($_SERVER["CORPUS_ENV"])) { ?>
            <div class="row">
				<div class="col-xs-12 col-sm-6 col-md-4 bigMargin centerInRow centerItem">
					<a href="<?php echo API::GetURL();?>/auth/sso" class="btn btn-block btn-lg btn-info centerItem restrictedWidth">
						Login with SSO
					</a>
				</div>
			</div>
			<?php } ?>

            <div class="row">
				<?php foreach($people as $code => $person) { ?>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 bigMargin">
                    <a href="?auth=<?php echo $code;?>" class="btn btn-block btn-md btn-primary centerItem restrictedWidth">
						Log in as <?php echo strtoupper($person["username"]);?> (<?php echo ucfirst($person["role"]);?>)
					</a>
                </div>
				<?php } ?>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4 bigMargin centerInRow centerItem">
                    <a href="/" class="btn btn-block btn-md btn-danger centerItem restrictedWidth">Back to landing page</a>
                </div>
            </div>
        <?php } ?>
            <footer class="row">
                <hr/>
                <p class="bigTargin softenText text-center">&copy; 2014. James Dryden, Matt House, Matt Weeks</p>
            </footer>
        </div>
    </body>
</html>
