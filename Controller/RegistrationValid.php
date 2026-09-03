<?php
include "../Model/db.php";
session_start();

$name = "";
$email = "";
$phone = "";
$password = "";
$role = "";
$date = "";
$error = "";


if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $password = $_POST["password"];
        $role = $_POST["role"];
        $date = $_POST["date"];

        setcookie("UserName",$name,time()+3600, "/");

        if(empty($name)){
            $error .= "Name is Required<br>";
        }
        if(empty($email)){
            $error .= "Email is Required<br>";
        }
        if(empty($phone)){
            $error .= "Phone Number is Required<br>";
        }
        elseif(!is_numeric($phone)){
            $error .= "Phone Number Must be Numeric<br>";
        }

        if(empty($password))
        {
            $error .= "Password is Required<br>";
        }
        elseif(strlen($password) < 8)
        {
            $error .= "Password Must be at Least 8 Characters<br>";
        }
        if(empty($role))
        {
            $role = "member";
        }
        if(empty($date))
        {
            $error .= "Creation Date Required<br>";
        }
        if($error != ""){
            echo $error;
        }else{

            $database = new db();
            $connection = $database->connection();
            $result = $database->WithSQLInjection($connection,"members", $name,$email,$phone, $password, $role, $date);
            if($result)
                {
                    Header("Location:../View/login.php ");
                }
            else{
                echo "Please Use the appropiate validation";
            }
    }
    if(!isset($_SESSION["UserName"]) || isset($_COOKIE["UserName"]))
        {
            echo "Welcome Back";
        }
        else{
            echo "Please log In";
        }
    }


?>