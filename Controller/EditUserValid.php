<?php

include "../Config/Auth.php";
include_once "UserController.php";

auth_check("admin");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../View/Users.php");
    exit();
}

$id = $_POST["id"] ?? null;
$name = trim($_POST["name"] ?? '');
$email = trim($_POST["email"] ?? '');
$phone = trim($_POST["phone"] ?? '');
$role = trim($_POST["role"] ?? '');

if (!$id || empty($name) || empty($email) || empty($phone) || empty($role)) {
    header("Location: ../View/EditUser.php?id=" . (int)$id . "&error=" . urlencode("All fields are required"));
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../View/EditUser.php?id=" . (int)$id . "&error=" . urlencode("Invalid email address"));
    exit();
}

$controller = new UserController();

// Guard against an admin locking themselves out by demoting their own account.
if ((int)$id === (int)($_SESSION["member_id"] ?? 0) && $role != "admin") {
    header("Location: ../View/EditUser.php?id=" . (int)$id . "&error=" . urlencode("You can't change your own admin role"));
    exit();
}

$updated = $controller->updateUser($id, $name, $email, $phone, $role);

if ($updated) {
    header("Location: ../View/EditUser.php?id=" . (int)$id . "&success=" . urlencode("User updated successfully"));
} else {
    header("Location: ../View/EditUser.php?id=" . (int)$id . "&error=" . urlencode("Update failed — role may be invalid, or email/phone already in use"));
}

exit();

?>
