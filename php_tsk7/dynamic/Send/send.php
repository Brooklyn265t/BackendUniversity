<html lang="en">
    <head>
        <title>I want eat pdf</title>
    </head>
    <body>
    <?php
    $dir = $_SERVER["DOCUMENT_ROOT"];
    $dir_content = scandir($dir);
    foreach ($dir_content as $item){
        if($item != "." && $item != ".."){
            echo "<a href='./$item'>$item</a><br>";
        }
    }
    ?>
    <form action="send.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="fileToUpload">
        <input type="submit" value="Upload File" name="submit">
    </form>
    <?php
    include "DBconnect.php";
    include "POST.php";
    function DBcon()
    {
        $servername = "database";
        $username = "user";
        $password = "password";
        $dbname = "coffeeprice";

        $conn = new DatabaseConnection($servername, $username, $password, $dbname);
        $conn->connect();
        $uploadFile = new UploadFile($conn);
        // Вызов метода post
        $uploadFile->post(file_get_contents($_FILES["fileToUpload"]["tmp_name"]));
    }
    // Закрытие соединения
    $conn = DBcon();
    ?>
    </body>
</html>