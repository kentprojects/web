<?php
    // Get authentication
    $prerequisites = array("authentication");
    require_once __DIR__."/../private/bootstrap.php";

    $user = Auth::getUser();
    // Get header
    $title = "Profile";
    require PUBLIC_DIR . "/includes/php/header.php";
?>
<script src="/includes/js/ajax.js" type="text/javascript"></script>
<script src="/includes/js/includes.php" type="text/javascript"></script>
<div class="container">
    <div class="row">
        <h1>Profile</h1>
		<p>Your email address is "<b id="user_email"> not available right now :(</b>"</p>
		<p>Your role is "<b id="user_role"> not available right now :(</b>"</p>
		<script type="text/javascript">
            API.GET(
				"/" +user.role+ "/" +user.id, {},
				function (data) {
                    document.getElementById("user_email").innerText = data.body.email;
                    document.getElementById("user_role").innerText = data.body.role;
                },
				function (data)	{console.error(data);}
			);
		</script>
    </div>
</div>
<?php require PUBLIC_DIR.'/includes/php/footer.php'; ?>
