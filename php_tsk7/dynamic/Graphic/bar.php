<?php
require_once '../vendor/autoload.php';
include "OpenFile.php";
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;
header('Content-Type: image/png');
class Bar {
    private $fileHandler;

    function __construct($file) {
        $this->fileHandler = new OpenFile($file);
    }

    function createBarGraph($chunkIndex) {
        $data = $this->fileHandler->trim_data($chunkIndex);
        if ($data === null) {
            die("Данные не найдены для указанного индекса.");
        }

        $__width = 1000;
        $__height = 500;
        $graph = new Graph\Graph($__width, $__height);
        $graph->img->SetMargin(40, 40, 40, 40);
        $graph->img->SetAntiAliasing();
        $graph->SetScale('textlin');
        $graph->SetShadow();
        $graph->title->Set('ID');
        $graph->title->SetFont(FF_FONT1, FS_BOLD);
        $graph->yscale->SetGrace(20);

        $p1 = new Plot\LinePlot($data);
        $p1->mark->SetType(MARK_FILLEDCIRCLE);
        $p1->mark->SetFillColor('red');
        $p1->mark->SetWidth(4);
        $p1->SetColor('blue');
        $p1->SetCenter();
        $graph->Add($p1);
        //$graph->Stroke();
        $graphImage = $graph->Stroke(_IMG_HANDLER);
        // Добавление штампа и сохранение изображения
        $this->addStamp($graphImage);
    }

    private function addStamp($graphImage) {
        $stamp = imagecreatetruecolor(90, 70);
        imagefilledrectangle($stamp, 0, 0, 89, 69, 0x0000FF);
        imagefilledrectangle($stamp, 9, 9, 80, 60, 0xFFFFFF);
        imagestring($stamp, 5, 20, 20, 'Ivan', 0x0000FF);
        imagestring($stamp, 3, 20, 40, '(c) 2024', 0x0000FF);
        $marge_right = 10;
        $marge_bottom = 10;
        $sx = imagesx($stamp);
        $sy = imagesy($stamp);
        imagecopymerge($graphImage, $stamp, imagesx($graphImage) - $sx - $marge_right, imagesy($graphImage) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp), 50);
        return imagepng($graphImage);
    }
}

// Использование классов
$barGraph = new Bar('data.txt');
$barGraph->createBarGraph(2); // Передаем индекс чанка, который хотим
?>