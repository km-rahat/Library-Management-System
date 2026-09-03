<?php

include_once '../Config/Auth.php';
include_once '../Controller/BookController.php';

auth_check("member");

$controller = new BookController();

$books = $controller->allBooks();

$successMsg = $_GET['success'] ?? '';
$errorMsg = $_GET['error'] ?? '';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Library Books</title>

    <style>

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body{

            font-family: Arial, Helvetica, sans-serif;

            background: linear-gradient(to right, #eef2ff, #dbeafe);

            min-height: 100vh;

            padding: 40px;
        }

        .container{

            width: 95%;

            max-width: 1200px;

            margin: auto;
        }

        .header{

            text-align: center;

            margin-bottom: 35px;
        }

        .header h1{

            font-size: 42px;

            color: #0f172a;

            margin-bottom: 10px;
        }

        .header p{

            color: #64748b;

            font-size: 16px;
        }

        .card{

            background: white;

            padding: 25px;

            border-radius: 18px;

            box-shadow: 0 10px 25px rgba(0,0,0,0.1);

            overflow-x: auto;
        }

        table{

            width: 100%;

            border-collapse: collapse;
        }

        th{

            background: #2563eb;

            color: white;

            padding: 16px;

            text-align: left;

            font-size: 15px;
        }

        th:first-child{

            border-top-left-radius: 10px;
        }

        th:last-child{

            border-top-right-radius: 10px;
        }

        td{

            padding: 16px;

            border-bottom: 1px solid #e5e7eb;

            color: #334155;

            font-size: 15px;
        }

        tr:hover{

            background: #f8fafc;

            transition: 0.3s;
        }

        .available{

            font-weight: bold;

            color: #16a34a;
        }

        .unavailable{

            font-weight: bold;

            color: #dc2626;
        }

        .btn-group{

            display: flex;

            gap: 10px;

            flex-wrap: wrap;
        }

        .details-btn{

            display: inline-block;

            text-decoration: none;

            background: #2563eb;

            color: white;

            padding: 10px 16px;

            border-radius: 8px;

            font-weight: bold;

            transition: 0.3s;
        }

        .details-btn:hover{

            background: #1d4ed8;
        }

        .borrow-btn{

            display: inline-block;

            text-decoration: none;

            background: #16a34a;

            color: white;

            padding: 10px 16px;

            border-radius: 8px;

            font-weight: bold;

            border: none;

            cursor: pointer;

            font-family: inherit;

            font-size: 15px;

            transition: 0.3s;
        }

        .borrow-btn:hover{

            background: #15803d;
        }

        .borrow-btn:disabled{

            background: #cbd5e1;

            cursor: not-allowed;
        }

        .top-bar{

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 10px;
        }

        .back-btn{

            display: inline-block;

            text-decoration: none;

            background: #ffffff;

            color: #2563eb;

            border: 1.5px solid #2563eb;

            padding: 9px 16px;

            border-radius: 8px;

            font-weight: bold;

            font-size: 14px;

            transition: 0.2s;
        }

        .back-btn:hover{

            background: #eff6ff;
        }

        .message-banner{

            max-width: 1200px;

            margin: 0 auto 20px auto;

            padding: 12px 18px;

            border-radius: 10px;

            font-size: 14px;

            font-weight: 600;
        }

        .message-success{

            background: #dcfce7;

            color: #166534;
        }

        .message-error{

            background: #fee2e2;

            color: #991b1b;
        }

        @media(max-width:768px){

            body{
                padding: 20px;
            }

            .header h1{
                font-size: 30px;
            }

            th, td{
                padding: 12px;
                font-size: 13px;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <div class="top-bar">

        <a class="back-btn" href="member_dashboard.php">← Back to Dashboard</a>

    </div>

    <?php if (!empty($successMsg)) { ?>
        <p class="message-banner message-success"><?= htmlspecialchars($successMsg); ?></p>
    <?php } ?>

    <?php if (!empty($errorMsg)) { ?>
        <p class="message-banner message-error"><?= htmlspecialchars($errorMsg); ?></p>
    <?php } ?>

    <div class="header">

        <h1>

            Library Books

        </h1>

        <p>

            Browse, borrow and manage books easily

        </p>

    </div>

    <div class="card">

        <table>

            <tr>

                <th>Title</th>

                <th>Author</th>

                <th>Available</th>

                <th>Action</th>

            </tr>

            <?php foreach($books as $book){ ?>

            <tr>

                <td>

                    <?= $book['title']; ?>

                </td>

                <td>

                    <?= $book['author']; ?>

                </td>

                <td>

                    <?php if($book['available_copies'] > 0){ ?>

                        <span class="available">

                            <?= $book['available_copies']; ?>

                        </span>

                    <?php } else { ?>

                        <span class="unavailable">

                            0

                        </span>

                    <?php } ?>

                </td>

                <td>

                    <div class="btn-group">

                        <a
                        class="details-btn"
                        href="book_details.php?id=<?= $book['id']; ?>"
                        >

                            Details

                        </a>

                        <?php if($book['available_copies'] > 0){ ?>

                            <a
                            class="borrow-btn"
                            href="../Controller/BorrowBookController.php?id=<?= $book['id']; ?>"
                            onclick="return confirm('Borrow this book?');"
                            >

                                Borrow

                            </a>

                        <?php } else { ?>

                            <button class="borrow-btn" disabled>

                                Unavailable

                            </button>

                        <?php } ?>

                    </div>

                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>