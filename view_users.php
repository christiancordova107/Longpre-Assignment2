<?php
session_start();
require_once('login.php');
require_once('query.php');

if ($_SESSION['userIn'] != true && $_SESSION['userType'] != 'admin') {
    header('Location: mainpage.php');
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Admin Log In</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel='stylesheet' type='text/css' href='./style.css'>
    <style>
        thead.table-colums {
            background-color: #de7702;
            color: white;
        }
    </style>

</head>

<body>
    <header class="main-header">
        <nav class="nav main-nav">
            <ul>
                <li><a href="./mainpage.php">Home</a></li> |
                <li><a href="./user.php">User Page</a></li> |
                <li><a href="./admin.php">Admin Page</a></li> |
                <li><a href="./endSession.php">Log out</a></li>
            </ul>
        </nav>
        <h1>Users View Page</h1>
    </header>

    <?php
    $conn = new mysqli($host, $user, $pass, $db); //Connect to the db
    $query = "SELECT * FROM users";

    if (($result = query($query, $conn))) {
    ?>
    <table class="table table-striped" width=50%>
        <thead class="table-colums">
            <td> First Name</td>
            <td> Last Name</td>
            <td> Username </td>
            <td> Password </td>
            <td> Creation Time </td>
            <td> Last Login </td>
        </thead>
        <tbody>
            <?php
        while ($row = $result->fetch_row()) {
            ?>
            <tr>
                <td>
                    <? echo $row[0]; ?>
                </td>
                <td>
                    <? echo $row[1]; ?>
                </td>
                <td>
                    <? echo $row[2]; ?>
                </td>
                <td>
                    <? echo $row[3]; ?>
                </td>
                <td>
                    <? echo $row[4]; ?>
                </td>
                <td>
                    <? echo $row[5]; ?>
                </td>
                <td>
                    <a class="edit-option" href="editUser.php?uName=<?php echo $row[2] ?>">Edit User</a>
                </td>
            </tr>
            <?php
        }
            ?>
        </tbody>
    </table>
    <?php
    }
    if (isset($_GET['error'])) {
        echo '<br>' . $_GET['error'] . '<br><br>';
    } elseif (isset($_GET['success'])) {
        echo '<br>' . $_GET['success'] . '<br><br>';
    }
    ?>

    <a href="admin.php" class='go-back'>Go back to Admin Page</a>
</body>

</html>