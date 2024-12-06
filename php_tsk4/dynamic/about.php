<html lang="en">
<head>
<title>1 страница</title>
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
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["phone"])) {
        $mysqli = new mysqli("database", "user", "password", "coffeeprice");
        if ($mysqli->connect_error) {
            die("Ошибка подключения :( " . $mysqli->connect_error);
        }
        $name = $mysqli->real_escape_string($_POST["name"]);
        $surname = $mysqli->real_escape_string($_POST["surname"]);
        $phone = $mysqli->real_escape_string($_POST["phone"]);
        $sql_insertdata = "INSERT INTO user(name, surname, phone) VALUES ('$name', '$surname', '$phone')";
        if($mysqli->query($sql_insertdata) === TRUE){
            echo "Ура ваш номер у вас";
        }
        else{
            echo "АААААА: " . $mysqli->error;
        }
        $mysqli->close();
    } else {
        echo "Параметры где?";
    }
}
elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET["name"]) && isset($_GET["phone"])) {
        $mysqli = new mysqli("database", "user", "password", "coffeeprice");
        if ($mysqli->connect_error) {
            die("Ошибка подключения :( " . $mysqli->connect_error);
        }
        $name = $mysqli->real_escape_string($_GET["name"]);
        $surnname = $mysqli->real_escape_string($_GET["surnname"]);
        $phone = $mysqli->real_escape_string($_GET["phone"]);
        $sql_insertdata = "SELECT phone from user";
        if($mysqli->query($sql_insertdata) === TRUE){
            echo "Ура ваш номер у вас";
        }
        else{
            echo "АААААА: " . $mysqli->error;
        }
        $mysqli->close();
    }
    else {
        echo "Параметры name или phone отсутствуют в запросе.";
    }
}
?>
<table>
    <?php
    $mysqli = new mysqli("database", "user", "password", "coffeeprice");
    $result = $mysqli->query("SELECT * FROM user", MYSQLI_USE_RESULT);
    foreach ($result as $row){
        echo
        "<tr>
        <th>Имя</th>
        <td>{$row['name']}</td>
        <th>Фамилия</th>
        <td>{$row['surname']}</td>
        <th>Номер телефона</th>
        <td>{$row['phone']}</td>
        </tr>";
    }
    $mysqli->close();
    ?>
</table>
</body>
</html>