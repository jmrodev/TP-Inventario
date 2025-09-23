<?php

include_once __DIR__ . '/../Controllers/RepuestoController.php';
include_once __DIR__ . '/../Controllers/ClienteController.php';



class MenuCLI {
    public function mostrarMenuPrincipal() {
        echo "--- Menú Principal ---
";
        echo "1. Gestión de Repuestos
";
        echo "2. Gestión de Clientes
";
        echo "0. Salir
";
        echo "----------------------
";
        return $this->obtenerOpcion();
    }

    public function mostrarMenuRepuestos() {
        echo "--- Menú de Repuestos ---
";
        echo "1. Crear Repuesto
";
        echo "2. Leer Repuesto
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

    public function mostrarMenuClientes() {
        echo "--- Menú de Clientes ---
";
        echo "1. Crear Cliente
";
        echo "2. Leer Cliente
";
        echo "3. Actualizar Cliente
";
        echo "4. Eliminar Cliente
";
        echo "9. Volver al Menú Principal
";
        echo "0. Salir
";
        echo "------------------------
";
        return $this->obtenerOpcion();
    }

    private function obtenerOpcion() {
        echo "Seleccione una opción: ";
        $opcion = trim(fgets(STDIN));
        return $opcion;
    }

    public function iniciar() {
        while (true) {
            $opcionPrincipal = $this->mostrarMenuPrincipal();

            switch ($opcionPrincipal) {
                case '1':
                    $this->gestionarRepuestos();
                    break;
                case '2':
                    $this->gestionarClientes();
                    break;
                case '0':
                    echo "Saliendo del programa.
";
                    return;
                default:
                    echo "Opción no válida. Intente de nuevo.
";
                    break;
            }
            echo "
";
        }
    }

    private function gestionarRepuestos() {
        while (true) {
            $opcionRepuestos = $this->mostrarMenuRepuestos();

            switch ($opcionRepuestos) {
                case '1':
                    echo "--- Crear Repuesto ---
";
                    echo "Nombre del repuesto: ";
                    $nombre = trim(fgets(STDIN));
                    echo "Precio del repuesto: ";
                    $precio = floatval(trim(fgets(STDIN))); 
                    echo "Cantidad en stock: ";
                    $cantidad = intval(trim(fgets(STDIN)));



            $RepuestoController = new RepuestoController();
            RepuestoController->agregarRepuesto($nombre, $precio, $cantidad);

                    break;
                case '2':
                    echo "--- Leer Repuesto ---
";

            R
                    break;
                case '3':
                    echo "--- Actualizar Repuesto ---
";
                    echo "Lógica de actualización de repuesto pendiente.
";
                    break;
                case '4':
                    echo "--- Eliminar Repuesto ---
";
                    echo "Lógica de eliminación de repuesto pendiente.
";
                    break;
                case '9':
                    return;
                case '0':
                    echo "Saliendo del programa.
";
                    exit();
                default:
                    echo "Opción no válida. Intente de nuevo.
";
                    break;
            }
            echo "
";
        }
    }

    private function gestionarClientes() {
        while (true) {
            $opcionClientes = $this->mostrarMenuClientes();

            switch ($opcionClientes) {
                case '1':
                    echo "--- Crear Cliente ---
";
                    echo "Lógica de creación de cliente pendiente.
";
                    break;
                case '2':
                    echo "--- Leer Cliente ---
";
                    echo "Lógica de lectura de cliente pendiente.
";
                    break;
                case '3':
                    echo "--- Actualizar Cliente ---
";
                    echo "Lógica de actualización de cliente pendiente.
";
                    break;
                case '4':
                    echo "--- Eliminar Cliente ---
";
                    echo "Lógica de eliminación de cliente pendiente.
";
                    break;
                case '9':
                    return;
                case '0':
                    echo "Saliendo del programa.
";
                    exit();
                default:
                    echo "Opción no válida. Intente de nuevo.
";
                    break;
            }
            echo "
";
        }
    }
}

