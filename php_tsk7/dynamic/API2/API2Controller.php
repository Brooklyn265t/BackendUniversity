<?php
class CoffeeController
{
    private $model;
    private $view;

    public function __construct(CoffeeModel $model, JsonView $view)
    {
        $this->model = $model;
        $this->view = $view;
    }

    public function createCoffee(): string
    {
        $name = htmlspecialchars($_POST["name"]);

        if ($this->model->createCoffee($name)) {
            return $this->view->render($this->model->getAllCoffees());
        } else {
            return "Ошибка при создании кофе";
        }
    }

    public function getCoffee(): string
    {
        $id = intval($_GET["Coffee_ID"]);
        $coffee = $this->model->getCoffeeById($id);
        if (empty($coffee)) {
            return $this->view->render($this->model->getAllCoffees());
        }
        return $this->view->render([$coffee]);
    }

    public function updateCoffee(): string
    {
        $id = intval($_REQUEST["Coffee_ID"]);
        $name = htmlspecialchars($_REQUEST["name"]);

        if ($this->model->updateCoffee($id, $name)) {
            return $this->view->render($this->model->getAllCoffees());
        } else {
            return "Ошибка при обновлении кофе";
        }
    }

    public function deleteCoffee(): string
    {
        $id = intval($_GET["Coffee_ID"]);

        if ($this->model->deleteCoffee($id)) {
            return $this->view->render($this->model->getAllCoffees());
        } else {
            return "Ошибка при удалении кофе";
        }
    }
}
?>