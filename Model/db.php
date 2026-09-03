<?php

class db
{
    public function connection()
    {
        $db_host = "localhost";
        $db_user = "root";
        $db_password = "";
        $db_name = "webtech";

        $connection = new mysqli(
            $db_host,
            $db_user,
            $db_password,
            $db_name
        );

        if ($connection->connect_error) {
            die("Could not Connect Database " . $connection->connect_error);
        }

        return $connection;
    }

    /* =========================
       AUTH
    ========================= */

    public function signin($connection, $tablename, $email)
    {
        $email = $connection->real_escape_string($email);
        $sql = "SELECT * FROM " . $tablename . " WHERE email='" . $email . "'";
        return $connection->query($sql);
    }

    public function CheckUser($connection, $tablename, $email)
    {
        $email = $connection->real_escape_string($email);
        $sql = "SELECT * FROM " . $tablename . " WHERE email='" . $email . "'";
        return $connection->query($sql);
    }

    public function WithSQLInjection($connection, $tablename, $name, $email, $phone, $password, $role, $date)
    {
        $sql = "INSERT INTO " . $tablename . " (name, email, phone, password_hash, role, created_at) VALUES (?,?,?,?,?,?)";

        $statement = $connection->prepare($sql);
        $statement->bind_param("ssssss", $name, $email, $phone, $password, $role, $date);

        return $statement->execute();
    }

    public function getUserById($connection, $id)
    {
        $id = (int)$id;
        $sql = "SELECT * FROM members WHERE id='$id'";
        return $connection->query($sql);
    }

    public function updateProfile($connection, $id, $name, $email, $phone)
    {
        $id = (int)$id;
        $name = $connection->real_escape_string($name);
        $email = $connection->real_escape_string($email);
        $phone = $connection->real_escape_string($phone);

        $sql = "UPDATE members
        SET
        name='$name',
        email='$email',
        phone='$phone'
        WHERE id='$id'
        ";

        return $connection->query($sql);
    }

    public function updatePassword($connection, $id, $newPassword)
    {
        $id = (int)$id;
        $newPassword = $connection->real_escape_string($newPassword);

        $sql = "
        UPDATE members
        SET password_hash='$newPassword'
        WHERE id='$id'
        ";

        return $connection->query($sql);
    }

    /* =========================
       BOOKS (browsing)
    ========================= */

    public function GetBooks($connection)
    {
        $sql = "
        SELECT
            books.id,
            books.title,
            books.author,
            books.isbn,
            books.total_copies,

            genres.genre_name,

            (
                books.total_copies -
                COUNT(
                    CASE
                    WHEN borrow_records.status='Active'
                    THEN 1
                    END
                )
            ) AS available_copies

        FROM books

        LEFT JOIN genres
        ON books.genre_id = genres.id

        LEFT JOIN borrow_records
        ON books.id = borrow_records.book_id

        GROUP BY books.id
        ";

        return $connection->query($sql);
    }

    public function searchBooks($connection, $search)
    {
        $search = $connection->real_escape_string($search);

        $sql = "
        SELECT
            books.id,
            books.title,
            books.author,
            books.isbn,
            books.total_copies,

            genres.genre_name,

            (
                books.total_copies -
                COUNT(
                    CASE
                    WHEN borrow_records.status='Active'
                    THEN 1
                    END
                )
            ) AS available_copies

        FROM books

        LEFT JOIN genres
        ON books.genre_id = genres.id

        LEFT JOIN borrow_records
        ON books.id = borrow_records.book_id

        WHERE
            books.title LIKE '%$search%'
            OR books.author LIKE '%$search%'
            OR books.isbn LIKE '%$search%'

        GROUP BY books.id
        ";

        return $connection->query($sql);
    }

    /* =========================
       BORROWING (member)
    ========================= */

    public function isBookAvailable($connection, $bookId)
    {
        $bookId = (int)$bookId;

        $sql = "
        SELECT
            books.total_copies -
            COUNT(CASE WHEN borrow_records.status='Active' THEN 1 END) AS available_copies
        FROM books
        LEFT JOIN borrow_records ON books.id = borrow_records.book_id
        WHERE books.id = ?
        GROUP BY books.id
        ";

        $statement = $connection->prepare($sql);
        $statement->bind_param("i", $bookId);
        $statement->execute();
        $result = $statement->get_result();
        $row = $result ? $result->fetch_assoc() : null;

        return $row ? (int)$row['available_copies'] : 0;
    }

    public function hasActiveBorrow($connection, $memberId, $bookId)
    {
        $memberId = (int)$memberId;
        $bookId = (int)$bookId;

        $sql = "SELECT id FROM borrow_records WHERE member_id=? AND book_id=? AND status='Active' LIMIT 1";

        $statement = $connection->prepare($sql);
        $statement->bind_param("ii", $memberId, $bookId);
        $statement->execute();
        $result = $statement->get_result();

        return $result && $result->num_rows > 0;
    }

    public function insertBorrowRecord($connection, $memberId, $bookId)
    {
        $memberId = (int)$memberId;
        $bookId = (int)$bookId;

        $sql = "INSERT INTO borrow_records (book_id, member_id, status, borrow_date) VALUES (?, ?, 'Active', CURDATE())";

        $statement = $connection->prepare($sql);
        $statement->bind_param("ii", $bookId, $memberId);

        return $statement->execute();
    }

    /* =========================
       USERS (admin management)
       New methods added for the Admin panel.
    ========================= */

    public function getAllUsers($connection)
    {
        $sql = "
        SELECT id, name, email, phone, role, created_at
        FROM members
        ORDER BY id DESC
        ";

        return $connection->query($sql);
    }

    public function searchUsers($connection, $search)
    {
        $search = $connection->real_escape_string($search);

        $sql = "
        SELECT id, name, email, phone, role, created_at
        FROM members
        WHERE
            name LIKE '%$search%'
            OR email LIKE '%$search%'
            OR phone LIKE '%$search%'
            OR role LIKE '%$search%'
        ORDER BY id DESC
        ";

        return $connection->query($sql);
    }

    public function deleteUser($connection, $id)
    {
        $id = (int)$id;

        $sql = "DELETE FROM members WHERE id=?";
        $statement = $connection->prepare($sql);
        $statement->bind_param("i", $id);

        return $statement->execute();
    }

    public function updateUserFull($connection, $id, $name, $email, $phone, $role)
    {
        $id = (int)$id;

        $sql = "UPDATE members SET name=?, email=?, phone=?, role=? WHERE id=?";
        $statement = $connection->prepare($sql);
        $statement->bind_param("ssssi", $name, $email, $phone, $role, $id);

        return $statement->execute();
    }

    /* =========================
       DASHBOARD STATS (admin)
       NOTE: "issued_books" / "pending_returns" assume a borrow_records
       table with a "status" column ('Active' = currently issued).
       There's no due-date column visible anywhere else in this project,
       so "pending_returns" here is left as a safe placeholder (0) —
       wire it up once you confirm the real column name for due dates.
    ========================= */

    public function getDashboardStats($connection)
    {
        $stats = [
            "total_users"     => 0,
            "total_books"     => 0,
            "issued_books"    => 0,
            "pending_returns" => 0
        ];

        $r = $connection->query("SELECT COUNT(*) AS c FROM members");
        if ($r) $stats["total_users"] = (int)$r->fetch_assoc()["c"];

        $r = $connection->query("SELECT COUNT(*) AS c FROM books");
        if ($r) $stats["total_books"] = (int)$r->fetch_assoc()["c"];

        $r = $connection->query("SELECT COUNT(*) AS c FROM borrow_records WHERE status='Active'");
        if ($r) $stats["issued_books"] = (int)$r->fetch_assoc()["c"];

        // Placeholder until a due_date column is confirmed in borrow_records.
        $stats["pending_returns"] = 0;

        return $stats;
    }
}

/* =========================
   Procedural helpers
   (used by Controller/BookController.php)
========================= */

function getBooks()
{
    $db = new db();
    $conn = $db->connection();

    $result = $db->GetBooks($conn);

    $books = [];
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }

    return $books;
}

function getSingleBook($id)
{
    $db = new db();
    $conn = $db->connection();

    $id = (int)$id;

    $sql = "
    SELECT
        books.*,
        (
            books.total_copies -
            COUNT(
                CASE
                WHEN borrow_records.status='Active'
                THEN 1
                END
            )
        ) AS available_copies

    FROM books

    LEFT JOIN borrow_records
    ON books.id = borrow_records.book_id

    WHERE books.id='$id'

    GROUP BY books.id
    ";

    $result = $conn->query($sql);

    return $result ? $result->fetch_assoc() : null;
}

?>
