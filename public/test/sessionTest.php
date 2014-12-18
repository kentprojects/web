<?php
// Get authentication
$prerequisites = array("authentication");
require_once __DIR__ . "/../../private/bootstrap.php";
header("Content-type: text/plain");
var_dump($_SESSION);