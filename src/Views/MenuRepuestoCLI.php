<?php

include_once __DIR__ . '/BaseMenuCLI.php'; // New include
include_once __DIR__ . '/../Models/Repuesto.php';

class MenuRepuestoCLI extends BaseMenuCLI { // Extend BaseMenuCLI
    private $repuestoController;

    public function __construct($repuestoController) {
        $this->repuestoController = $repuestoController;
    }

    

    public function mostrarMenuRepuestos() {
        echo "--- Menú de Repuestos ---
";
        echo "1. Crear Repuesto
";
        echo "2. Listar Repuestos
";
        echo "3. Actualizar Repuesto
";
        echo "4. Eliminar Repuesto
";
        echo "9. Volver al Menú Principal
";
        echo "0. Salir
";
        echo "-------------------------
";
        return $this->obtenerOpcion();
    }

    public function gestionarRepuestos(): array
    {
        $opcionRepuestos = $this->mostrarMenuRepuestos();
        $action = ['action' => 'none', 'message' => '', 'isSuccess' => true];

        switch ($opcionRepuestos) {
            case '1':
                $data = $this->getRepuestoData();
                $action = ['action' => 'createRepuesto', 'data' => $data];
                break;
            case '2':
                $this->displayRepuestos($this->repuestoController->listarRepuestos());
                $action = ['action' => 'none']; // Just display and stay in menu
                break;
            case '3':
                $this->displayRepuestos($this->repuestoController->listarRepuestos());
                $id = $this->getRepuestoId();
                $data = $this->getRepuestoData();
                $action = ['action' => 'updateRepuesto', 'id' => $id, 'data' => $data];
                break;
            case '4':
                $this->displayRepuestos($this->repuestoController->listarRepuestos());
                $id = $this->getRepuestoId();
                $action = ['action' => 'deleteRepuesto', 'id' => $id];
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

    public function displayRepuestos(array $repuestos): void
    {
        if (empty($repuestos)) {
            // This message should also be returned, but for now, I'll leave it as is
            // as the primary issue is the displayMessage in gestionarRepuestos
            echo "[ERROR] No hay repuestos para mostrar.\n";
            return;
        }
        echo "--- Listado de Repuestos ---
";
        foreach ($repuestos as $repuesto) {
            echo "ID: " . $repuesto->getId() . "\n";
            echo "Nombre: " . $repuesto->getNombre() . "\n";
            echo "Precio: " . $repuesto->getPrecio() . "\n";
            echo "Cantidad: " . $repuesto->getCantidad() . "\n";
            echo "---------------------------
";
        }
    }

    public function getRepuestoData(): array
    {
        echo "--- Ingresar Datos del Repuesto ---
";
        echo "Nombre del repuesto: ";
        $nombre = trim(fgets(STDIN));
        echo "Precio del repuesto: ";
        $precio = floatval(trim(fgets(STDIN)));
        echo "Cantidad en stock: ";
        $cantidad = intval(trim(fgets(STDIN)));

        return [
            'nombre' => $nombre,
            'precio' => $precio,
            'cantidad' => $cantidad,
        ];
    }

    public function getRepuestoId(): int
    {
        echo "Ingrese el ID del repuesto: ";
        return intval(trim(fgets(STDIN)));
    }
}
