<?php

namespace App\Controllers;

use App\Views\ConsoleView;
use App\Core\InventoryManager;
use App\Core\Menu; // We will adjust Menu to work with Controller
use App\Models\Repuesto; // For type hinting

class InventoryController
{
    private InventoryManager $inventoryManager;
    private ConsoleView $view;
    private Menu $mainMenu;

    public function __construct(InventoryManager $inventoryManager, ConsoleView $view, Menu $mainMenu)
    {
        $this->inventoryManager = $inventoryManager;
        $this->view = $view;
        $this->mainMenu = $mainMenu;
    }

    public function run(): void
    {
        while (true) {
            $this->mainMenu->mostrar();
            $opcion = $this->mainMenu->obtenerSeleccion();

            switch ($opcion) {
                case 1: // Añadir Repuesto
                    $this->addSparePart();
                    break;
                case 2: // Listar Repuestos
                    $this->listSpareParts();
                    break;
                case 3: // Editar Repuesto
                    $this->editSparePart();
                    break;
                case 4: // Eliminar Repuesto
                    $this->deleteSparePart();
                    break;
                case 5: // Salir
                    $this->view->displayMessage("¡Aplicación finalizada!");
                    return;
                default:
                    $this->view->displayError("Opción no válida. Intente de nuevo.");
            }
            $this->view->displayMessage(""); // Add a newline for better readability
        }
    }

    private function addSparePart(): void
    {
        $this->view->displayMessage("--- Añadir Nuevo Repuesto ---");
        $availableTypes = ['Moto', 'Camion', 'Camioneta'];
        $tipo = $this->view->displayMenuAndGetChoice("Tipo de repuesto:", $availableTypes);
        $nombre = $this->view->displayInputPrompt("Nombre: ");
        $descripcion = $this->view->displayInputPrompt("Descripción: ");
        $precio = (float) $this->view->displayInputPrompt("Precio: ");
        $cantidad = (int) $this->view->displayInputPrompt("Cantidad: ");
        $marca = $this->view->displayInputPrompt("Marca: ");
        $modelo = $this->view->displayInputPrompt("Modelo: ");

        $additionalData = [];
        if (strtolower($tipo) === 'camioneta') {
            $additionalData['traccion'] = $this->view->displayInputPrompt("Tracción (4x2, 4x4): ");
        }

        try {
            $this->inventoryManager->addSparePart($tipo, $nombre, $descripcion, $precio, $cantidad, $marca, $modelo, $additionalData);
            $this->view->displayMessage("Repuesto añadido con éxito.");
        } catch (\Exception $e) {
            $this->view->displayError($e->getMessage());
        }
    }

    private function listSpareParts(): void
    {
        $spareParts = $this->inventoryManager->getAllSpareParts();
        $this->view->displaySparePartsList($spareParts);
    }

    private function editSparePart(): void
    {
        $id = (int) $this->view->displayInputPrompt("Ingrese el ID del repuesto a editar: ");
        $existingSparePart = $this->inventoryManager->getSparePartById($id);

        if (!$existingSparePart) {
            $this->view->displayError("Repuesto con ID {$id} no encontrado.");
            return;
        }

        $this->view->displayMessage("--- Editando Repuesto ID: {$id} ---");
        $this->view->displaySparePartDetails([
            'id' => $existingSparePart->getId(),
            'nombre' => $existingSparePart->getNombre(),
            'descripcion' => $existingSparePart->getDescripcion(),
            'precio' => $existingSparePart->getPrecio(),
            'cantidad' => $existingSparePart->getCantidad(),
            'categoria' => $existingSparePart->getCategoria(),
            'marca' => $existingSparePart->getMarca(),
            'modelo' => $existingSparePart->getModelo(),
            // Add specific properties for Camioneta if needed
            'traccion' => ($existingSparePart instanceof \App\Models\RepuestoCamioneta) ? $existingSparePart->getTraccion() : 'N/A'
        ]);

        $nombre = $this->view->displayInputPrompt("Nuevo Nombre (actual: {$existingSparePart->getNombre()}): ");
        $descripcion = $this->view->displayInputPrompt("Nueva Descripción (actual: {$existingSparePart->getDescripcion()}): ");
        $precio = (float) $this->view->displayInputPrompt("Nuevo Precio (actual: {$existingSparePart->getPrecio()}): ");
        $cantidad = (int) $this->view->displayInputPrompt("Nueva Cantidad (actual: {$existingSparePart->getCantidad()}): ");
        $marca = $this->view->displayInputPrompt("Nueva Marca (actual: {$existingSparePart->getMarca()}): ");
        $modelo = $this->view->displayInputPrompt("Nuevo Modelo (actual: {$existingSparePart->getModelo()}): ");

        $updatedData = [
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'cantidad' => $cantidad,
            'marca' => $marca,
            'modelo' => $modelo,
        ];

        if ($existingSparePart instanceof \App\Models\RepuestoCamioneta) {
            $traccion = $this->view->displayInputPrompt("Nueva Tracción (actual: {$existingSparePart->getTraccion()}): ");
            $updatedData['traccion'] = $traccion;
        }

        try {
            $this->inventoryManager->updateSparePart($id, $updatedData);
            $this->view->displayMessage("Repuesto ID {$id} actualizado con éxito.");
        } catch (\Exception $e) {
            $this->view->displayError($e->getMessage());
        }
    }

    private function deleteSparePart(): void
    {
        $id = (int) $this->view->displayInputPrompt("Ingrese el ID del repuesto a eliminar: ");
        try {
            $this->inventoryManager->deleteSparePart($id);
            $this->view->displayMessage("Repuesto ID {$id} eliminado con éxito.");
        } catch (\Exception $e) {
            $this->view->displayError($e->getMessage());
        }
    }
}