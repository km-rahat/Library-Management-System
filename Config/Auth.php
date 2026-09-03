<?php

session_start();

function auth_check($required_role = null)
{
    // Check if user is logged in
    if (
        !isset($_SESSION["loggedIn"]) ||
        $_SESSION["loggedIn"] != true
    ) {
        header("Location: ../View/login.php");
        exit();
    }

    // Check user role
    if ($required_role != null)
    {
        if ($_SESSION["role"] != $required_role)
        {
            echo "Access Denied";
            exit();
        }
    }
}

?>