<?php

include "../Config/Auth.php";
include_once "../Controller/UserController.php";

auth_check("admin");

$controller = new UserController();

$id = $_GET['id'] ?? null;
$user = $id ? $controller->singleUser($id) : null;

if (!$user) {
    echo "User not found";
    exit();
}

$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            font-size: 15px;
            line-height: 1.6;
            background: #f4f4f1;
            color: #1a1a1a;
            min-height: 100vh;
            padding: 2rem 1rem;
        }

        .form-container {
            max-width: 520px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        h1 {
            font-size: 22px;
            font-weight: 600;
        }

        .error {
            background: #fff0f0;
            color: #c0392b;
            border: 0.5px solid #f5c6c6;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
        }

        .success {
            background: #f0faf4;
            color: #1a7a40;
            border: 0.5px solid #b7e4c7;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
        }

        form {
            background: #fff;
            border: 0.5px solid rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .field-table {
            width: 100%;
            border-collapse: collapse;
        }

        .field-table tr td:first-child {
            width: 120px;
            font-size: 13px;
            color: #666;
            padding: 8px 0;
            vertical-align: middle;
        }

        .field-table tr td:last-child {
            padding: 8px 0;
        }

        .field-table input[type="text"],
        .field-table input[type="email"],
        .field-table select {
            width: 100%;
            padding: 8px 12px;
            font-size: 14px;
            color: #1a1a1a;
            background: #fff;
            border: 0.5px solid rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            outline: none;
            font-family: inherit;
        }

        .field-table input[type="submit"] {
            padding: 9px 22px;
            font-size: 14px;
            font-weight: 500;
            background: #1a1a1a;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-family: inherit;
        }

        .back-link {
            color: #1a1a1a;
            text-decoration: none;
            font-size: 14px;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="form-container">

    <h1>Edit User</h1>

    <?php if (!empty($error)) { ?>
        <p class="error"><?= htmlspecialchars($error); ?></p>
    <?php } ?>

    <?php if (!empty($success)) { ?>
        <p class="success"><?= htmlspecialchars($success); ?></p>
    <?php } ?>

    <form method="post" action="../Controller/EditUserValid.php">

        <input type="hidden" name="id" value="<?= (int)$user['id']; ?>">

        <table class="field-table">

            <tr>
                <td>Name</td>
                <td>
                    <input type="text" name="name" required
                    value="<?= htmlspecialchars($user['name'] ?? ''); ?>">
                </td>
            </tr>

            <tr>
                <td>Email</td>
                <td>
                    <input type="email" name="email" required
                    value="<?= htmlspecialchars($user['email'] ?? ''); ?>">
                </td>
            </tr>

            <tr>
                <td>Phone</td>
                <td>
                    <input type="text" name="phone" required
                    value="<?= htmlspecialchars($user['phone'] ?? ''); ?>">
                </td>
            </tr>

            <tr>
                <td>Role</td>
                <td>
                    <select name="role">
                        <?php foreach (["member", "librarian", "admin"] as $r) { ?>
                            <option value="<?= $r; ?>" <?= ($user['role'] == $r) ? 'selected' : ''; ?>>
                                <?= $r; ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td colspan="2" style="text-align: right; padding-top: 8px;">
                    <input type="submit" value="Save changes">
                </td>
            </tr>

        </table>

    </form>

    <a class="back-link" href="Users.php">Back to Users</a>

</div>

</body>
</html>
