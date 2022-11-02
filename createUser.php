<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a User Page</title>
    <link rel='stylesheet' type='text/css' href='./style.css'>
    <style>
        form.form {
            padding-left: 37.5%;
            width: 25%;

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
        <h1> Create a User Page</h1>
    </header>

    <section class="create-user">
        <form action="createUser.php" method="post" class="form">
            <fieldset>
                <legend><b>Add User</b></legend>
                <label for="fname">First Name:</label><br>
                <input type="text" id="fname" name="fname" required><br><br>

                <label for="lname">Last Name:</label><br>
                <input type="text" id="lname" name="lname" required><br><br>

                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username" required><br><br>

                <label for="passsword">Passsword:</label><br>
                <input type="password" id="password" name="password" required><br><br>

                <label for="confirmedPasssword">Confirm Passsword:</label><br>
                <input type="password" id="confirmedPasssword" name="confirmedPasssword" required><br><br>

                <button type="submit" name='submit'>Add</button>
            </fieldset>
        </form>
        <?php
        if (isset($_GET['error'])) {
            echo '<br>' . $_GET['error'] . '<br>';
        } elseif (isset($_GET['success'])) {
            echo '<br>' . $_GET['success'] . '<br>';
        }
        ?>
    </section>
    <a href="admin.php" class='go-back'>Go back to Admin Page</a>
</body>

</html>



<?php
session_start();
if ($_SESSION['userIn'] === true && $_SESSION['userType'] === 'admin') {
    if (isset($_POST['submit'])) {

        $fname = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
        $lname = filter_var($_POST['lname'], FILTER_SANITIZE_STRING);
        $pass = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        $confPass = filter_var($_POST['confirmedPasssword'], FILTER_SANITIZE_STRING);

        if ($pass != $confPass) {
            header('Location: createUser.php?error=passwords did not match');
            exit();

        } else {
            $salt = "I love CS";

            $username = filter_var($_POST['username'], FILTER_SANITIZE_EMAIL);
            $confPass = password_hash($salt . $confPass, PASSWORD_DEFAULT);

            require_once('query.php');
            require_once('login.php');

            //add user
            $loginStampt = date('Y-m-d H:i:s');
            $conn = new mysqli($host, $user, $pass, $db);
            $query = "INSERT INTO users (fname, lname, username, password, creation_time, last_login) VALUES ('" . $fname . "', '" . $lname . "', '" . $username . "', '" . $confPass . "', '" . $loginStampt . "', '" . $loginStampt . "');";

            if (!($result = query($query, $conn))) {
                header('Location: createUser.php?error=something went wrong');
            } else {
                header('Location: createUser.php?success=New User was added');
            }
        }

    }
} else { // not an allowed user
    header("Location: ./mainpage.php");
}

?>