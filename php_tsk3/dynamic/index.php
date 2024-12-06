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
$mysqli = new mysqli("database", "user", "password", "coffeeprice");
$result = $mysqli->query("SELECT name FROM coffee", MYSQLI_USE_RESULT);
foreach ($result as $row){
    echo "<tr><td>{$row['name']}<br /></td></tr>";
}
$mysqli->close();
?>
</table>
</body>
</html>