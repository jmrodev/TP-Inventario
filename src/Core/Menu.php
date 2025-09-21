<?php

namespace App\Core;

use App\Core\InventoryManager;
use App\Core\MenuRendererInterface;

class Menu {
    private $titulo;
    private $opciones;
    private MenuRendererInterface $renderer;

    public function __construct(string $titulo, array $opciones, MenuRendererInterface $renderer) {
        $this->titulo = $titulo;
        $this->opciones = $opciones;
        $this->renderer = $renderer;
    }

    public function mostrar(): void {
        $this->renderer->render($this->titulo, $this->opciones);
    }

    public function obtenerSeleccion() {
        echo "Ingrese su opción: ";
        $seleccion = trim(fgets(STDIN));
        return $seleccion;
    }

    public function ejecutarOpcion($seleccion) {
        if (array_key_exists($seleccion, $this->opciones)) {
            $opcionSeleccionada = $this->opciones[$seleccion];
            $descripcion = $opcionSeleccionada['descripcion'];
            $accion = $opcionSeleccionada['accion'];

            echo "Ha seleccionado: " . $descripcion . PHP_EOL;

            if (is_callable($accion)) {
                call_user_func($accion);
            } else {
                echo "La acción para '" . $descripcion . "' no es ejecutable.\n";
            }

            if ($descripcion === 'Salir') {
                return false;
            }
        } else {
            echo "Opción inválida. Por favor, intente de nuevo.\n";
        }
        return true;
    }

    public function iniciar() {
        $continuarMenu = true;

        do {
            $this->mostrar();
            $seleccion = $this->obtenerSeleccion();
            $continuarMenu = $this->ejecutarOpcion($seleccion);
        } while ($continuarMenu);

        echo "Saliendo del menú...
";
    }

    
    public static function createMainMenu(InventoryManager $manager, MenuRendererInterface $renderer): self {
        $opciones = [
            1 => ['descripcion' => 'Añadir Repuesto', 'accion' => [$manager, 'addSparePart']],
            2 => ['descripcion' => 'Listar Repuestos', 'accion' => [$manager, 'listSpareParts']],
            3 => ['descripcion' => 'Editar Repuesto', 'accion' => [$manager, 'editSparePart']],
            4 => ['descripcion' => 'Eliminar Repuesto', 'accion' => [$manager, 'deleteSparePart']],
            5 => ['descripcion' => 'Salir', 'accion' => [$manager, 'exitApplication']]
        ];
        return new self("Menú Principal de Inventario", $opciones, $renderer);
    }
}

?>
