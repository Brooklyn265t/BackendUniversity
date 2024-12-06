<?php
require_once './vendor/autoload.php';
use Faker\Factory;

class FakerData {
    private $file;

    public function __construct($file = 'data.txt') {
        $this->file = $file;
        $this->faker = Faker\Factory::create();
    }

    public function generateData(): void {
        // Открываем файл для записи
        $handle = fopen($this->file, 'w');

        if ($handle) {
            $this->writeNames($handle);
            $this->writeAddresses($handle);
            $this->writePhoneNumbers($handle);
            $this->writeRandomDates($handle);
            $this->writeRandomId($handle);

            fclose($handle); // Закрываем файл
            echo "Данные успешно записаны в файл {$this->file}.\n";
        } else {
            echo "Не удалось открыть файл для записи.\n";
        }
    }

    private function writeNames($handle): void {
        for ($i = 0; $i < 50; $i++) {
            fwrite($handle, $this->faker->name() . "\n");
        }
    }

    private function writeAddresses($handle): void {
        for ($i = 0; $i < 50; $i++) {
            fwrite($handle, $this->faker->address() . "\n");
        }
    }

    private function generatePhoneNumber(): string {
        return $this->faker->numerify('##########');
    }

    private function writePhoneNumbers($handle): void {
        for ($i = 0; $i < 50; $i++) {
            fwrite($handle, $this->generatePhoneNumber() . "\n");
        }
    }

    private function writeRandomDates($handle): void {
        $startDate = '2019-01-01';
        $endDate = '2024-01-01';

        for ($i = 0; $i < 50; $i++) {
            $randomDate = $this->faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d');
            fwrite($handle, $randomDate . "\n");
        }
    }

    private function writeRandomId($handle): void {
        for ($i = 0; $i < 50; $i++) {
            $randomNumb = $this->faker->numberBetween(1, 100);
            fwrite($handle, $randomNumb . "\n");
        }
    }
}

// Использование класса
$fakerData = new FakerData();
$fakerData->generateData();
?>