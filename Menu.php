<?php

class Menu {
    private $titulo;
    private $opciones;

    public function __construct($titulo, array $opciones) {
        $this->titulo = $titulo;
        $this->opciones = $opciones;
    }

    public function mostrar() {
      echo PHP_EOL . "--------------------------------------
        " . PHP_EOL;
      echo " --- " . $this->titulo . " ---
       " . PHP_EOL ;
        foreach ($this->opciones as $numero => $descripcion) {
          echo $numero . " . " . $descripcion . " 
            ". PHP_EOL;
        }
        echo "-------------------------------";
    }

    public function obtenerSeleccion() {
        echo "Ingrese su opción: ";
        $seleccion = trim(fgets(STDIN));
        return $seleccion;
    }

    public function ejecutarOpcion($seleccion) {
        if (array_key_exists($seleccion, $this->opciones)) {
            $descripcion = $this->opciones[$seleccion];

            if ($descripcion !== 'Añadir repuesto'){

              echo "añadir repuesto";
            } 
            echo "Ha seleccionado: " . $descripcion . " ". PHP_EOL;
            echo $seleccion . PHP_EOL;

            if ($descripcion === 'Salir') {
                return false;
            }
        } else {
            echo "Opción inválida. Por favor, intente de nuevo.
";
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
}

?>
