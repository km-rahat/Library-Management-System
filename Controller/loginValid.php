<?php

include "../Model/db.php";

session_start();

$email = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (!empty($email) && !empty($password)) {

        $database = new db();
        $connection = $database->connection();

        $result = $database->signin($connection, "members", $email);

        if ($result && $result->num_rows > 0) {

            $row = $result->fetch_assoc();

            if ($row["password_hash"] == $password) {

                $_SESSION["member_id"] = $row["id"];
                $_SESSION["name"] = $row["name"];
                $_SESSION["role"] = $row["role"];
                $_SESSION["loggedIn"] = true;

                setcookie("name", $row["name"], time() + 3600, "/");

                if ($row["role"] == "member") {
                    header("Location: ../View/member_dashboard.php");
                    exit();
                } elseif ($row["role"] == "librarian") {
                    header("Location: ../View/librarian_dashboard.php");
                    exit();
                } elseif ($row["role"] == "admin") {
                    header("Location: ../View/admin_dashboard.php");
                    exit();
                } else {
                    echo "Invalid Role";
                }

            } else {
                echo "Incorrect Password";
            }

        } else {
            echo "Email Not Found";
        }

    } else {
        echo "Please Fill All Fields";
    }
}

?>