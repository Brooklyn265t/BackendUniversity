<?php
require_once 'vendor/autoload.php';
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;
function open_file(): void {
    $file = fopen('data.txt', "r");
    if (!$file) {
        die("Не удалось открыть файл.");
    }
    for ($i = 0; $i < 150; $i++) {
        fgets($file); // Читаем и игнорируем строку
    }
    $data = [];
    for ($i = 0; $i < 150; $i++) {
        $line = fgets($file);
        if ($line === false) {
            break; // Если достигнут конец файла, выходим из цикла
        }
        $data[] = trim($line); // Убираем пробелы и добавляем строку в массив
    }
    $chunks = array_chunk($data, 50);

    // Присваиваем результаты переменным
    $data1 = $chunks[0];
    $data2 = $chunks[1];
    $data3 = $chunks[2];
    sort($data3);
    bar($data3);

    // Закрываем файл
    fclose($file);
}

function bar($data){
    $__width = 1000;
    $__height = 500;
    $graph = new Graph\Graph($__width, $__height);
    $graph->img->SetMargin(40, 40, 40, 40);
    $graph->img->SetAntiAliasing();
    $graph->SetScale('textlin');
    $graph->SetShadow();
    $graph->title->Set('ID');
    $graph->title->SetFont(FF_FONT1, FS_BOLD);
// Use 20% "grace" to get slightly larger scale then min/max of
// data
    $graph->yscale->SetGrace(20);

    $p1 = new Plot\LinePlot($data);
    $p1->mark->SetType(MARK_FILLEDCIRCLE);
    $p1->mark->SetFillColor('red');
    $p1->mark->SetWidth(4);
    $p1->SetColor('blue');
    $p1->SetCenter();
    $graph->Add($p1);
    $graphImage = $graph->Stroke(_IMG_HANDLER);

    $stamp = imagecreatetruecolor(100, 70);
    imagefilledrectangle($stamp, 0, 0, 99, 69, 0x0000FF);
    imagefilledrectangle($stamp, 9, 9, 90, 60, 0xFFFFFF);
    imagestring($stamp, 5, 20, 20, 'Ivan', 0x0000FF);
    imagestring($stamp, 3, 20, 40, '(c) 2024', 0x0000FF);
// Установка полей для штампа и получение высоты/ширины штампа
    $marge_right = 10;
    $marge_bottom = 10;
    $sx = imagesx($stamp);
    $sy = imagesy($stamp);
// Слияние штампа с фотографией. Прозрачность 50%
    imagecopymerge($graphImage, $stamp, imagesx($graphImage) - $sx - $marge_right, imagesy($graphImage) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp), 50);
// Сохранение фотографии в файл и освобождение памяти
    return imagepng($graphImage);
//    imagedestroy($graphImage);
}
open_file();
?>