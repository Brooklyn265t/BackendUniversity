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

    axis($data1);

    //sort($data);
    // Закрываем файл
    fclose($file);
}

function axis($data) {
    $__width  = 1000;
    $__height = 500;
    $graph = new Graph\Graph($__width, $__height);
    $graph->SetScale('intlin');
    $graph->SetMargin(100, 15, 40, 30);
    $graph->SetMarginColor('white');
    $graph->SetFrame(true, 'blue', 3);

    $graph->title->Set('Phone');
    $graph->title->SetFont(FF_ARIAL, FS_BOLD, 12);

    $graph->subtitle->SetFont(FF_ARIAL, FS_NORMAL, 10);
    $graph->subtitle->SetColor('darkred');

    $graph->SetAxisLabelBackground(LABELBKG_NONE, 'orange', 'red', 'lightblue', 'red');

// Use Ariel font
    $graph->xaxis->SetFont(FF_ARIAL, FS_NORMAL, 9);
    $graph->yaxis->SetFont(FF_ARIAL, FS_NORMAL, 9);
    $graph->xgrid->Show();

// Create the plot line
    $p1 = new Plot\LinePlot($data);
    $graph->Add($p1);

// Output graph
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