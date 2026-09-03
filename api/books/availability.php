<?php

include_once '../../Controller/BookController.php';

header("Content-Type: application/json");

$id = $_GET['id'];

$controller = new BookController();

$book = $controller->singleBook($id);

echo json_encode([

    "available" => $book['available_copies']

]);

?>