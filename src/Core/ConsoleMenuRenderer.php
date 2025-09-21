<?php

namespace App\Core;

class ConsoleMenuRenderer implements MenuRendererInterface {
    public function render(string $title, array $options): void {
        echo PHP_EOL . "--------------------------------------" . PHP_EOL;
        echo " --- " . $title . " ---" . PHP_EOL;
        foreach ($options as $numero => $opcion) {
            echo $numero . " . " . $opcion['descripcion'] . PHP_EOL;
        }
        echo "--------------------------------------" . PHP_EOL;
    }
}
