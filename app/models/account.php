<?php
class Account
{
    private $__conn;

    function __construct()
    {
        global $db_config;
        $this->__conn = Connection::getInstance($db_config);
    }

    public function addAccount($username, $password, $role_id, $status_account)
    {
        $sql = 'INSERT INTO account(username, password, role_id, status_account) VALUES(?, ?, ?, ?)';
        $stmt = $this->__conn->prepare($sql);
        if (!$stmt) {
            die('Prepare failed: ' . $this->__conn->error);
        }
        $stmt->bind_param('ssii', $username, $password, $role_id, $status_account);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        return false;
    }

    public static function updateStatus($id, $status)
    {
        $db = new DB();
        return $db->table('account')->where('id', '=', $id)->update(['is_active' => $status]);
    }

    public static function countByRole($role_id)
    {
        global $db_config;
        $conn = Connection::getInstance($db_config);

        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM account WHERE role_id = ?");
        $stmt->bind_param("i", $role_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['total'] ?? 0;
    }

}