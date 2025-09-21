<?php

namespace App\Views;

class ConsoleView
{
    public function displayMessage(string $message): void
    {
        echo $message . PHP_EOL;
    }

    public function displayError(string $error): void
    {
        echo "Error: " . $error . PHP_EOL;
    }

    public function displayInputPrompt(string $prompt): string
    {
        echo $prompt;
        return trim(fgets(STDIN));
    }

    public function displaySparePartDetails(array $details): void
    {
        echo "--- Detalles del Repuesto ---" . PHP_EOL;
        foreach ($details as $key => $value) {
            echo ucfirst($key) . ": " . $value . PHP_EOL;
        }
        echo "-----------------------------" . PHP_EOL;
    }

    public function displaySparePartsList(array $spareParts): void
    {
        if (empty($spareParts)) {
            $this->displayMessage("No hay repuestos registrados.");
            return;
        }

        $this->displayMessage("--- Lista de Repuestos ---");
        foreach ($spareParts as $sparePart) {
            $this->displayMessage("ID: " . $sparePart->getId());
            $this->displayMessage("  Nombre: " . $sparePart->getNombre());
            $this->displayMessage("  Categoría: " . $sparePart->getCategoria());
            $this->displayMessage("  Precio: $" . $sparePart->getPrecio());
            $this->displayMessage("  Cantidad: " . $sparePart->getCantidad());
            $this->displayMessage("--------------------------");
        }
    }

    public function displayMenuAndGetChoice(string $prompt, array $options): string
    {
        while (true) {
            $this->displayMessage($prompt);
            foreach ($options as $key => $value) {
                $this->displayMessage(($key + 1) . ". " . $value);
            }
            $choice = (int) $this->displayInputPrompt("Ingrese su opción: ");

            if ($choice > 0 && $choice <= count($options)) {
                return $options[$choice - 1];
            } else {
                $this->displayError("Opción no válida. Intente de nuevo.");
            }
        }
    }
}