<?php
class Connection {
    private static $instance = null;
    private $conn = null;

    private function __construct($config)
    {
        // Kết nối database
        try {
            $this->conn = new mysqli($config['host'], $config['user'], $config['pass'], $config['db']);

            // Kiểm tra kết nối có thành công không
            if ($this->conn->connect_error) {
                $mess = $this->conn->connect_error;
                App::$app->loadError('database', ['message' => $mess]);
                die();
            }
        } catch (Exception $exception) {
            $mess = $exception->getMessage();
            App::$app->loadError('database', ['message' => $mess]);
            die();
        }
    }

    public static function getInstance($config)
    {
        if (self::$instance == null) {
            $connection = new Connection($config);
            self::$instance = $connection->getConnection();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}