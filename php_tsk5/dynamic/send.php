<html lang="en">
    <head>
        <title>I want eat pdf</title>
    </head>
    <body>
    <?php
    $dir = $_SERVER["DOCUMENT_ROOT"];
    $dir_content = scandir($dir);
    foreach ($dir_content as $item){
        if($item != "." && $item != ".."){
            echo "<a href='./$item'>$item</a><br>";
        }
    }
    ?>
    <form action="send.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="fileToUpload">
        <input type="submit" value="Upload File" name="submit">
    </form>

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
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST["submit"])) {
        // Проверка на ошибки загрузки файла
        if ($_FILES["fileToUpload"]["error"] !== UPLOAD_ERR_OK) {
            die("Ошибка при загрузке файла: " . $_FILES["fileToUpload"]["error"]);
        }

        // Проверка, является ли файл PDF
        $fileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
        if ($fileType == "pdf") {
            // Получение содержимого файла
            $fileData = file_get_contents($_FILES["fileToUpload"]["tmp_name"]);
            $filename = $_FILES["fileToUpload"]["name"];
            $mimetype = $_FILES["fileToUpload"]["type"];

            // Подготовка SQL-запроса для вставки данных
            $stmt = $conn->prepare("INSERT INTO pdf (filename, mimetype, data) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $filename, $mimetype, $fileData);

            // Выполнение запроса
            if ($stmt->execute()) {
                echo "Файл загружен и информация сохранена в базе данных.";
            } else {
                echo "Ошибка при сохранении информации в базе данных: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Недопустимый тип файла. Разрешены только PDF файлы.";
        }
    }

    // Закрытие соединения
    $conn->close();
    ?>
    </body>
</html>