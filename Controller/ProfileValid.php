<?php

include "../Model/db.php";
include "../Config/Auth.php";

auth_check("member");

$db = new db();
$conn = $db->connection();

$id = $_SESSION["member_id"];

$result = $db->getUserById($conn, $id);

$user = $result->fetch_assoc();

$error = "";
$success = "";


/* DASHBOARD PLACEHOLDER COUNTS */

$counts = [
    "active_loans" => 0,
    "upcoming_dues" => 0,
    "outstanding_fines" => 0
];


/* UPDATE PROFILE + PASSWORD */

if($_SERVER["REQUEST_METHOD"] == "POST")
{

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);


    /* PROFILE UPDATE */

    if(empty($name) || empty($email) || empty($phone))
    {
        $error = "All fields are required";
    }
    else
    {
        $update = $db->updateProfile($conn, $id, $name, $email, $phone);

        if($update)
        {
            $_SESSION["name"] = $name;

            setcookie("name", $name, time()+3600, "/");

            $success = "Profile Updated Successfully";

            // Reload updated user data
            $result = $db->getUserById($conn, $id);

            $user = $result->fetch_assoc();
        }
        else
        {
            $error = "Profile Update Failed";
        }
    }


    /* PASSWORD CHANGE */
if (!empty($_POST["current_password"]) && !empty($_POST["new_password"])) {

    $current = $_POST["current_password"];
    $new = $_POST["new_password"];

    $result = $db->getUserById($conn, $id);
    $user = $result->fetch_assoc();

    if ($current == $user["password_hash"]) {

        $passwordUpdate = $db->updatePassword($conn, $id, $new);

        if ($passwordUpdate) {
            $success = "Password Updated Successfully";
        } else {
            $error = "Password Update Failed";
        }

    } else {
        $error = "Current Password Incorrect";
    }
}

}


?>