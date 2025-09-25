<?php

include_once __DIR__ . '/BaseMenuCLI.php'; // New include
include_once __DIR__ . '/../Controllers/VentaController.php';
include_once __DIR__ . '/../Controllers/RepuestoController.php';
include_once __DIR__ . '/../Controllers/ClienteController.php';

class MenuVentaCLI extends BaseMenuCLI { // Extend BaseMenuCLI
    private $ventaController;
    private $repuestoController;
    private $clienteController;

    public function __construct(VentaController $ventaController, RepuestoController $repuestoController, ClienteController $clienteController) {
        $this->ventaController = $ventaController;
        $this->repuestoController = $repuestoController;
        $this->clienteController = $clienteController;
    }

    

    public function mostrarMenuVentas() {
        echo "--- Menú de Ventas ---
";
        echo "1. Registrar Venta\n";
        echo "2. Listar Ventas\n";
        echo "3. Eliminar Venta\n";
        echo "9. Volver al Menú Principal\n";
        echo "0. Salir\n";
        echo "-------------------------
";
        return $this->obtenerOpcion();
    }

    public function gestionarVentas(): array
    {
        $opcionVentas = $this->mostrarMenuVentas();
        $action = ['action' => 'none', 'message' => '', 'isSuccess' => true];

        switch ($opcionVentas) {
            case '1':
                $repuestos = $this->repuestoController->listarRepuestos();
                $clientes = $this->clienteController->listarClientes();
                if (empty($repuestos)) {
                    $action = ['action' => 'none', 'message' => "[ERROR] No hay repuestos registrados para realizar una venta.", 'isSuccess' => false];
                    break;
                }
                if (empty($clientes)) {
                    $action = ['action' => 'none', 'message' => "[ERROR] No hay clientes registrados para realizar una venta.", 'isSuccess' => false];
                    break;
                }
                $data = $this->getVentaData($repuestos, $clientes);
                if ($data) {
                    $action = ['action' => 'createVenta', 'data' => $data];
                }
                break;
            case '2':
                $this->displayVentas($this->ventaController->listarVentas());
                $action = ['action' => 'none']; // Just display and stay in menu
                break;
            case '3':
                $this->displayVentas($this->ventaController->listarVentas());
                $id = $this->getVentaId();
                $action = ['action' => 'deleteVenta', 'id' => $id];
                break;
            case '9':
                $action = ['action' => 'backToMain'];
                break;
            case '0':
                $action = ['action' => 'exit'];
                break;
            default:
                $action = ['action' => 'none', 'message' => "Opción no válida. Intente de nuevo.", 'isSuccess' => false];
                break;
        }
        return $action;
    }

    public function displayVentas(array $ventas): void
    {
        if (empty($ventas)) {
            echo "[ERROR] No hay ventas para mostrar.\n";
            return;
        }
        echo "--- Listado de Ventas ---
";
        foreach ($ventas as $venta) {
            echo "ID Venta: " . $venta->getId() . "\n";
            echo "  Repuesto: " . $venta->getRepuesto()->getNombre() . " (ID: " . $venta->getRepuesto()->getId() . ")\n";
            echo "  Cliente: " . $venta->getCliente()->getNombre() . " (ID: " . $venta->getCliente()->getId() . ")\n";
            echo "  Cantidad: " . $venta->getCantidad() . "\n";
            echo "  Fecha: " . $venta->getFecha() . "\n";
            echo "---------------------------
";
        }
    }

    public function getVentaData(array $repuestos, array $clientes): ?array
    {
        echo "--- Registrar Nueva Venta ---
";

        // Display available repuestos
        echo "Repuestos disponibles:\n";
        foreach ($repuestos as $repuesto) {
            echo "  ID: " . $repuesto->getId() . ", Nombre: " . $repuesto->getNombre() . ", Stock: " . $repuesto->getCantidad() . "\n";
        }
        echo "Ingrese el ID del repuesto a vender: ";
        $repuestoId = intval(trim(fgets(STDIN)));
        $selectedRepuesto = null;
        foreach ($repuestos as $repuesto) {
            if ($repuesto->getId() === $repuestoId) {
                $selectedRepuesto = $repuesto;
                break;
            }
        }
        if (!$selectedRepuesto) {
            echo "[ERROR] Repuesto con ID " . $repuestoId . " no encontrado.\n";
            return null;
        }

        // Display available clients
        echo "\nClientes disponibles:\n";
        foreach ($clientes as $cliente) {
            echo "  ID: " . $cliente->getId() . ", Nombre: " . $cliente->getNombre() . "\n";
        }
        echo "Ingrese el ID del cliente: ";
        $clienteId = intval(trim(fgets(STDIN)));
        $selectedCliente = null;
        foreach ($clientes as $cliente) {
            if ($cliente->getId() === $clienteId) {
                $selectedCliente = $cliente;
                break;
            }
        }
        if (!$selectedCliente) {
            echo "[ERROR] Cliente con ID " . $clienteId . " no encontrado.\n";
            return null;
        }

        echo "Ingrese la cantidad a vender: ";
        $cantidad = intval(trim(fgets(STDIN)));

        if ($cantidad <= 0) {
            echo "[ERROR] La cantidad debe ser un número positivo.\n";
            return null;
        }

        return [
            'repuesto' => $selectedRepuesto,
            'cliente' => $selectedCliente,
            'cantidad' => $cantidad,
        ];
    }

    public function getVentaId(): int
    {
        echo "Ingrese el ID de la venta: ";
        return intval(trim(fgets(STDIN)));
    }
}

