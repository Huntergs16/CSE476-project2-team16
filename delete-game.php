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
    echo '<connect4 status="no" msg="wrong magic word" />';
    exit;
}

$player1 = $_GET["user"];
$password = $_GET["pw"];

$pdo = pdo_connect();

$player1_id = getUser($pdo, $player1, $password);

$query = "SELECT game_id from games WHERE player1_id=$player1_id OR player2_id=$player1_id";
$rows = $pdo->query($query);
if (!$rows) {
    echo '<connect4 status="no" msg="failed to delete game maybe there is no game to delete" />';
    exit;
} else {
    if($row = $rows->fetch()) {
        $game_id = $row['game_id'];
        deleter($pdo, $game_id);
    }
}

function deleter($pdo, $idQ) {
    // Checks
    if(!is_numeric($idQ)) {
        echo '<connect4 status="no" msg="invalid" />';
        exit;
    }
    $query = "delete from columns where game_id=$idQ";
    if(!$pdo->query($query)) {
        echo '<connect4 status="no" msg="deletefail">' . $query . '</connect4>';
        exit;
    }

    $query = "delete from games where game_id=$idQ";
    if(!$pdo->query($query)) {
        echo '<connect4 status="no" msg="deletefail">' . $query . '</connect4>';
        exit;
    }
    echo "<connect4 status=\"yes\" msg=\"delete successful\">";
    exit;
}
