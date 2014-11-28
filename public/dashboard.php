<?php
    // Get authentication
    $prerequisites = array("authentication");
    require_once __DIR__."/../private/bootstrap.php";

    $user = Auth::getUser();

    $projects = API::Request(API::GET, "/projects", array("fields" => "id,name,supervisor"));
    $supervisors = API::Request(API::GET, "/supervisors");

    // Get header
    $title = "Dashboard";
    require PUBLIC_DIR . "/includes/php/header.php";
?>
<div class="container">
    <div class="row">
        <h1> Dashboard </h1>
        <p> Start with this stuff... </p>
    </div>
</div>
<?php include PUBLIC_DIR.'/includes/php/footer.php'; ?>