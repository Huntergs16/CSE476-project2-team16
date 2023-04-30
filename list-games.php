<?php
require_once "db.inc.php";
require "connect4-inc.php";

echo '<?xml version="1.0" encoding="UTF-8" ?>';

// Ensure the magic post item exists
if(!isset($_GET['magic'])) {
    echo '<connect4 status="no" msg="missing magic" />';
    exit;
}

if($_GET['magic'] != "uAss+5%FP'hK&65") {
    echo '<connect4 status="no" msg="wrong magic word" /&>';
    exit;
}

$pdo = pdo_connect();

$games_query = "SELECT game_id, player1_id from games WHERE player2_id IS NULL";

$rows = $pdo->query($games_query);

echo "<connect4 status=\"yes\">";
echo "\n";
foreach($rows as $row ) {
    $game_id = $row['game_id'];
    $player1_id = $row['player1_id'];

    $username_query = "SELECT username from users WHERE user_id=$player1_id";
    $username = $pdo->query($username_query)->fetch()['username'];

    echo "<connect4 game_id=\"$game_id\" player1=\"$username\" />\r\n";
}
echo "</connect4>";
exit;