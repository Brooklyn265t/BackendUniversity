<?php
    include "Database.php";
    include "DownloadResponce.php";
    include "pdflink.php";
    include "pdfManager.php";
    $servername = "database";
    $username = "user";
    $password = "password";
    $dbname = "coffeeprice";

    $conn = new DatabaseConnection($servername, $username, $password, $dbname);
    $conn->connect();

    $manager = new PdfManager($conn);

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        try {
            $response = $manager->get_file($id);
            $response->send();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        try {
            $pdfList = $manager->display_pdf_list();
            foreach ($pdfList as $link) {
                echo '<a href="' . $link->getHref() . '">' . $link->getFilename() . '</a><br>';
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    $conn->close();
?>

