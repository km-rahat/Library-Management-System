<?php

session_start();
include_once __DIR__ . "/../../Controller/UserController.php";

header("Content-Type: application/json");

// Manual session check (not auth_check()) so a failed check returns JSON,
// not an HTML redirect — a redirect here would break JSON.parse() on the frontend.
if (
    !isset($_SESSION["loggedIn"]) ||
    $_SESSION["loggedIn"] != true ||
    $_SESSION["role"] != "admin"
) {
    http_response_code(403);
    echo json_encode(["error" => "Access Denied"]);
    exit();
}

$search = isset($_GET['q']) ? trim($_GET['q']) : '';

$controller = new UserController();
$users = $controller->searchUsers($search);

echo json_encode($users);

?>
