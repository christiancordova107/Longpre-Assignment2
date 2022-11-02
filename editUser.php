<?php
session_start();
require_once('login.php');
require_once('query.php');

if ($_SESSION['userIn'] != true || $_SESSION['userType'] != 'admin') {
    header('location: mainpage.php?error=access restricted');
    exit();
}

if (isset($_GET['uName'])) {
    $username = $_GET['uName'];
} elseif (isset($_POST['Submit'])) {
    if (isset($_POST['Submit'])) { // form to make changes was submitted
        $username = null; //new Username if changed
        $conn = new mysqli($host, $user, $pass, $db);

        if ((isset($_POST['username'])) && $_POST['original-username'] != $_POST['username']) { //check if username is not taken
            $username = filter_var($_POST['username'], FILTER_SANITIZE_EMAIL);
            $query = "SELECT (username) FROM users where username='" . $username . "';";
            $result = query($query, $conn);

            if ($result->num_rows > 0) { //username taken
                header('Location: editUser.php?error=username is already taken');
                exit();
            } else {
                $query = "UPDATE users SET username='" . $username . "'WHERE username='" . $_POST['original-username'] . "';";

                if (!(query($query, $conn))) {
                    header("Location: editUser.php?error=An error occurred while trying to save the changes, please try again");
                    exit();
                }
            }
        } else {
            $username = $_POST['original-username'];
        }

        if ((isset($_POST['fname'])) && $_POST['original-first-name'] != $_POST['fname']) {
            $fname = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
            $query = "UPDATE users SET fname='" . $fname . "'WHERE username='" . $username . "';";

            if (!(query($query, $conn))) {
                header("Location: editUser.php?error=An error occurred while trying to save the changes, please try again");
                exit();
            }
        }

        if (isset($_POST['lname']) && $_POST['original-last-name'] != $_POST['lname']) {
            $lname = filter_var($_POST['lname'], FILTER_SANITIZE_STRING);
            $query = "UPDATE users SET lname='" . $lname . "'WHERE username='" . $username . "';";

            if (!(query($query, $conn))) {
                header("Location: editUser.php?error=An error occurred while trying to save the changes, please try again");
                exit();
            }
        }


        if (isset($_POST['password'])) {
            $salt = "I love CS";

            $newPass = password_hash($salt . filter_var($_POST['password'], FILTER_SANITIZE_STRING), PASSWORD_DEFAULT);

            $query = "UPDATE users SET password='" . $newPass . "'WHERE username='" . $username . "';";

            if (!(query($query, $conn))) { //something went wrong while trying to make the changes
                header("Location: editUser.php?error=An error occurred while trying to save the changes, please try again");
                exit();
            }
        }

        header("Location: view_users.php?success=Successfully made the changes");
    }
}

$conn = new mysqli($host, $user, $pass, $db);
$query = "SELECT * FROM users where username='" . $username . "';";

if (!($result = query($query, $conn))) {
    header('Location: view_users.php?error=Error while trying to edit user');
    exit();
} else {
    $row = $result->fetch_row();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div style="margin-top: 20px" class="container">
        <h1>Edit User</h1>
        <form action="editUser.php" method="post">
            <input type="hidden" name="original-first-name" id="original-first-name" value="<?php echo $row[0] ?>">

            <div class="form-group">
                <label for="fname">First Name</label>
                <input class="form-control" type="text" id="fname" name="fname" value="<?php echo $row[0]; ?>" required>
            </div>

            <input type="hidden" name="original-last-name" id="original-last-name" value="<?php echo $row[1] ?>">

            <div class="form-group">
                <label for="lname">Last Name</label>
                <input class="form-control" type="text" id="lname" name="lname" required value="<?php echo $row[1]; ?>">
            </div>

            <input type="hidden" name="original-username" id="original-username" value="<?php echo $username ?>">

            <div class="form-group">
                <label for="username">Username</label>
                <input class="form-control" type="text" id="username" name="username" required
                    value="<?php echo $row[2]; ?>">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input class="form-control" type="password" id="password" name="password" value="">
            </div>
            <div class="form-group">
                <label for="creation-time">Creation Time</label>
                <input class="form-control" type="text" id="creation-time" name="creation-time"
                    value="<?php echo $row[4]; ?>" disabled>
            </div>
            <div class="form-group">
                <label for="last-login-time">Last Login Time</label>
                <input class="form-control" type="text" id="last-login-time" name="last-login-time"
                    value="<?php echo $row[5]; ?>" disabled>
            </div>
            <div class="form-group">
                <input class="btn btn-primary" name='Submit' type="submit" value="Submit">
            </div>
        </form>
        <?php
        if (isset($_GET['error'])) {
            echo '<br>' . $_GET['error'];
        }
        ?>
        <div>
            <br>
            <a href="view_users.php">Back to User View</a>
        </div>
    </div>

    <?php


    ?>
</body>

</html>