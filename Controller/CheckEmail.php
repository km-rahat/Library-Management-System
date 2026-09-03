<?php

include "../Model/db.php";

$email=$_POST["email"]??"";

if(!$email)
    {
        echo "Email Required";
    }
    else{
        $database = new db();
        $connection = $database->connection();
        $result= $database->CheckUser($connection, "members", $email);
        if($result->num_rows>0)
            {
                echo "Email Already Registered";
            }
            else{
                echo "Email Available";
            }

    }
?>