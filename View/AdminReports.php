<?php

include "../Config/Auth.php";
include_once "../Controller/UserController.php";
include_once "../Controller/BookController.php";

auth_check("admin");

$userController = new UserController();
$bookController = new BookController();

$stats = $userController->dashboardStats();
$users = $userController->allUsers();
$books = $bookController->allBooks();

$roleCounts = ["member" => 0, "librarian" => 0, "admin" => 0];
foreach ($users as $u) {
    if (isset($roleCounts[$u['role']])) {
        $roleCounts[$u['role']]++;
    }
}

$outOfStock = array_filter($books, function ($b) {
    return $b['available_copies'] <= 0;
});

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Reports</title>

    <style>
        *, *::before, *::after{
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body{
            font-family: 'Segoe UI', system-ui, sans-serif;
            font-size: 15px;
            line-height: 1.6;
            background: #f4f4f1;
            color: #1a1a1a;
            min-height: 100vh;
            padding: 2rem 1rem;
        }

        .container{
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .top-bar{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        h1{
            font-size: 24px;
            font-weight: 600;
        }

        .back-btn{
            background: #ffffff;
            color: #1a3a5c;
            border: 1.5px solid #1a3a5c;
            border-radius: 8px;
            padding: 10px 16px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .back-btn:hover{
            background: #dde3eb;
        }

        h2{
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #888;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        h2::after{
            content: '';
            flex: 1;
            height: 0.5px;
            background: rgba(0,0,0,0.1);
        }

        .summary-table{
            width: 100%;
            border-collapse: separate;
            border-spacing: 12px 0;
            margin: 0 -12px;
        }

        .summary-table th,
        .summary-table td{
            background: #eceee8;
            border-radius: 8px;
            padding: 1rem;
            width: 25%;
            text-align: left;
        }

        .summary-table th{
            font-size: 12px;
            font-weight: 500;
            color: #666;
            padding-bottom: 4px;
        }

        .summary-table td{
            font-size: 28px;
            font-weight: 600;
            padding-top: 4px;
        }

        .box{
            background: #fff;
            border: 0.5px solid rgba(0,0,0,0.1);
            border-radius: 12px;
            overflow: hidden;
        }

        table.data{
            width: 100%;
            border-collapse: collapse;
        }

        table.data th{
            background: #eceee8;
            padding: 12px 16px;
            text-align: left;
            font-size: 13px;
            color: #666;
        }

        table.data td{
            padding: 14px 16px;
            border-top: 0.5px solid rgba(0,0,0,0.08);
            font-size: 14px;
        }

        .empty-row td{
            text-align: center;
            color: #888;
            padding: 20px;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="top-bar">
        <h1>Admin Reports</h1>
        <a class="back-btn" href="admin_dashboard.php">Back</a>
    </div>

    <h2>Overview</h2>

    <table class="summary-table">
        <tr>
            <th>Total Users</th>
            <th>Total Books</th>
            <th>Issued Books</th>
            <th>Out of Stock Titles</th>
        </tr>
        <tr>
            <td><?= (int)$stats['total_users']; ?></td>
            <td><?= (int)$stats['total_books']; ?></td>
            <td><?= (int)$stats['issued_books']; ?></td>
            <td><?= count($outOfStock); ?></td>
        </tr>
    </table>

    <h2>Users by Role</h2>

    <div class="box">
        <table class="data">
            <tr>
                <th>Role</th>
                <th>Count</th>
            </tr>
            <?php foreach ($roleCounts as $role => $count) { ?>
                <tr>
                    <td><?= htmlspecialchars(ucfirst($role)); ?></td>
                    <td><?= (int)$count; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <h2>Out of Stock Books</h2>

    <div class="box">
        <table class="data">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Total Copies</th>
            </tr>

            <?php if (count($outOfStock) > 0) { ?>

                <?php foreach ($outOfStock as $b) { ?>
                    <tr>
                        <td><?= htmlspecialchars($b['title']); ?></td>
                        <td><?= htmlspecialchars($b['author']); ?></td>
                        <td><?= (int)$b['total_copies']; ?></td>
                    </tr>
                <?php } ?>

            <?php } else { ?>

                <tr class="empty-row">
                    <td colspan="3">Every title has at least one copy available.</td>
                </tr>

            <?php } ?>

        </table>
    </div>

</div>

</body>
</html>
