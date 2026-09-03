<?php

include_once "../Config/Auth.php";

auth_check("librarian");

$totalBooks = 0;
$issuedToday = 0;
$returnedToday = 0;
$pendingReturns = 0;
$activities = null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librarian Dashboard</title>

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

        .dashboard-container{
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        h1{
            font-size: 24px;
            font-weight: 600;
            color: #1a1a1a;
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
            color: #1a1a1a;
            padding-top: 4px;
        }

        .card-grid{
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .card{
            background: #fff;
            border: 0.5px solid rgba(0,0,0,0.1);
            border-radius: 12px;
            padding: 1.5rem;
            transition: 0.2s;
        }

        .card:hover{
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.05);
        }

        .card h3{
            font-size: 17px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .card p{
            font-size: 14px;
            color: #666;
            margin-bottom: 1rem;
        }

        .card a,
        .card button{
            display: inline-block;
            text-decoration: none;
            background: #1a1a1a;
            color: #fff;
            border: none;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            transition: opacity 0.15s;
            font-family: inherit;
        }

        .card a:hover,
        .card button:hover{
            opacity: 0.8;
        }

        .activity-box{
            background: #fff;
            border: 0.5px solid rgba(0,0,0,0.1);
            border-radius: 12px;
            overflow: hidden;
        }

        .activity-table{
            width: 100%;
            border-collapse: collapse;
        }

        .activity-table th{
            background: #eceee8;
            padding: 12px 16px;
            text-align: left;
            font-size: 13px;
            color: #666;
        }

        .activity-table td{
            padding: 14px 16px;
            border-top: 0.5px solid rgba(0,0,0,0.08);
            font-size: 14px;
        }

        .status{
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 500;
        }

        .issued{
            background: #fff6e8;
            color: #c27c00;
        }

        .returned{
            background: #f0faf4;
            color: #1a7a40;
        }
    </style>
</head>

<body>

<div class="dashboard-container">

    <h1>Librarian Dashboard</h1>

    <h2>Dashboard Summary</h2>

    <table class="summary-table">
        <tr>
            <th>Total Books</th>
            <th>Issued Today</th>
            <th>Returned Today</th>
            <th>Pending Returns</th>
        </tr>

        <tr>
            <td><?= $totalBooks ?? 0 ?></td>
            <td><?= $issuedToday ?? 0 ?></td>
            <td><?= $returnedToday ?? 0 ?></td>
            <td><?= $pendingReturns ?? 0 ?></td>
        </tr>
    </table>

    <h2>Quick Actions</h2>

    <div class="card-grid">

        <div class="card">
            <h3>Manage Books</h3>
            <p>Add, edit and remove books from the library system.</p>
            <a href="../View/BookList.php">Open</a>
        </div>

        <div class="card">
            <h3>Logout</h3>
            <p>Securely logout from the librarian dashboard.</p>
            <a href="../Controller/logout.php">Logout</a>
        </div>

    </div>

    <h2>Recent Activities</h2>

    <div class="activity-box">

        <table class="activity-table">
            <tr>
                <th>Member</th>
                <th>Book</th>
                <th>Status</th>
                <th>Date</th>
            </tr>

            <?php if(isset($activities) && $activities && $activities->num_rows > 0) { ?>

                <?php while($row = $activities->fetch_assoc()) { ?>

                    <tr>
                        <td><?= htmlspecialchars($row['member_name']); ?></td>
                        <td><?= htmlspecialchars($row['book_title']); ?></td>

                        <td>
                            <?php if($row['status'] == "Returned") { ?>
                                <span class="status returned">Returned</span>
                            <?php } else { ?>
                                <span class="status issued">Issued</span>
                            <?php } ?>
                        </td>

                        <td>
                            <?= date("d M Y", strtotime($row['borrow_date'])); ?>
                        </td>
                    </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>
                    <td colspan="4">No recent activities found.</td>
                </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>