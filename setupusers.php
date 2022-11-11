<?php // setupusers.php
require_once 'login.php';
$connection = new mysqli($host, $user, $pass, $db);

if ($connection->connect_error)
    die("Fatal Error");

$query = "CREATE TABLE users (
        fname VARCHAR(50) NOT NULL,
        lname VARCHAR(50) NOT NULL,
        username VARCHAR(100) NOT NULL UNIQUE,
        creation_time datetime,
        last_login datetime,
        password VARCHAR(255) NOT NULL
    )";

$result = $connection->query($query);
if (!$result)
    die("Fatal Error");

$fname = 'Bill';
$lname = 'Smith';
$username = 'bsmith@gmail.com';
$password = 'mysecret';
$password = $password . "I love CS";
$hash = password_hash($password, PASSWORD_DEFAULT);

add_user($connection, $fname, $lname, $username, $hash);

$query = "CREATE TABLE admins (
    fname VARCHAR(50) NOT NULL,
    lname VARCHAR(50) NOT NULL,
    username VARCHAR(100) NOT NULL UNIQUE,
    creation_time datetime,
    last_login datetime,
    password VARCHAR(255) NOT NULL
)";

$result = $connection->query($query);
if (!$result)
    die("Fatal Error");

$fname = 'Luc';
$lname = 'Longpre';
$username = 'admin';
$password = 'nimda22';


add_user($connection, $fname, $lname, $username, $password);


function add_user($connection, $fn, $ln, $un, $pw)
{
    $loginStampt = date('Y-m-d H:i:s');

    $query = "INSERT INTO users VALUES('" . $fn . "', " . $ln . "', " . $un . "', " . $loginStampt . "', " . $loginStampt . "')";

    $result = $connection->query($query);
}
?>