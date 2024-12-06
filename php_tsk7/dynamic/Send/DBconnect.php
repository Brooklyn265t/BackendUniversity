<?php
class DatabaseConnection {
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $conn;

    public function __construct($servername, $username, $password, $dbname) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }

    public function connect() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        return $this->conn;
    }

    public function close() {
        if ($this->conn !== null) {
            $this->conn->close();
        }
    }

    // Добавим метод для подготовки запросов
    public function prepare($sql) {
        return $this->conn->prepare($sql);
    }

    // Добавим метод для выполнения запросов
    public function query($stmt, ...$params) {
        foreach ($params as $param => $value) {
            $stmt->bind_param($param, $value);
        }
        $result = $stmt->execute();
        return $result ? $stmt->get_result() : false;
    }
}
?>