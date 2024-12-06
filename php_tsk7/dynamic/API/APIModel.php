<?php
class UserModel {
    private $db;

    public function __construct($host, $username, $password, $dbname) {
        $this->db = new mysqli($host, $username, $password, $dbname);
        if ($this->db->connect_error) {
            throw new Exception("Ошибка подключения к базе данных");
        }
        $this->db->set_charset("utf8mb4");
    }

    public function createUser($name, $surname, $phone): bool
    {
        $sql = "INSERT INTO user(name, surname, phone) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sss", $name, $surname, $phone);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function getUserById(int $id): array {
        $sql = "SELECT name, surname, phone FROM user WHERE User_ID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);

        // Выполняем запрос
        if ($stmt->execute()) {
            // Получаем результат
            $result = $stmt->get_result(); // Получаем объект результата
            $row = $result->fetch_assoc(); // Извлекаем ассоциативный массив
            $stmt->close();
            return $row ?? []; // Возвращаем результат или пустой массив
        } else {
            // Обработка ошибки выполнения запроса
            $stmt->close();
            return []; // Возвращаем пустой массив в случае ошибки
        }
    }


    public function updateUser(int $id, string $name): bool {
        $sql = "UPDATE user SET name = ? WHERE User_ID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("si", $name, $id);
        $result = $stmt->execute();
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $affected_rows > 0;
    }

    public function deleteUser(int $id): bool {
        $sql = "DELETE FROM user WHERE User_ID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $affected_rows = $stmt->execute();
        $stmt->close();
        return $affected_rows > 0;
    }

    public function getAllUsers(): array {
        $result = $this->db->query("SELECT * FROM user");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>