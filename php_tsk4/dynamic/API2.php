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
        if (isset($_POST["name"])) {
            $name = htmlspecialchars($_POST["name"]);

            // Подготовка и выполнение запроса вставки
            $sql_insert = "INSERT INTO coffee(name) VALUES (?)";
            $stmt = $mysqli->prepare($sql_insert);

            if ($stmt === false) {
                echo "Ошибка при подготовке запроса: " . mysqli_error($mysqli);
                exit;
            }

            if ($stmt->bind_param("s", $name) === false) {
                echo "Ошибка при привязке параметров: " . mysqli_error($mysqli);
                exit;
            }

            if ($stmt->execute() === false) {
                echo "Ошибка при выполнении запроса: " . mysqli_error($mysqli);
                exit;
            }

            // Получаем все записи
            $result = $mysqli->query("SELECT * FROM coffee");
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
        if (isset($_GET["Coffee_ID"])) {
            $id = $mysqli->real_escape_string($_GET["Coffee_ID"]);
            $sql_selectdata = "SELECT name FROM coffee WHERE Coffee_ID='$id'";
            if ($mysqli->query($sql_selectdata) !== false) {
                echo "Вот ваши данные\n";
                $data = $mysqli->query($sql_selectdata)->fetch_assoc();
                echo json_encode($data);
            } else {
                $result = $mysqli->query("SELECT * FROM coffee");
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
        if (isset($_REQUEST["Coffee_ID"]) && isset($_REQUEST["name"])) {
            $coffee_id = $mysqli->real_escape_string($_REQUEST["Coffee_ID"]);
            $name = htmlspecialchars($_REQUEST["name"]);

            $sql_update = "UPDATE coffee SET name = ? WHERE Coffee_ID = '$coffee_id'";
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
            $result = $mysqli->query("SELECT * FROM coffee");
            $coffees = [];
            while ($row = $result->fetch_assoc()) {
                $coffees[] = $row;
            }
            echo json_encode($coffees);
            $stmt->close();
        } else {
            echo "Ошибка в параметрах запроса. Необходимо указать Coffee_ID и имя.";
        }
        break;


    case 'DELETE':
        if (isset($_GET["Coffee_ID"]) && ctype_digit($_GET["Coffee_ID"])) {
            $coffee_id = intval($_GET["Coffee_ID"]);

            // Подготовка и выполнение запроса удаления
            $sql_delete = "DELETE FROM coffee WHERE Coffee_ID = ?";
            $stmt = $mysqli->prepare($sql_delete);
            $stmt->bind_param("i", $coffee_id);

            if (!$stmt->execute()) {
                echo "Ошибка при удалении связанных данных: " . $mysqli->error;
                return; // Завершаем выполнение функции после ошибки
            }
            if ($stmt->execute()) {
                echo "Кофе с ID $coffee_id удалено успешно.\n";

                // Получаем список всех кофе после удаления
                $result = $mysqli->query("SELECT * FROM coffee");
                $coffee = [];
                while ($row = $result->fetch_assoc()) {
                    $coffee[] = $row;
                }

                // Выводим список кофе в JSON формате
                echo json_encode($coffee);
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