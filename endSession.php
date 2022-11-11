<?php
function destroy_session_and_data()
{
    session_start();
    $_SESSION = array(); //empty the session array 
    setcookie(session_name(), '', time() - 2592000, '/'); //set the cookie to expire by changing date
    session_destroy(); //destroy the session 
}

destroy_session_and_data();
header('Location: mainpage.php');