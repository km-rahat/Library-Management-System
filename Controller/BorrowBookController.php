<?php

include "../Config/Auth.php";
include_once "BookController.php";

auth_check("member");

$bookId = $_GET['id'] ?? null;
$memberId = $_SESSION['member_id'] ?? null;

if (!$bookId || !$memberId) {
    header("Location: ../View/member_books.php");
    exit();
}

$controller = new BookController();
$result = $controller->borrowBook($memberId, $bookId);

$param = $result['success'] ? 'success' : 'error';

header("Location: ../View/member_books.php?" . $param . "=" . urlencode($result['message']));
exit();

?>
