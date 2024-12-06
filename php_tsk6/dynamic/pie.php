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

    circle($data2);
    // Закрываем файл
    fclose($file);
}

function circle($data) {
    $colors = [
        '#1E90FF', // DodgerBlue
        '#2E8B57', // SeaGreen
        '#ADFF2F', // GreenYellow
        '#DC143C', // Crimson
        '#BA55D3', // MediumOrchid
        '#FF4500', // OrangeRed
        '#FFD700', // Gold
        '#FF69B4', // HotPink
        '#FF1493', // DeepPink
        '#FF6347', // Tomato
        '#FF8C00', // DarkOrange
        '#FFB6C1', // LightPink
        '#FF00FF', // Magenta
        '#8A2BE2', // BlueViolet
        '#7FFF00', // Chartreuse
        '#00FA9A', // MediumSpringGreen
        '#00CED1', // DarkTurquoise
        '#4682B4', // SteelBlue
        '#5F9EA0', // CadetBlue
        '#20B2AA', // LightSeaGreen
        '#66CDAA', // MediumAquamarine
        '#3CB371', // MediumSeaGreen
        '#2F4F4F', // DarkSlateGray
        '#8B0000', // DarkRed
        '#B22222', // FireBrick
        '#FF7F50', // Coral
        '#D2691E', // Chocolate
        '#CD5C5C', // IndianRed
        '#F08080', // LightCoral
        '#E9967A', // DarkSalmon
        '#FA8072', // LightSalmon
        '#FFFF00', // Yellow
        '#FFFFE0', // LightYellow
        '#F0E68C', // Khaki
        '#BDB76B', // DarkKhaki
        '#ADFF2F', // GreenYellow
        '#7FFF00', // Chartreuse
        '#32CD32', // LimeGreen
        '#98FB98', // PaleGreen
        '#00FF7F', // SpringGreen
        '#00FF00', // Lime
        '#228B22', // ForestGreen
        '#006400', // DarkGreen
        '#8B008B', // DarkMagenta
        '#4B0082', // Indigo
        '#6A5ACD', // SlateBlue
        '#483D8B', // DarkSlateBlue
    ];

    $__width = 1000;
    $__height = 500;
    $graph = new Graph\PieGraph($__width, $__height);
    $graph->title->Set('Date graph');
    $graph->SetBox(true);

    $p1   = new Plot\PiePlot($data);
    $p1->ShowBorder();
    $p1->SetColor('black');
    $p1->SetSliceColors($colors);

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