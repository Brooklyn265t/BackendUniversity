<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include "API2Model.php";
include "API2View.php";
include "API2Controller.php";

$model = new CoffeeModel("database", "user", "password", "coffeeprice");
$view = new JsonView();
$controller = new CoffeeController($model, $view);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        echo $controller->createCoffee();
        break;

    case 'GET':
        echo $controller->getCoffee();
        break;

    case 'PUT':
        echo $controller->updateCoffee();
        break;

    case 'DELETE':
        echo $controller->deleteCoffee();
        break;
}
?>