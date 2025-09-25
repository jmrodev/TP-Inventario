<?php

include_once __DIR__ . '/BaseMenuCLI.php'; // New include
include_once __DIR__ . '/MenuRepuestoCLI.php';
include_once __DIR__ . '/MenuClienteCLI.php';
include_once __DIR__ . '/../Controllers/RepuestoController.php';
include_once __DIR__ . '/../Controllers/ClienteController.php';
include_once __DIR__ . '/../Models/Repuesto.php';
include_once __DIR__ . '/../Models/Cliente.php';
include_once __DIR__ . '/MenuVentaCLI.php';
include_once __DIR__ . '/../Controllers/VentaController.php';

class MenuCLI extends BaseMenuCLI { // Extend BaseMenuCLI
    private $repuestoMenu;
    private $clienteMenu;
    private $ventaMenu; // New property
    private $repuestoController;
    private $clienteController;
    private $ventaController; // New property

    public function __construct() {
        $this->repuestoController = new RepuestoController();
        $this->clienteController = new ClienteController();
        $this->ventaController = new VentaController(); // Instantiate VentaController
        $this->repuestoMenu = new MenuRepuestoCLI($this->repuestoController);
        $this->clienteMenu = new MenuClienteCLI($this->clienteController); // Pass ClienteController
        $this->ventaMenu = new MenuVentaCLI($this->ventaController, $this->repuestoController, $this->clienteController); // Instantiate MenuVentaCLI
    }

    public function mostrarMenuPrincipal() {
        echo "--- Menú Principal ---
";
        echo "1. Gestión de Repuestos
";
        echo "2. Gestión de Clientes
";
        echo "3. Gestión de Ventas
";
        echo "0. Salir
";
        echo "----------------------
";
        return $this->obtenerOpcion();
    }

    public function iniciar() {
        while (true) {
            $opcionPrincipal = $this->mostrarMenuPrincipal();

            switch ($opcionPrincipal) {
                case '1': // Gestión de Repuestos
                    while (true) {
                        $repuestoAction = $this->repuestoMenu->gestionarRepuestos();

                        if ($repuestoAction['action'] === 'none' && !empty($repuestoAction['message'])) {
                            $this->displayMessage($repuestoAction['message'], $repuestoAction['isSuccess']);
                            continue;
                        }

                        switch ($repuestoAction['action']) {
                            case 'createRepuesto':
                                $data = $repuestoAction['data'];
                                $result = $this->repuestoController->agregarRepuesto(
                                    $data['nombre'],
                                    $data['precio'],
                                    $data['cantidad']
                                );
                                if ($result) {
                                    $this->displayMessage("Repuesto agregado exitosamente.");
                                } else {
                                    $this->displayMessage("Error al agregar el repuesto.", false);
                                }
                                break;
                            case 'readRepuesto':
                                $id = $repuestoAction['id'];
                                $repuesto = $this->repuestoController->obtenerPorId($id);
                                if ($repuesto) {
                                    $this->repuestoMenu->displayRepuestos([$repuesto]);
                                } else {
                                    $this->displayMessage("Repuesto con ID " . $id . " no encontrado.", false);
                                }
                                break;
                            case 'updateRepuesto':
                                $id = $repuestoAction['id'];
                                $data = $repuestoAction['data'];
                                $result = $this->repuestoController->actualizarRepuesto(
                                    $id,
                                    $data['nombre'],
                                    $data['precio'],
                                    $data['cantidad']
                                );
                                if ($result) {
                                    $this->displayMessage("Repuesto actualizado exitosamente.");
                                } else {
                                    $this->displayMessage("Error al actualizar el repuesto. Asegúrese de que el ID exista.", false);
                                }
                                break;
                            case 'deleteRepuesto':
                                $id = $repuestoAction['id'];
                                $result = $this->repuestoController->eliminarRepuesto($id);
                                if ($result) {
                                    $this->displayMessage("Repuesto eliminado exitosamente.");
                                } else {
                                    $this->displayMessage("Error al eliminar el repuesto. Asegúrese de que el ID exista.", false);
                                }
                                break;
                            case 'backToMain':
                                break 2;
                            case 'exit':
                                echo "Saliendo del programa.\n";
                                exit();
                            case 'none':
                            default:
                                break;
                        }
                        echo "\n";
                    }
                    break;
                case '2': // Gestión de Clientes
                    while (true) {
                        $clienteAction = $this->clienteMenu->gestionarClientes();

                        if ($clienteAction['action'] === 'none' && !empty($clienteAction['message'])) {
                            $this->displayMessage($clienteAction['message'], $clienteAction['isSuccess']);
                            continue;
                        }

                        switch ($clienteAction['action']) {
                            case 'createCliente':
                                $data = $clienteAction['data'];
                                $result = $this->clienteController->agregarCliente(
                                    $data['nombre'],
                                    $data['dni']
                                );
                                if ($result) {
                                    $this->displayMessage("Cliente agregado exitosamente.");
                                } else {
                                    $this->displayMessage("Error al agregar el cliente.", false);
                                }
                                break;
                            case 'readCliente':
                                $id = $clienteAction['id'];
                                $cliente = $this->clienteController->obtenerPorId($id);
                                if ($cliente) {
                                    $this->clienteMenu->displayClientes([$cliente]);
                                }
                                else {
                                    $this->displayMessage("Cliente con ID " . $id . " no encontrado.", false);
                                }
                                break;
                            case 'updateCliente':
                                $id = $clienteAction['id'];
                                $data = $clienteAction['data'];
                                $result = $this->clienteController->actualizarCliente(
                                    $id,
                                    $data['nombre'],
                                    $data['dni']
                                );
                                if ($result) {
                                    $this->displayMessage("Cliente actualizado exitosamente.");
                                } else {
                                    $this->displayMessage("Error al actualizar el cliente. Asegúrese de que el ID exista.", false);
                                }
                                break;
                            case 'deleteCliente':
                                $id = $clienteAction['id'];
                                $result = $this->clienteController->eliminarCliente($id);
                                if ($result) {
                                    $this->displayMessage("Cliente eliminado exitosamente.");
                                } else {
                                    $this->displayMessage("Error al eliminar el cliente. Asegúrese de que el ID exista.", false);
                                }
                                break;
                            case 'backToMain':
                                break 2;
                            case 'exit':
                                echo "Saliendo del programa.\n";
                                exit();
                            case 'none':
                            default:
                                break;
                        }
                        echo "\n";
                    }
                    break;
                case '3': // Gestión de Ventas
                    while (true) {
                        $ventaAction = $this->ventaMenu->gestionarVentas();

                        if ($ventaAction['action'] === 'none' && !empty($ventaAction['message'])) {
                            $this->displayMessage($ventaAction['message'], $ventaAction['isSuccess']);
                            continue;
                        }

                        switch ($ventaAction['action']) {
                            case 'createVenta':
                                $data = $ventaAction['data'];
                                $result = $this->ventaController->agregarVenta(
                                    $data['repuesto'],
                                    $data['cliente'],
                                    $data['cantidad']
                                );
                                if ($result) {
                                    $this->displayMessage("Venta registrada exitosamente.");
                                } else {
                                    // Error message already handled in agregarVenta
                                }
                                break;
                            case 'readVenta':
                                $id = $ventaAction['id'];
                                $venta = $this->ventaController->obtenerPorId($id);
                                if ($venta) {
                                    $this->ventaMenu->displayVentas([$venta]);
                                } else {
                                    $this->displayMessage("Venta con ID " . $id . " no encontrada.", false);
                                }
                                break;
                            case 'deleteVenta':
                                $id = $ventaAction['id'];
                                $result = $this->ventaController->eliminarVenta($id);
                                if ($result) {
                                    $this->displayMessage("Venta eliminada exitosamente.");
                                } else {
                                    $this->displayMessage("Error al eliminar la venta. Asegúrese de que el ID exista.", false);
                                }
                                break;
                            case 'backToMain':
                                break 2;
                            case 'exit':
                                echo "Saliendo del programa.\n";
                                exit();
                            case 'none':
                            default:
                                break;
                        }
                        echo "\n";
                    }
                    break;
                case '0':
                    echo "Saliendo del programa.\n";
                    exit();
                default:
                    $this->displayMessage("Opción no válida. Intente de nuevo.", false);
                    break;
            }
            echo "\n";
        }
    }
}