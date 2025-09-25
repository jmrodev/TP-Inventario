<?php

include_once __DIR__ . '/BaseMenuCLI.php'; // New include
include_once __DIR__ . '/../Models/Cliente.php';

class MenuClienteCLI extends BaseMenuCLI { // Extend BaseMenuCLI
    private $clienteController;

    public function __construct($clienteController) {
        $this->clienteController = $clienteController;
    }

    

    public function mostrarMenuClientes() {
        echo "--- Menú de Clientes ---
";
        echo "1. Crear Cliente\n";
        echo "2. Listar Clientes\n";
        echo "3. Actualizar Cliente\n";
        echo "4. Eliminar Cliente\n";
        echo "9. Volver al Menú Principal\n";
        echo "0. Salir\n";
        echo "------------------------\n";
        return $this->obtenerOpcion();
    }

    public function gestionarClientes(): array
    {
        $opcionClientes = $this->mostrarMenuClientes();
        $action = ['action' => 'none', 'message' => '', 'isSuccess' => true];

        switch ($opcionClientes) {
            case '1':
                $data = $this->getClienteData();
                $action = ['action' => 'createCliente', 'data' => $data];
                break;
            case '2':
                $this->displayClientes($this->clienteController->listarClientes());
                $action = ['action' => 'none']; // Just display and stay in menu
                break;
            case '3':
                $this->displayClientes($this->clienteController->listarClientes());
                $id = $this->getClienteId();
                $data = $this->getClienteData();
                $action = ['action' => 'updateCliente', 'id' => $id, 'data' => $data];
                break;
            case '4':
                $this->displayClientes($this->clienteController->listarClientes());
                $id = $this->getClienteId();
                $action = ['action' => 'deleteCliente', 'id' => $id];
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

    public function getClienteData(): array
    {
        echo "--- Ingresar Datos del Cliente ---
";
        echo "Nombre del cliente: ";
        $nombre = trim(fgets(STDIN));
        echo "DNI del cliente: ";
        $dni = trim(fgets(STDIN));

        return [
            'nombre' => $nombre,
            'dni' => $dni,
        ];
    }

    public function getClienteId(): int
    {
        echo "Ingrese el ID del cliente: ";
        return intval(trim(fgets(STDIN)));
    }

    public function displayClientes(array $clientes): void
    {
        if (empty($clientes)) {
            // This message should also be returned, but for now, I'll leave it as is
            // as the primary issue is the displayMessage in gestionarClientes
            echo "[ERROR] No hay clientes para mostrar.\n";
            return;
        }
        echo "--- Listado de Clientes ---
";
        foreach ($clientes as $cliente) {
            echo "ID: " . $cliente->getId() . "\n";
            echo "Nombre: " . $cliente->getNombre() . "\n";
            echo "DNI: " . $cliente->getDni() . "\n";
            echo "---------------------------\n";
        }
    }
}
