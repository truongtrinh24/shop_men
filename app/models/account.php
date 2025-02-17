<?php
class Account {
    private $__conn;

    function __construct(){
        global $db_config;
        $this->__conn = Connection::getInstance($db_config);
    }

    public function addAccount($username, $password, $role_id, $status_account) {
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
}