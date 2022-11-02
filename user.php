<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>User Page</title>
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
if ($_SESSION['userIn'] === true && $_SESSION['userType'] == 'admin') {
    echo '<li><a href="./admin.php">Admin Page</a></li> |';
}
?>
                <li><a href="./endSession.php">Log out</a></li>
            </ul>
        </nav>
        <h1> User page</h1>
    </header>

    <main>
        <?php
if ($_SESSION['userIn'] === true) {
    echo "<h2>Welcome " . $_SESSION['fname'] . " " . $_SESSION['lname'] . "</h2>";
    echo PHP_EOL . '<h4>Last Login: ' . $_SESSION['lastLogin'] . '</h4>';
    echo '<img src="./sus.gif"';
}
?>

    </main>
</body>

</html>