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

</body>
</html>