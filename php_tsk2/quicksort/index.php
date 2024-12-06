<html lang="en">
<head>
<title>Быстрая сортировка</title>
    <link rel="stylesheet" href="style.css" type="text/css"/>
</head>
<body>
<?php
$array = [1,7,5,4,3,8];
$left = 0;
$right = count($array) - 1;

echo "Нетсортированный массив:\n";
foreach ($array as $value) {
    echo $value . " ";
}
echo "\n";

function quickSort(&$array, $left, $right) {
    if ($left >= $right) {
        return;
    }

    // Выбор опорного элемента
    $pivot = $array[$left];

    // Перемещение всех элементов меньше опорного влево
    $i = $left + 1;
    for ($j = $left + 1; $j <= $right; $j++) {
        if ($array[$j] < $pivot) {
            list($array[$i], $array[$j]) = array($array[$j], $array[$i]);
            $i++;
        }
    }

    // Перестановка опорного элемента с последним элементом левой подпоследовательности
    list($array[$left], $array[$i - 1]) = array($array[$i - 1], $array[$left]);

    // Рекурсивное сортирование
    quickSort($array, $left, $i - 2);
    quickSort($array, $i, $right);
}
// Вызываем функцию сортировки
quickSort($array, $left, $right);

// Вывод отсортированного массива
echo "Отсортированный массив:\n";
foreach ($array as $value) {
    echo $value . " ";
}
echo "\n";
?>
</table>
</body>
</html>