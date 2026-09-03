<?php

include "../Config/Auth.php";
include_once "../Controller/UserController.php";

auth_check("admin");

$controller = new UserController();
$users = $controller->allUsers();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>

    <style>
        *{
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body{
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f0f4f8;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .page-wrapper{
            max-width: 1200px;
            margin: 0 auto;
        }

        .top-bar{
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
        }

        .page-title{
            font-size: 26px;
            font-weight: 600;
            color: #1a3a5c;
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
            transition: 0.2s;
        }

        .back-btn:hover{
            background: #dde3eb;
            transform: translateY(-1px);
        }

        .search-box{
            margin-bottom: 22px;
        }

        #search{
            width: 100%;
            max-width: 420px;
            padding: 12px 15px;
            border: 1px solid #c8d0da;
            border-radius: 10px;
            font-size: 14px;
            background: #ffffff;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        #search:focus{
            border-color: #1a3a5c;
            box-shadow: 0 0 0 3px rgba(26, 58, 92, 0.1);
        }

        .table-container{
            background: #ffffff;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #dde3eb;
        }

        table{
            width: 100%;
            border-collapse: collapse;
        }

        thead{
            background: #1a3a5c;
            color: white;
        }

        th{
            padding: 15px;
            text-align: left;
            font-size: 14px;
            font-weight: 600;
        }

        td{
            padding: 14px 15px;
            font-size: 14px;
            color: #333;
            border-top: 1px solid #edf1f5;
        }

        tr:hover td{
            background: #f8fafc;
        }

        .role-badge{
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 500;
        }

        .role-admin{
            background: #fdecea;
            color: #c0392b;
        }

        .role-librarian{
            background: #fff6e8;
            color: #c27c00;
        }

        .role-member{
            background: #f0faf4;
            color: #1a7a40;
        }

        .action-link{
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
            margin-right: 8px;
        }

        .edit-link{
            color: #1a3a5c;
        }

        .delete-link{
            color: #c0392b;
        }

        .action-link:hover{
            text-decoration: underline;
        }

        .error-banner{
            background: #fff0f0;
            color: #c0392b;
            border: 0.5px solid #f5c6c6;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 18px;
        }
    </style>
</head>

<body>

<div class="page-wrapper">

    <div class="top-bar">
        <h1 class="page-title">Manage Users</h1>

        <a class="back-btn" href="admin_dashboard.php">
            Back
        </a>
    </div>

    <?php if (!empty($_GET['error'])) { ?>
        <p class="error-banner"><?= htmlspecialchars($_GET['error']); ?></p>
    <?php } ?>

    <div class="search-box">
        <input
            type="text"
            id="search"
            placeholder="Search by name, email, phone or role..."
            onkeyup="searchUsers()"
        >
    </div>

    <div class="table-container">

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody id="tableBody">

                <?php foreach ($users as $row) { ?>

                    <?php $roleClass = "role-" . htmlspecialchars($row["role"]); ?>

                    <tr>

                        <td><?= htmlspecialchars($row["name"]); ?></td>

                        <td><?= htmlspecialchars($row["email"]); ?></td>

                        <td><?= htmlspecialchars($row["phone"]); ?></td>

                        <td>
                            <span class="role-badge <?= $roleClass; ?>">
                                <?= htmlspecialchars($row["role"]); ?>
                            </span>
                        </td>

                        <td><?= htmlspecialchars($row["created_at"] ?? ''); ?></td>

                        <td>
                            <a
                                class="action-link edit-link"
                                href="EditUser.php?id=<?= (int)$row["id"]; ?>"
                            >
                                Edit
                            </a>

                            |

                            <a
                                class="action-link delete-link"
                                href="../Controller/DeleteUserController.php?id=<?= (int)$row["id"]; ?>"
                                onclick="return confirm('Delete this user? This cannot be undone.');"
                            >
                                Delete
                            </a>
                        </td>

                    </tr>

                <?php } ?>

            </tbody>
        </table>

    </div>

</div>

<script>

function searchUsers()
{
    let search = document.getElementById("search").value;

    if (search == "")
    {
        location.reload();
        return;
    }

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200)
        {
            let users = JSON.parse(this.responseText);

            let output = "";

            users.forEach(user => {

                let roleClass = "role-" + user.role;

                output += `
                <tr>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${user.phone}</td>
                    <td><span class="role-badge ${roleClass}">${user.role}</span></td>
                    <td>${user.created_at ?? ''}</td>
                    <td>
                        <a class="action-link edit-link"
                           href="EditUser.php?id=${user.id}">
                            Edit
                        </a>

                        |

                        <a class="action-link delete-link"
                           href="../Controller/DeleteUserController.php?id=${user.id}"
                           onclick="return confirm('Delete this user? This cannot be undone.');">
                            Delete
                        </a>
                    </td>
                </tr>
                `;
            });

            document.getElementById("tableBody").innerHTML = output;
        }
    }

    xhttp.open("GET", "../api/users/search.php?q=" + encodeURIComponent(search), true);
    xhttp.send();
}

</script>

</body>
</html>
