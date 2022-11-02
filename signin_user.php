<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>User Log In</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' href='./style.css'>
</head>

<body>
    <header class="main-header">
        <nav class="nav main-nav">
            <ul>
                <li><a href="./mainpage.php">Home</a></li> |
                <li><a href="./signing.php">Sign In Page</a></li>
            </ul>
        </nav>
        <h1>User Login In</h1>
    </header>

    <main>
        <form action="./signin_user.php" method="post">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br><br>
            <label for="passsword">Passsword:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <button type="submit" name='submit'>Log in</button>
        </form>
    </main>
</body>

</html>

<?php
require_once('./login.php'); //Information needed to connect to db
require_once('./query.php'); //To make queries



$conn = new mysqli($host, $user, $pass, $db); //Connect to the db

if ($conn->connect_error) // case: unanle to connect to db
    echo PHP_EOL . "Unexpected error. Try again later" . PHP_EOL;
else { // case: successfully connected to db
    if (!(isset($_POST['username'], $_POST['password'])) && isset($_POST['submit'])) { //Case: form was submitted but a field is missing
        echo PHP_EOL . "Missing username or password, please try again" . PHP_EOL;
    } elseif (isset($_POST['username'], $_POST['password']) && isset($_POST['submit'])) { //Case: form was submitted with both fields
        //sanitize input 
        $uEmail = filter_var($_POST['username'], FILTER_SANITIZE_EMAIL);
        $uPass = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

        //apply website salt to the password
        $salt = "I love CS";
        $saltedPass = $salt . $uPass;

        //make sure there's a user with the provided username
        $query = "SELECT * FROM users where username='" . $uEmail . "';";

        if (($result = (query($query, $conn))) && $result->num_rows > 0) { //user does exists
            $result = $result->fetch_assoc();
            $storedHashPass = $result['password'];

            if (password_verify($saltedPass, $storedHashPass)) { //user logs in
                $loginStampt = date('Y-m-d H:i:s');

                //update the last time the current user has logged in
                $query = "UPDATE users SET last_login='" . $loginStampt . "' WHERE users.username='" . $uEmail . "';";

                if (!($result = (query($query, $conn)))) { // case: unsuccessful log in 
                    echo "something went wrong, please try again later";
                } else { // case: successful log in 
                    session_start();

                    $query = "SELECT * FROM users where username='" . $uEmail . "';";
                    $result = query($query, $conn);
                    $userData = $result->fetch_assoc();

                    $_SESSION['userIn'] = true;
                    $_SESSION['fname'] = $userData['fname'];
                    $_SESSION['lname'] = $userData['lname'];
                    $_SESSION['lastLogin'] = $userData['last_login'];
                    $_SESSION['userType'] = 'user';



                    header('Location: user.php');
                    exit(); //stop running this script
                }
            }
        }
        echo 'the entered username or password may be wrong';
    }
}
?>