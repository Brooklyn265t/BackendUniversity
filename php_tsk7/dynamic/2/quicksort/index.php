<html lang="en">
<head>
<title>Быстрая сортировка</title>
    <link rel="stylesheet" href="style.css" type="text/css"/>
</head>
<body>
<?php
class QuickSort {
    private $array;

    public function __construct($array) {
        $this->array = $array;
    }

    public function sort() {
        $this->quickSort(0, count($this->array) - 1);
    }

    private function quickSort($left, $right) {
        if ($left >= $right) {
            return;
        }

        // Выбор опорного элемента
        $pivot = $this->array[$left];

        // Перемещение всех элементов меньше опорного влево
        $i = $left + 1;
        for ($j = $left + 1; $j <= $right; $j++) {
            if ($this->array[$j] < $pivot) {
                list($this->array[$i], $this->array[$j]) = array($this->array[$j], $this->array[$i]);
                $i++;
            }
        }

        // Перестановка опорного элемента с последним элементом левой подпоследовательности
        list($this->array[$left], $this->array[$i - 1]) = array($this->array[$i - 1], $this->array[$left]);

        // Рекурсивное сортирование
        $this->quickSort($left, $i - 2);
        $this->quickSort($i, $right);
    }

    public function getSortedArray() {
        return $this->array;
    }
}

// Исходный массив
$array = [1, 7, 5, 4, 3, 8];

// Выводим несортированный массив
echo "Несортированный массив:\n";
foreach ($array as $value) {
    echo $value . " ";
}
echo "\n";

// Создаем экземпляр класса QuickSort и сортируем массив
$quickSort = new QuickSort($array);
$quickSort->sort();

// Выводим отсортированный массив
$sortedArray = $quickSort->getSortedArray();
echo "Отсортированный массив:\n";
foreach ($sortedArray as $value) {
    echo $value . " ";
}
echo "\n";
?>
</table>
</body>
</html>