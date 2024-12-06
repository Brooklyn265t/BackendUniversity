<?php
// Подключение к базе данных
$servername = "database"; // Укажите ваш сервер
$username = "user"; // Укажите ваше имя пользователя
$password = "password"; // Укажите ваш пароль
$dbname = "coffeeprice"; // Укажите имя вашей базы данных

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получение ID файла из URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Преобразуем в целое число для безопасности

    // Запрос к базе данных для получения информации о файле
    $sql = "SELECT filename, mimetype, data FROM pdf WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($filename, $mimetype, $data);
    $stmt->fetch();
    $stmt->close();

    // Проверка, существует ли файл
    if ($filename && $data) {
        // Установка заголовков для скачивания
        header('Content-Description: File Transfer');
        header('Content-Type: ' . $mimetype);
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($data));

        // Отправка файла
        echo $data;
        exit;
    } else {
        echo "Файл не найден.";
    }
} else {
    echo "Некорректный запрос.";
}

// Закрытие соединения
$conn->close();
?>

<?php
$servername = "database"; // Укажите ваш сервер
$username = "user"; // Укажите ваше имя пользователя
$password = "password"; // Укажите ваш пароль
$dbname = "coffeeprice"; // Укажите имя вашей базы данных

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Запрос для получения всех PDF-файлов
$sql = "SELECT id, filename FROM pdf";
$result = $conn->query($sql);

// Проверка наличия записей
if ($result->num_rows > 0) {
    // Вывод ссылок для скачивания
    while ($row = $result->fetch_assoc()) {
        echo '<a href="download.php?id=' . $row['id'] . '">Скачать ' . htmlspecialchars($row['filename']) . '</a><br>';
    }
} else {
    echo "Нет доступных PDF-файлов для скачивания.";
}

// Закрытие соединения
$conn->close();
?>
<?php
$dir = $_SERVER["DOCUMENT_ROOT"];
$dir_content = scandir($dir);
foreach ($dir_content as $item){
    if($item != "." && $item != ".."){
        echo "<a href='./$item'>$item</a><br>";
    }
}
?>