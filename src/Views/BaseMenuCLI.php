<?php

abstract class BaseMenuCLI {
    protected function obtenerOpcion(): string {
        echo "Seleccione una opción: ";
        $opcion = trim(fgets(STDIN));
        return $opcion;
    }

    protected function displayMessage(string $message, bool $isSuccess = true): void {
        if ($isSuccess) {
            echo "[ÉXITO] " . $message . "\n";
        } else {
            echo "[ERROR] " . $message . "\n";
        }
    }
}
