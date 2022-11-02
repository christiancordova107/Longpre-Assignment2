<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Main Page</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' href='./style.css'>
</head>

<body>
    <header class="main-header">
        <nav class="nav main-nav">
            <ul>
                <li><a href="./mainpage.php">Home</a></li> |
                <?php
session_start();

if (isset($_SESSION['userIn'])) {
    if ($_SESSION['userType'] === 'user') {
        echo '<li><a href="./user.php">User Page</a></li> |';
                } else { // user is of type admin
                echo '<li><a href="./user.php">User Page</a></li> |';
                echo '<li><a href="./admin.php">Admin Page</a></li> |';
                }

    echo '<li><a href="./endSession.php">Log out</a></li>';
                } else {
                echo '<li><a href="./signing.php">Sign In Page</a></li>';
                }
                ?>
            </ul>
        </nav>
        <h1>Welcome to the Main Page</h1>
    </header>

    <div>
        <?php

if (!isset($_SESSION['userIn'])) {
    echo '<a href="./signing.php" class="option">Sign In Page</a>';
}



?>
    </div>
    <br>
</body>

</html>