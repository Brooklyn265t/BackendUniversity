<?php
class JsonView
{
    public function render(array $data): string
    {
        return json_encode($data);
    }
}
?>