<?php

include_once __DIR__ . '/../Model/db.php';

class UserController {

    // Whitelist — prevents an edit form from setting an arbitrary role.
    private $allowedRoles = ["member", "librarian", "admin"];

    public function allUsers()
    {
        $db = new db();
        $conn = $db->connection();

        $result = $db->getAllUsers($conn);

        $users = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }

        return $users;
    }

    public function searchUsers($search)
    {
        $db = new db();
        $conn = $db->connection();

        $result = $db->searchUsers($conn, $search);

        $users = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }

        return $users;
    }

    public function singleUser($id)
    {
        $db = new db();
        $conn = $db->connection();

        $result = $db->getUserById($conn, $id);

        return $result ? $result->fetch_assoc() : null;
    }

    public function deleteUser($id)
    {
        $db = new db();
        $conn = $db->connection();

        return $db->deleteUser($conn, $id);
    }

    public function updateUser($id, $name, $email, $phone, $role)
    {
        if (!in_array($role, $this->allowedRoles, true)) {
            return false;
        }

        $db = new db();
        $conn = $db->connection();

        return $db->updateUserFull($conn, $id, $name, $email, $phone, $role);
    }

    public function dashboardStats()
    {
        $db = new db();
        $conn = $db->connection();

        return $db->getDashboardStats($conn);
    }

    public function allowedRoles()
    {
        return $this->allowedRoles;
    }
}

?>
