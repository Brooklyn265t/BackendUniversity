<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$mysqli = new mysqli("database", "user", "password", "coffeeprice");
if ($mysqli->connect_error) {
    die("Ошибка подключения :( " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8mb4");

switch ($_SERVER['REQUEST_METHOD']) {


    case 'POST':
        if (isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["phone"])) {
            $name = htmlspecialchars($_POST["name"]);
            $surname = htmlspecialchars($_POST["surname"]);
            $phone = htmlspecialchars($_POST["phone"]);

            // Подготовка и выполнение запроса вставки
            $sql_insert = "INSERT INTO user(name, surname, phone) VALUES (?, ?, ?)";
            $stmt = $mysqli->prepare($sql_insert);

            if ($stmt === false) {
                echo "Ошибка при подготовке запроса: " . mysqli_error($mysqli);
                exit;
            }

            if ($stmt->bind_param("sss", $name, $surname, $phone) === false) {
                echo "Ошибка при привязке параметров: " . mysqli_error($mysqli);
                exit;
            }

            if ($stmt->execute() === false) {
                echo "Ошибка при выполнении запроса: " . mysqli_error($mysqli);
                exit;
            }

            // Получаем все записи
            $result = $mysqli->query("SELECT * FROM user");
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            echo json_encode($users);
        } else {
            echo "Ошибка в параметрах запроса.";
        }
        break;


    case 'GET':
        if (isset($_GET["User_ID"])) {
            $id = $mysqli->real_escape_string($_GET["User_ID"]);
            $sql_selectdata = "SELECT name, surname, phone FROM user WHERE User_ID='$id'";
            if ($mysqli->query($sql_selectdata) !== false) {
                echo "Вот ваши данные\n";
                $data = $mysqli->query($sql_selectdata)->fetch_assoc();
                echo json_encode($data);
            } else {
                $result = $mysqli->query("SELECT * FROM user");
                $users = [];
                while ($row = $result->fetch_assoc()) {
                    $users[] = $row;
                }
                echo json_encode($users);
            }
        }
        else {
            echo "Ошибка в параметрах запроса.";
        }
        break;


    case 'PUT':
        if (isset($_REQUEST["User_ID"]) && isset($_REQUEST["name"])) {
            $user_id = $mysqli->real_escape_string($_REQUEST["User_ID"]);
            $name = htmlspecialchars($_REQUEST["name"]);

            $sql_update = "UPDATE user SET name = ? WHERE User_ID = '$user_id'";
            $stmt = $mysqli->prepare($sql_update);

            if ($stmt === false) {
                echo "Ошибка при подготовке запроса: " . mysqli_error($mysqli);
                exit;
            }

            if ($stmt->execute([$name]) === false) {
                echo "Ошибка при выполнении запроса: " . mysqli_error($mysqli);
                exit;
            }

            // Получаем количество затронутых строк
            $affected_rows = $stmt->affected_rows;

            // Вывод результата
            if ($affected_rows > 0) {
                echo "Данные обновлены успешно. Затронутые строки: " . $affected_rows;
            } else {
                echo "Не было затронутых строк. Возможно, запись не существует или имя уже обновлено.";
            }

            // Закрытие подготовленного выражения
            $result = $mysqli->query("SELECT * FROM user");
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            echo json_encode($users);
            $stmt->close();
        } else {
            echo "Ошибка в параметрах запроса. Необходимо указать Coffee_ID и имя.";
        }
        break;


    case 'DELETE':
        if (isset($_GET["User_ID"]) && ctype_digit($_GET["User_ID"])) {
            $user_id = intval($_GET["User_ID"]);

            // Подготовка и выполнение запроса удаления
            $sql_delete = "DELETE FROM user WHERE User_ID = ?";
            $stmt = $mysqli->prepare($sql_delete);
            $stmt->bind_param("i", $user_id);

            if (!$stmt->execute()) {
                echo "Ошибка при удалении связанных данных: " . $mysqli->error;
                return; // Завершаем выполнение функции после ошибки
            }
            if ($stmt->execute()) {
                echo "Кофе с ID $user_id удалено успешно.\n";

                // Получаем список всех кофе после удаления
                $result = $mysqli->query("SELECT * FROM user");
                $user = [];
                while ($row = $result->fetch_assoc()) {
                    $user[] = $row;
                }

                // Выводим список кофе в JSON формате
                echo json_encode($user);
            } else {
                echo "Ошибка при удалении кофе: " . $mysqli->error;
            }

            // Закрытие подготовленного выражения
            $stmt->close();
        } else {
            echo "Ошибка в параметрах запроса.";
        }
        break;

}
$mysqli->close();
?>