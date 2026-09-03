<?php

header("Content-Type: application/json");

include_once __DIR__ . "/../../Model/db.php";

$db = new db();
$conn = $db->connection();

$search = isset($_GET['q']) ? trim($_GET['q']) : '';

$result = $db->searchBooks($conn, $search);

$data = [];

if($result)
{
    while($row = $result->fetch_assoc())
    {
        $data[] = $row;
    }
}

echo json_encode($data);

?>