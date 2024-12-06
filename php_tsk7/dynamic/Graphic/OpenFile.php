<?php
class OpenFile{
    private $file;
    private $data;

    function __construct($file) {
        $this->file = $file;
        $this->data = $this->open_file($file);
    }

    function open_file($file): array {
        $fileopen = fopen($file, "r");
        if (!$fileopen) {
            die("Не удалось открыть файл.");
        }
        for ($i = 0; $i < 150; $i++) {
            fgets($fileopen); // Читаем и игнорируем строку
        }
        $data = [];
        for ($i = 0; $i < 150; $i++) {
            $line = fgets($fileopen);
            if ($line === false) {
                break; // Если достигнут конец файла, выходим из цикла
            }
            $data[] = trim($line); // Убираем пробелы и добавляем строку в массив
        }

        fclose($fileopen);
        return $data;
    }

    function trim_data($skip): mixed {
        $chunks = array_chunk($this->data, ceil(count($this->data) / 3));
        return $chunks[$skip] ?? null; // Возвращаем нужный чанк
    }
}