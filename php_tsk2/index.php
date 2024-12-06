<?php
$dir = $_SERVER["DOCUMENT_ROOT"];
$dir_content = scandir($dir);
foreach ($dir_content as $item){
    if($item != "." && $item != ".."){
        echo "<a href='/$item'>$item</a><br>";
    }
}