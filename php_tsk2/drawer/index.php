<html lang="en">
<head>
<title>Task 2</title>
    <link rel="stylesheet" href="style.css" type="text/css"/>
</head>
<body>
<h1>Фигура</h1>
<?php
header('Content-Type: image/svg+xml');

function drawSVG($num) {
    $svg = '<svg width="100" height="100">';
    
    switch ($num) {
        case 0:
            // Прямоугольник
            $svg .= '<rect x="10" y="10" width="40" height="40" style="fill:#FF0000;stroke:#000000"/>'; 
            break;
        case 1:
            // Овал
            $svg .= '<circle cx="50" cy="50" r="30" style="fill:#00FF00;stroke:#000000"/>'; 
            break;
        case 2:
            // Треугольник
            $svg .= '<polygon points="20,80 80,80 50,20" style="fill:#0000FF;stroke:#000000"/>'; 
            break;
        default:
            // Некодированная фигура
            $svg .= '<text x="10" y="50" font-size="24">Unknown shape</text>';
    }
    
    $svg .= '</svg>';
    return $svg;
}

$num = isset($_GET['num']) ? intval($_GET['num']) : 0;

$validShapes = array(0, 1, 2);
if (!in_array($num, $validShapes)) {
    echo "Invalid shape number";
    exit();
}

echo drawSVG($num);
?>
</table>
<?php
phpinfo();
?>
</body>
</html>