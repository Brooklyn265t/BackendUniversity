<?php
class UploadFile {
    private $conn;
    public function __construct(DatabaseConnection $conn) {
        $this->conn = $conn;
    }

    public function post($fileData) {
        if (isset($_POST["submit"])) {
            // Проверка на ошибки загрузки файла
            if ($_FILES["fileToUpload"]["error"] !== UPLOAD_ERR_OK) {
                die("Ошибка при загрузке файла: " . $_FILES["fileToUpload"]["error"]);
            }

            // Проверка, является ли файл PDF
            $fileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
            if ($fileType != "pdf") {
                echo "Недопустимый тип файла. Разрешены только PDF файлы.";
                return;
            }

            // Получение содержимого файла
            $filename = $_FILES["fileToUpload"]["name"];
            $mimetype = $_FILES["fileToUpload"]["type"];

            // Подготовка SQL-запроса для вставки данных
            $stmt = $this->conn->prepare("INSERT INTO pdf (filename, mimetype, data) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $filename, $mimetype, $fileData);

            // Выполнение запроса
            if ($stmt->execute()) {
                echo "Файл загружен и информация сохранена в базе данных.";
            } else {
                echo "Ошибка при сохранении информации в базе данных: " . $this->conn->error;
            }
            $stmt->close();
        }
    }
}
?>