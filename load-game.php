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

// Ensure the game_id item exists
if(!isset($_GET['game_id'])) {
    echo '<connect4 status="no" msg="missing game_id" />';
    exit;
}

$game_id = $_GET['game_id'];
$user = $_GET["user"];
$password = $_GET["pw"];

$pdo = pdo_connect();

$userid = getUser($pdo, $user, $password);

if ($userid) {
    loadGame($pdo, $game_id, $userid);
} else {
    echo '<connect4 status="no" msg="user invalid" />';
    exit;
}

function loadGame($pdo, $game_id, $user_id) {
    // add user_id as player2_id to games table figure out how to do player1
    // generate board
    $query = "SELECT COUNT(*) FROM games WHERE game_id = $game_id";
    $result = $pdo->query($query)->fetchColumn();
    if ($result == 0) {
        echo '<connect4 status="no" msg="game does not exist" />';
        exit;
    }

    // Add the current user as the second player
    $add_second_player_query = "UPDATE games SET player2_id = $user_id WHERE game_id = $game_id";
    $pdo->query($add_second_player_query);

    // echo the gameboard.
    $board_query = "SELECT position, spot1, spot2, spot3, spot4, spot5, spot6 FROM columns WHERE game_id = $game_id";
    $res = $pdo->query($board_query);

    $row = $res->fetchAll();

    echo "<connect4 status=\"yes\" >";
    echo "\n";

    foreach ($row as $rowItem) {
        // Access individual columns within the row
        $position = $rowItem['position'];
        $spot1 = $rowItem['spot1'];
        $spot2 = $rowItem['spot2'];
        $spot3 = $rowItem['spot3'];
        $spot4 = $rowItem['spot4'];
        $spot5 = $rowItem['spot5'];
        $spot6 = $rowItem['spot6'];

        echo "<connect4 column=\"$position\" row1=\"$spot1\" row2=\"$spot2\" row3=\"$spot3\"
                row4=\"$spot4\" row5=\"$spot5\" row6=\"$spot6\"/>\r \n";
    }
    echo "</connect4>";

    $current_player_query = "SELECT current_player_id FROM games WHERE game_id=$game_id";
    $result = $pdo->query($current_player_query);
    $current_player_id = $result->fetch()["current_player_id"];

    echo "<connect4 status=\"yes\" current_player_id=\"$current_player_id\" />";

    exit;
}
