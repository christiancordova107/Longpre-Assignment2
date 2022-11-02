<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Admin Page</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' href='./style.css'>
</head>

<body>
    <header class="main-header">
        <nav class="nav main-nav">
            <ul>
                <li><a href="./mainpage.php">Home</a></li> |
                <li><a href="./user.php">User Page</a></li> |
                <li><a href="./endSession.php">Log out</a></li>
            </ul>
        </nav>
        <h1> Admin page</h1>
    </header>


    <main>
        <?php
        session_start();
        if ($_SESSION['userIn'] === true && $_SESSION['userType'] === 'admin') {
            echo "<h2>Welcome " . $_SESSION['fname'] . " " . $_SESSION['lname'] . "</h2>";
            echo PHP_EOL . '<h4>Last Login: ' . $_SESSION['lastLogin'] . '</h4>' . PHP_EOL;

        }
        ?>
    </main>
    <div>
        <a href="./createUser.php" class="option">Create a User</a>
        <a href="./view_users.php" class="option">View Users</a>
    </div>
</body>

</html>