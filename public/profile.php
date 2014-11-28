<?php
    // Get authentication
    $prerequisites = array("authentication");
    require_once __DIR__."/../private/bootstrap.php";

    $user = Auth::getUser();
    // Get header
    $title = "Profile";
    require PUBLIC_DIR . "/includes/php/header.php";
?>
<div class="container">
    <div class="row">
        <h1> Profile </h1>
		<pre><?php print_r($user);?></pre>
        <p> This be your profile page, <?php echo $user->first_name;?> </p>
    </div>
</div>
<?php require PUBLIC_DIR.'/includes/php/footer.php'; ?>