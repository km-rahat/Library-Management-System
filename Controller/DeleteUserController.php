<?php

include "../Config/Auth.php";
include_once "UserController.php";

auth_check("admin");

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: ../View/Users.php");
    exit();
}

// An admin can't delete their own currently-logged-in account.
if ((int)$id === (int)($_SESSION["member_id"] ?? 0)) {
    header("Location: ../View/Users.php?error=" . urlencode("You can't delete your own account"));
    exit();
}

$controller = new UserController();
$controller->deleteUser($id);

header("Location: ../View/Users.php");
exit();

?>
