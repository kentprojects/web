<?php
    // Get header
    require_once __DIR__."/../private/bootstrap.php";
    $title = "Settings";
    require PUBLIC_DIR . "/includes/php/header.php";
?>
<div class="container">
    <div class="row">
        <h1> Settings </h1>
    </div>
    <div class=""row>
        <form action="dashboard.php" method="get">
            <input type="text" name="year" id="yearSelector" class="form-control text-center"
                placeholder="Year">
        </form>
    </div>
</div>
<?php require PUBLIC_DIR.'/includes/php/footer.php'; ?>