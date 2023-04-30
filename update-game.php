<?php

require_once "db.inc.php";
require "connect4-inc.php";

echo '<?xml version="1.0" encoding="UTF-8" ?>';

// Ensure the player1_id post item exists
if(!isset($_POST['user'])) {
    echo '<connect4 status="no" msg="missing username" />';
    exit;
}

// Ensure the password post item exists
if(!isset($_POST['pw'])) {
    echo '<connect4 status="no" msg="missing password" />';
    exit;
}

// Ensure the password post item exists
if(!isset($_POST['row_id'])) {
    echo '<connect4 status="no" msg="missing row_id" />';
    exit;
}

// Ensure the password post item exists
if(!isset($_POST['col_id'])) {
    echo '<connect4 status="no" msg="missing column_id" />';
    exit;
}

// Ensure the password post item exists
if(!isset($_POST['game_id'])) {
    echo '<connect4 status="no" msg="missing game_id" />';
    exit;
}

if(!isset($_POST['magic']) || $_POST['magic'] != "uAss+5%FP'hK&65") {
    echo '<connect4 status="no" msg="magic error" />';
    exit;
}

$game_id = $_POST['game_id'];
$user = $_POST["user"];
$password = $_POST["pw"];
$row_id = $_POST['row_id'];
$col_id = $_POST['col_id'];

$pdo = pdo_connect();

$userid = getUser($pdo, $user, $password);

doesGameExist($pdo, $game_id);

isSpotTaken($pdo, $game_id, $col_id, $row_id);

placePiece($pdo, $userid, $game_id, $row_id, $col_id);

exit;


function isSpotTaken($pdo, $game_id, $column_position, $row_position) {
    $query = <<<QUERY
SELECT spot$row_position
FROM columns
WHERE game_id = $game_id AND position = $column_position
QUERY;

    $result = $pdo->query($query);
    $row = $result->fetch();

    if ($row["spot{$row_position}"] !== 0) {
        echo '<connect4 status="no" msg="spot is already taken!" />';
        exit;
    }
}

function doesGameExist($pdo, $game_id){
    $query = "SELECT COUNT(*) FROM games WHERE game_id = $game_id";
    $result = $pdo->query($query)->fetchColumn();
    if ($result == 0) {
        echo '<connect4 status="no" msg="game does not exist">';
        exit;
    }
}


function placePiece($pdo, $user_id, $game_id, $row_id, $col_id) {
    $current_player = whichPlayer($pdo, $game_id, $user_id);
    $next_player = ($current_player == 1) ? 2 : 1;

    // place piece
    $query = <<<QUERY
UPDATE columns
SET spot$row_id = $current_player
WHERE game_id = $game_id AND position = $col_id
QUERY;

    echo $query;

    $pdo->query($query);

    // set current_player to other player
    $query = <<<QUERY
UPDATE games
SET current_player_id = $next_player
WHERE game_id = $game_id
QUERY;

    echo $query;

    $pdo->query($query);

    echo '<connect4 status="yes" msg="piece placed">';
}

function whichPlayer($pdo, $game_id, $user_id) {
    $query = "SELECT COUNT(*) FROM games WHERE game_id = $game_id AND player1_id = $user_id";
    $result = $pdo->query($query)->fetchColumn();
    if ($result == 1) {
        return 1;
    } else return 2;
}