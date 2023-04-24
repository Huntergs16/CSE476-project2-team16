<?php
require_once "db.inc.php";
require "connect4-inc.php";

echo '<?xml version="1.0" encoding="UTF-8" ?>';

// Ensure the userid post item exists
if(!isset($_GET['user'])) {
    echo '<connect4 status="no" msg="missing user" />';
    exit;
}
// Ensure the magic post item exists
if(!isset($_GET['magic'])) {
    echo '<connect4 status="no" msg="missing magic" />';
    exit;
}
// Ensure the password post item exists
if(!isset($_GET['pw'])) {
    echo '<connect4 status="no" msg="missing password" />';
    exit;
}

if($_GET['magic'] != "uAss+5%FP'hK&65") {
    echo '<connect4 status="no" msg="wrong magic word" /&>';
    exit;
}

$user = $_GET["user"];
$password = $_GET["pw"];

$pdo = pdo_connect();
$userid = getUser($pdo, $user, $password);

if ($userid) {
    echo "<connect4 status=\"yes\" msg=\"login successful\">";
//    echo "<connect4 status=\"yes\" userid='$userid'/>\r </connect4>";
    exit;
} else {
    echo '<connect4 status="no" msg="login attempt failed">';
}