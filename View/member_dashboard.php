<?php

include "../Config/Auth.php";

auth_check("member");

?>

<!DOCTYPE html>
<html>

<head>
    <title>Member Dashboard</title>

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
            max-width: 1000px;
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
            width: 33.33%;
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
            font-weight: 600;
            margin-bottom: 8px;
        }

        .card p{
            font-size: 14px;
            color: #666;
            margin-bottom: 1rem;
        }

        .card a{
            display: inline-block;
            text-decoration: none;
            background: #1a1a1a;
            color: #fff;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 14px;
            transition: opacity 0.15s;
        }

        .card a:hover{
            opacity: 0.8;
        }

        /* Borrowed books */

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

        .borrowed{
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

    <h1>Member Dashboard</h1>

    <h2>Dashboard Summary</h2>

    <table class="summary-table">

        <tr>
            <th>Active Loans</th>
            <th>Upcoming Due Dates</th>
            <th>Outstanding Fines</th>
        </tr>

        <tr>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>

    </table>

    <h2>Quick Actions</h2>

    <div class="card-grid">

        <div class="card">
            <h3>Browse Books</h3>
            <p>Search and explore available books in the library.</p>
            <a href="member_books.php">Open</a>
        </div>

        <div class="card">
            <h3>My Profile</h3>
            <p>Update your personal information and password.</p>
            <a href="Profile.php">Open</a>
        </div>

        <div class="card">
            <h3>Borrow History</h3>
            <p>View all previously borrowed and returned books.</p>
            <a href="History.php">Open</a>
        </div>

        <div class="card">
            <h3>My Fines</h3>
            <p>Check and manage your unpaid fines.</p>
            <a href="MyFines.php">Open</a>
        </div>

        <div class="card">
            <h3>Logout</h3>
            <p>Securely logout from your member account.</p>
            <a href="../Controller/logout.php">Logout</a>
        </div>

    </div>

    <h2>Recent Borrowed Books</h2>

    <div class="activity-box">

        <table class="activity-table">

            <tr>
                <th>Book Name</th>
                <th>Borrow Date</th>
                <th>Return Date</th>
                <th>Status</th>
            </tr>

            <tr>
                <td>Web Technology</td>
                <td>10 May 2026</td>
                <td>17 May 2026</td>
                <td>
                    <span class="status borrowed">
                        Borrowed
                    </span>
                </td>
            </tr>

            <tr>
                <td>Database Systems</td>
                <td>02 May 2026</td>
                <td>09 May 2026</td>
                <td>
                    <span class="status returned">
                        Returned
                    </span>
                </td>
            </tr>

        </table>

    </div>

</div>

<p style="text-align:center;margin-top:20px;"><a href="MyFines.php">My Fines</a></p>
</body>
</html>