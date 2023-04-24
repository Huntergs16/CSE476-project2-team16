<?php
require_once "db.inc.php";

echo '<?xml version="1.0" encoding="UTF-8" ?>';

// Ensure the userid post item exists
if(!isset($_POST['user'])) {
    echo '<connect4 status="no" msg="missing user" />';
    exit;
}
// Ensure the magic post item exists
if(!isset($_POST['magic'])) {
    echo '<connect4 status="no" msg="missing magic" />';
    exit;
}
// Ensure the password post item exists
if(!isset($_POST['pw'])) {
    echo '<connect4 status="no" msg="missing password" />';
    exit;
}

if($_POST['magic'] != "uAss+5%FP'hK&65") {
    echo '<connect4 status="no" msg="wrong magic word" /&>';
    exit;
}

$user = $_POST["user"];
$password = $_POST["pw"];

$pdo = pdo_connect();

//echo '<connect4 status="yes" msg="checking user" /&>';
if (checkUser($pdo, $user, $password)) {
    createUser($pdo, $user, $password);
}

function checkUser($pdo, $user, $password) {
    // Does the user exist in the database?
    $userQ = $pdo->quote($user);
    $query = "SELECT id, password from users where username=$userQ";
    $rows = $pdo->query($query);
    if($row = $rows->fetch()) {
        echo '<connect4 status="no" msg="user already exists" />';
        exit;
    }

//    echo '<connect4 status="yes" msg="username available" />';
    return true;
}

function createUser($pdo, $user, $password) {
//    echo '<connect4 status="yes" msg="Creating user" />';
    // Sanitizing inputs
    $userq = $pdo->quote($user);
    $passwordq = $pdo->quote($password);

    $query = <<<QUERY
INSERT INTO users(username, password)
VALUES($userq, $passwordq)
QUERY;

    if(!$pdo->query($query)) {
        echo '<connect4 status="no" msg="insertfail">' . $query . '</connect4>';
        exit;
    }

    echo '<connect4 status="yes" msg="user successfully created"/>';
    exit;
}