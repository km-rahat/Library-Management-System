<?php

include_once __DIR__ . '/../Model/db.php';

class BookController {

    public function allBooks(){

        return getBooks();
    }

    public function singleBook($id){

        return getSingleBook($id);
    }

    public function borrowBook($memberId, $bookId){

        $db = new db();
        $conn = $db->connection();

        $available = $db->isBookAvailable($conn, $bookId);

        if ($available <= 0) {
            return ["success" => false, "message" => "This book is currently unavailable."];
        }

        if ($db->hasActiveBorrow($conn, $memberId, $bookId)) {
            return ["success" => false, "message" => "You already have this book borrowed."];
        }

        $ok = $db->insertBorrowRecord($conn, $memberId, $bookId);

        if ($ok) {
            return ["success" => true, "message" => "Book borrowed successfully."];
        }

        return ["success" => false, "message" => "Something went wrong. Please try again."];
    }
}

?>