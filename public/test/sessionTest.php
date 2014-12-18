<?php
// Get authentication
$prerequisites = array("authentication");
require_once __DIR__ . "/../../private/bootstrap.php";
header("Content-type: text/plain");
print_r($_SESSION);