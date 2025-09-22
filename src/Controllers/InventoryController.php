<?php

namespace App\Controllers;

use App\Views\ConsoleView;
use App\Core\Menu; // We will adjust Menu to work with Controller
use App\Models\Repuesto; // For type hinting
use App\Models\RepuestoMoto;
use App\Models\RepuestoCamion;
use App\Models\RepuestoCamioneta;
use App\Database\InMemoryDatabase;

class InventoryController
{
    private InMemoryDatabase $db; // Direct dependency on InMemoryDatabase
    private ConsoleView $view;
    private Menu $mainMenu;

    public function __construct(InMemoryDatabase $db, ConsoleView $view, Menu $mainMenu)
    {
        $this->db = $db;
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

        $repuesto = null;
        switch ($tipo) {
            case 'Moto':
                $repuesto = new RepuestoMoto(
                    null, // ID se asigna en addRepuesto
                    $nombre, $descripcion, $precio, $cantidad, $marca, $modelo
                );
                break;
            case 'Camion':
                $repuesto = new RepuestoCamion(
                    null, // ID se asigna en addRepuesto
                    $nombre, $descripcion, $precio, $cantidad, $marca, $modelo
                );
                break;
            case 'Camioneta':
                $traccion = $additionalData['traccion'] ?? null;
                $repuesto = new RepuestoCamioneta(
                    null, // ID se asigna en addRepuesto
                    $nombre, $descripcion, $precio, $cantidad, $traccion, $marca, $modelo
                );
                break;
            default:
                $this->view->displayError("Tipo de repuesto desconocido: {$tipo}.");
                return;
        }

        try {
            if ($repuesto) {
                $this->db->addRepuesto($repuesto); // Direct call to InMemoryDatabase
                $this->view->displayMessage("Repuesto añadido con éxito.");
            } else {
                $this->view->displayError("No se pudo crear el repuesto.");
            }
        } catch (\Exception $e) {
            $this->view->displayError($e->getMessage());
        }
    }

    private function listSpareParts(): void
    {
        $spareParts = $this->db->getAllRepuestos(); // Direct call to InMemoryDatabase
        $this->view->displaySparePartsList($spareParts);
    }

    private function editSparePart(): void
    {
        $id = (int) $this->view->displayInputPrompt("Ingrese el ID del repuesto a editar: ");
        $existingSparePart = $this->db->getRepuestoById($id); // Direct call to InMemoryDatabase

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
            'traccion' => ($existingSparePart instanceof RepuestoCamioneta) ? $existingSparePart->getTraccion() : 'N/A'
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

        if ($existingSparePart instanceof RepuestoCamioneta) {
            $traccion = $this->view->displayInputPrompt("Nueva Tracción (actual: {$existingSparePart->getTraccion()}): ");
            $updatedData['traccion'] = $traccion;
        }

        try {
            // Logic for updating the spare part directly in the controller
            if (isset($updatedData['nombre']) && !empty($updatedData['nombre'])) { $existingSparePart->setNombre($updatedData['nombre']); }
            if (isset($updatedData['descripcion']) && !empty($updatedData['descripcion'])) { $existingSparePart->setDescripcion($updatedData['descripcion']); }
            if (isset($updatedData['precio']) && !empty($updatedData['precio'])) { $existingSparePart->setPrecio((float)$updatedData['precio']); }
            if (isset($updatedData['cantidad']) && !empty($updatedData['cantidad'])) { $existingSparePart->setCantidad((int)$updatedData['cantidad']); }
            if (isset($updatedData['marca']) && !empty($updatedData['marca'])) { $existingSparePart->setMarca($updatedData['marca']); }
            if (isset($updatedData['modelo']) && !empty($updatedData['modelo'])) { $existingSparePart->setModelo($updatedData['modelo']); }

            if ($existingSparePart instanceof RepuestoCamioneta && isset($updatedData['traccion']) && !empty($updatedData['traccion'])) {
                $existingSparePart->setTraccion($updatedData['traccion']);
            }
            $this->view->displayMessage("Repuesto ID {$id} actualizado con éxito.");
        } catch (\Exception $e) {
            $this->view->displayError($e->getMessage());
        }
    }

    private function deleteSparePart(): void
    {
        $id = (int) $this->view->displayInputPrompt("Ingrese el ID del repuesto a eliminar: ");
        try {
            if ($this->db->removeRepuesto($id)) { // Direct call to InMemoryDatabase
                $this->view->displayMessage("Repuesto ID {$id} eliminado con éxito.");
            } else {
                throw new \Exception("Repuesto con ID {$id} no encontrado.");
            }
        } catch (\Exception $e) {
            $this->view->displayError($e->getMessage());
        }
    }
}