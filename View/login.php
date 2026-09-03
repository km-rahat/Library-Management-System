<?php

session_start();

$isloggedIn = $_SESSION["loggedIn"] ?? false;

if ($isloggedIn) {
    $role = $_SESSION["role"] ?? "";

    if ($role == "member") {
        header("Location: member_dashboard.php");
        exit();
    } elseif ($role == "librarian") {
        header("Location: librarian_dashboard.php");
        exit();
    } elseif ($role == "admin") {
        header("Location: admin_dashboard.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../View/css/style.css">
    <title>Login</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f0f4f8;
            min-height: 100vh;
        }

        .container {
            background: #1a3a5c;
            color: #e6f1fb;
            text-align: center;
            padding: 1.2rem 2rem;
        }

        .container h1 {
            font-size: 22px;
            font-weight: 500;
        }

        .login-container {
            max-width: 420px;
            margin: 3rem auto;
            background: #ffffff;
            border: 1px solid #dde3eb;
            border-radius: 12px;
            padding: 2rem 2.5rem;
        }

        .login-container h1 {
            font-size: 20px;
            font-weight: 500;
            color: red;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eaecf0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table tr td {
            padding: 6px 4px;
            vertical-align: middle;
        }

        td:first-child {
            font-size: 13px;
            font-weight: 500;
            color: #555;
            white-space: nowrap;
            padding-right: 12px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 9px 12px;
            font-size: 14px;
            font-family: inherit;
            background: #f7f9fc;
            color: #1a1a1a;
            border: 1px solid #c8d0da;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #185fa5;
            box-shadow: 0 0 0 3px rgba(24, 95, 165, 0.12);
            background: #fff;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background: #1a3a5c;
            color: #e6f1fb;
            font-size: 15px;
            font-weight: 500;
            font-family: inherit;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.15s, transform 0.1s;
        }

        input[type="submit"]:hover {
            background: #133055;
        }

        input[type="submit"]:active {
            transform: scale(0.98);
        }

        a {
            color: #185fa5;
            font-size: 13px;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Welcome to Bashundhara Library</h1>
    </div>

    <div class="login-container">

        <form method="post" action="../Controller/loginValid.php">

            <h1>Login Page</h1>

            <table>
                <tr>
                    <td>Email:</td>
                    <td>
                        <input type="email" name="email" required>
                    </td>
                </tr>

                <tr>
                    <td>Password:</td>
                    <td>
                        <input type="password" name="password" required>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <a href="registration.php">Not Registered? Register here</a>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <input type="submit" value="Login">
                    </td>
                </tr>
            </table>

        </form>

    </div>

</body>
</html>