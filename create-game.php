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
    exit;
} else {
    $game_id = $pdo->lastInsertId();
    echo "<connect4 status=\"yes\" game_id=\"$game_id\" /> \n";
    createGameBoard($pdo, $game_id);
    loadInitialGame($pdo, $game_id);
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
}

function loadInitialGame($pdo, $game_id) {
    // add user_id as player2_id to games table figure out how to do player1
    // generate board
    // Does the user exist in the database?
    $query = "SELECT COUNT(*) FROM games WHERE game_id = $game_id";
    $result = $pdo->query($query)->fetchColumn();
    if ($result == 0) {
        echo '<connect4 status="no" msg="game does not exist" />';
        exit;
    }

    // echo the gameboard.
    $board_query = "SELECT position, spot1, spot2, spot3, spot4, spot5, spot6 FROM columns WHERE game_id = $game_id";
    $res = $pdo->query($board_query);

    $row = $res->fetchAll();

    echo '<connect4 status="yes">';
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
    exit;
}

