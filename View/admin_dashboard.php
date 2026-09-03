<?php
    include "../Config/Auth.php";
    include_once "../Controller/UserController.php";

    auth_check("admin");

    $userController = new UserController();
    $stats = $userController->dashboardStats();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

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

        /* Summary cards */

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

        /* Cards */

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
            margin-bottom: 8px;
            font-weight: 600;
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

        /* Activity Table */

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

        .active{
            background: #f0faf4;
            color: #1a7a40;
        }

        .pending{
            background: #fff6e8;
            color: #c27c00;
        }


        .report-link{
    text-align: center;
    margin-top: 20px;
    }

    .report-link a{
        background: #1a3a5c;
        color: white;
        padding: 10px 18px;
        border-radius: 6px;
        text-decoration: none;
    }

    .report-link a:hover{
        background: #10263d;
    }

    </style>

</head>

<body>

<div class="dashboard-container">

    <h1>Admin Dashboard</h1>

    <h2>Dashboard Summary</h2>

    <table class="summary-table">

        <tr>
            <th>Total Users</th>
            <th>Total Books</th>
            <th>Issued Books</th>
            <th>Pending Returns</th>
        </tr>

        <tr>
            <td><?= (int)$stats['total_users']; ?></td>
            <td><?= (int)$stats['total_books']; ?></td>
            <td><?= (int)$stats['issued_books']; ?></td>
            <td><?= (int)$stats['pending_returns']; ?></td>
        </tr>

    </table>


    <h2>Quick Actions</h2>

    <div class="card-grid">

        <div class="card">
            <h3>Manage Books</h3>
            <p>Add, update or remove books from the system.</p>

            <a href="../View/BookList.php">Open</a>
        </div>

        <div class="card">
            <h3>Manage Users</h3>
            <p>View all users and manage account information.</p>
            <a href="../View/Users.php">Open</a>
        </div>

        
        <div class="card">
            <h3>Logout</h3>
            <p>Securely logout from the admin dashboard.</p>
            <a href="../Controller/logout.php">Logout</a>
        </div>

    </div>


    <h2>Recent Activities</h2>

    <div class="activity-box">

        <table class="activity-table">

            <tr>
                <th>User</th>
                <th>Activity</th>
                <th>Status</th>
                <th>Date</th>
            </tr>

            <tr>
                <td>Shakil Ahmed</td>
                <td>Issued "Database Systems"</td>
                <td><span class="status active">Completed</span></td>
                <td>13 May 2026</td>
            </tr>

            <tr>
                <td>Nusrat Jahan</td>
                <td>Requested new membership</td>
                <td><span class="status pending">Pending</span></td>
                <td>12 May 2026</td>
            </tr>

            <tr>
                <td>Rakib Hasan</td>
                <td>Returned "Web Technology"</td>
                <td><span class="status active">Completed</span></td>
                <td>11 May 2026</td>
            </tr>

        </table>

    </div>

</div>

<p class="report-link">
    <a href="AdminReports.php">Admin Reports</a>
</p>

</body>
</html>
