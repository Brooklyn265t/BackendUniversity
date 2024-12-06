<?php
require_once '../vendor/autoload.php';
include "OpenFile.php";
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;
header("Content-type: image/png");
class axis{
    private $fileHandler;

    function __construct($file) {
        $this->fileHandler = new OpenFile($file);
    }
    function axis($chunkIndex) {
        $data = $this->fileHandler->trim_data($chunkIndex);
        if ($data === null) {
            die("Данные не найдены для указанного индекса.");
        }
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
        // Сохранение фотографии в файл и освобождение памяти
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
$barGraph = new axis('data.txt');
$barGraph->axis(0); // Передаем индекс чанка, который хотим
?>