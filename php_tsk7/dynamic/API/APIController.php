<?php
class UserController
{
    private $model;
    private $view;

    public function __construct(UserModel $model, JsonView $view)
    {
        $this->model = $model;
        $this->view = $view;
    }

    public function createUser(): string
    {
        $name = htmlspecialchars($_POST["name"]);
        $surname = htmlspecialchars($_POST["surname"]);
        $phone = htmlspecialchars($_POST["phone"]);

        if ($this->model->createUser($name, $surname, $phone)) {
            return $this->view->render($this->model->getAllUsers());
        } else {
            return "Ошибка при создании пользователя";
        }
    }

    public function getUser(): string
    {
        $id = intval($_GET["User_ID"]);
        $user = $this->model->getUserById($id);
        if (empty($user)) {
            return $this->view->render($this->model->getAllUsers());
        }
        return $this->view->render([$user]);
    }

    public function updateUser(): string
    {
        $id = intval($_REQUEST["User_ID"]);
        $name = htmlspecialchars($_REQUEST["name"]);

        if ($this->model->updateUser($id, $name)) {
            return $this->view->render($this->model->getAllUsers());
        } else {
            return "Ошибка при обновлении пользователя";
        }
    }

    public function deleteUser(): string
    {
        $id = intval($_GET["User_ID"]);

        if ($this->model->deleteUser($id)) {
            return $this->view->render($this->model->getAllUsers());
        } else {
            return "Ошибка при удалении пользователя";
        }
    }
}
?>