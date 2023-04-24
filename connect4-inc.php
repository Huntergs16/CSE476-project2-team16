<?php
require_once "db.inc.php";

function getUser($pdo, $user, $password) {
    // Does the user exist in the database?
    $userQ = $pdo->quote($user);
    $query = "SELECT id, password from users where username=$userQ";
    $rows = $pdo->query($query);
    if($row = $rows->fetch()) {
        // We found the record in the database
        // Check the password
        if($row['password'] != $password) {
            echo '<connect4 status="no" msg="password error" />';
            exit;
        }

        return $row['id'];
    }

    echo '<connect4 status="no" msg="user does not exist" />';
    exit;
}