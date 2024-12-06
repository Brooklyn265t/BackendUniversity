<?php
class CoffeeModel
{
    private $db;

    public function __construct($host, $username, $password, $dbname)
    {
        $this->db = new mysqli($host, $username, $password, $dbname);
        if ($this->db->connect_error) {
            throw new Exception("Ошибка подключения к базе данных");
        }
        $this->db->set_charset("utf8mb4");
    }

    public function createCoffee(string $name): bool
    {
        $sql = "INSERT INTO coffee(name) VALUES (?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $name);
        return $stmt->execute();
    }

    public function getCoffeeById(int $id): array
    {
        $sql = "SELECT name FROM coffee WHERE Coffee_ID = ?";
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

    public function updateCoffee(int $id, string $name): bool
    {
        $sql = "UPDATE coffee SET name = ? WHERE Coffee_ID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("si", $name, $id);
        return $stmt->execute();
    }

    public function deleteCoffee(int $id): bool
    {
        $sql = "DELETE FROM coffee WHERE Coffee_ID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getAllCoffees(): array
    {
        $result = $this->db->query("SELECT * FROM coffee");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>