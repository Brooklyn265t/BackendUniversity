<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include "APIModel.php";
include "APIView.php";
include "APIController.php";

$model = new UserModel("database", "user", "password", "coffeeprice");
$view = new JsonView();
$controller = new UserController($model, $view);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        echo $controller->createUser();
        break;

    case 'GET':
        echo $controller->getUser();
        break;

    case 'PUT':
        echo $controller->updateUser();
        break;

    case 'DELETE':
        echo $controller->deleteUser();
        break;
}
?>