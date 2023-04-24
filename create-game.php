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

if(!isset($_POST['magic']) || $_POST['magic'] != "uAss+5%FP'hK&65") {
    echo '<connect4 status="no" msg="magic" />';
    exit;
}

$player1 = $_POST["user"];
$password = $_POST["pw"];

$pdo = pdo_connect();

// Check if the user is valid???
$player1_id = getUser($pdo, $player1, $password);

$create_query = <<<QUERY
INSERT INTO games(player1_id, current_player_id)
VALUES($player1_id, $player1_id)
QUERY;
$rows = $pdo->query($create_query);
$game_id = null;
if (!$rows) {
    echo '<connect4 status="no" msg="failed to create game" />';
} else {
    $game_id = $pdo->lastInsertId();
    echo '<connect4 status="yes" msg="game created" game_id="' . $game_id . '" />';
    createGameBoard($pdo, $game_id);
}

echo '<connect4 status="yes" msg="Game session and board created" />';
exit;


function createGameBoard($pdo, $game_id) {
    // Initialize the game board
    for($i = 1; $i <= 7; $i++) {
        $query = <<<QUERY
INSERT INTO columns(game_id, position)
VALUES($game_id, $i)
QUERY;

        if(!$pdo->query($query)) {
            echo '<connect4 status="no" msg="board initialization failed" />';
            exit;
        }
    }
    echo '<connect4 status="yes" msg="board successfully initialized" />';
}


