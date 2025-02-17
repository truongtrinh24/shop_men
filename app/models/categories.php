
<?php
class Categories {
    private $conn;
    public function __construct() {
        global $db_config;
        $this->conn = Connection::getInstance($db_config);
    }

    public function getAllCategories() {
        $sql = 'SELECT * FROM categories';
        $result = $this->conn->query($sql);
        if($result) {
            $data = array();
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
}