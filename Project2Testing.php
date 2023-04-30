<?php
$title = "CSE476 Project 2 Test Page";

$user = "samoyhun";  // verify that your userid is correct
$password = "KiaraIsMyDog"; // change this to use your application password
$base_url = "https://webdev.cse.msu.edu/~samoyhun/cse476/project2/"; // verify that this is the correct path to your web site
$magic = "uAss+5%FP'hK&65";
?>

<html lang="en">
<head>
    <title><?php echo $title; ?></title>
</head>
<body>
<h1><?php echo $title; ?></h1>
<h2>Create User Testing</h2>
<form method="post" target="_blank" action="<?php echo $base_url; ?>create-user.php">
    <p>Userid: <input type="text" name="user" value="<?php echo $user;?>"/></p>
    <p>magic: <input type="text" name="magic" value="<?php echo $magic;?>"/></p>
    <p>Password: <input type="text" name="pw" value="<?php echo $password;?>"/></p>
    <p><input type="submit" value="Test Save" /></p>
</form>

<hr />
<h2>Login Testing</h2>
<form method="get" target="_blank" action="<?php echo $base_url; ?>login.php">
    <input type="hidden" name="magic" value="<?php echo $magic; ?>" />
    <input type="text" name="user" value="<?php echo $user; ?>" />
    <input type="text" name="pw" value="<?php echo $password; ?>" />
    <p> <input type="submit" value="Test Login" /></p>
</form>

<hr />
<h2>Create Game Testing</h2>
<form method="post" target="_blank" action="<?php echo $base_url; ?>create-game.php">
    <input type="hidden" name="magic" value="<?php echo $magic; ?>" />
    <p>username: <input type="text" name="user" value="<?php echo $user; ?>" /></p>
    <p>Password: <input type="text" name="pw" value="<?php echo $password;?>"/></p>
    <p> <input type="submit" value="Test Create Game" /></p>
</form>

<hr />
<h2>Load Game Testing</h2>
<form method="get" target="_blank" action="<?php echo $base_url; ?>load-game.php">
    <input type="hidden" name="magic" value="<?php echo $magic; ?>" />
    <input type="text" name="user" value="<?php echo $user; ?>" />
    <input type="text" name="pw" value="<?php echo $password; ?>" />
    <input type="text" name="game_id"/>
    <p> <input type="submit" value="Test Load Game" /></p>
</form>

<hr />
<h2>Delete Game Testing</h2>
<form method="get" target="_blank" action="<?php echo $base_url; ?>delete-game.php">
    <input type="hidden" name="magic" value="<?php echo $magic; ?>" />
    <input type="text" name="user" value="<?php echo $user; ?>" />
    <input type="text" name="pw" value="<?php echo $password; ?>" />
    <p>Hello</p>
    <!--<input type="text" name="game_id" value="" />-->
    <p> <input type="submit" value="Test Delete Game" /></p>
</form>

<hr />
<h2>Game Catalog Testing</h2>
<form method="get" target="_blank" action="<?php echo $base_url; ?>list-games.php">
    <input type="hidden" name="magic" value="<?php echo $magic; ?>" />
    <input type="submit" value="Test listing games" />
</form>

<hr />
<h2>Update Game Testing</h2>
<form method="post" target="_blank" action="<?php echo $base_url; ?>update-game.php">
    <input type="hidden" name="magic" value="<?php echo $magic; ?>" />
    <input type="text" name="user" value="<?php echo $user; ?>" />
    <input type="text" name="pw" value="<?php echo $password; ?>" />
    <input type="text" placeholder="game_id" name="game_id"/>
    <input type="text" placeholder="col_id" name="col_id"/>
    <input type="text" placeholder="row_id" name="row_id"/>
    <p> <input type="submit" value="Test Update Game" /></p>
</form>

</body>
</html>