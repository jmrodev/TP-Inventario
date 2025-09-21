<?php

require_once 'bd.php';
require_once 'RepuestoFactory.php';
require_once 'Repuesto.php'; // Asegurarse de que Repuesto.php esté incluido para el tipo Repuesto

class InventoryManager {
    private $db;
    private $repuestoFactory;

    public function __construct(InMemoryDatabase $db, RepuestoFactory $repuestoFactory) {
        $this->db = $db;
        $this->repuestoFactory = $repuestoFactory;
    }

    public function addSparePart() {
        echo "--- Añadir Nuevo Repuesto ---
";
        echo "Seleccione el tipo de repuesto:
";
        echo "1. Moto
";
        echo "2. Camion
";
        echo "3. Camioneta
";
        echo "Ingrese su opción: ";
        $tipoOpcion = trim(fgets(STDIN));

        $tipoRepuesto = '';
        switch ($tipoOpcion) {
            case '1': $tipoRepuesto = 'Moto'; break;
            case '2': $tipoRepuesto = 'Camion'; break;
            case '3': $tipoRepuesto = 'Camioneta'; break;
            default:
                echo "Opción de tipo de repuesto inválida.
";
                return;
        }

        echo "Nombre: ";
        $nombre = trim(fgets(STDIN));
        echo "Descripción: ";
        $descripcion = trim(fgets(STDIN));
        echo "Precio: ";
        $precio = (float)trim(fgets(STDIN));
        echo "Cantidad: ";
        $cantidad = (int)trim(fgets(STDIN));
        echo "Marca: ";
        $marca = trim(fgets(STDIN));
        echo "Modelo: ";
        $modelo = trim(fgets(STDIN));

        $datosRepuesto = [
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'cantidad' => $cantidad,
            'marca' => $marca,
            'modelo' => $modelo,
        ];

        if ($tipoRepuesto === 'Camioneta') {
            echo "Tracción (ej: 4x2, 4x4): ";
            $datosRepuesto['traccion'] = trim(fgets(STDIN));
        }

        $repuesto = $this->repuestoFactory->crearRepuesto($tipoRepuesto, $datosRepuesto);

        if ($repuesto) {
            $this->db->addRepuesto($repuesto);
            echo "Repuesto de " . $tipoRepuesto . " añadido con éxito (ID: " . $repuesto->getId() . ").
";
        } else {
            echo "No se pudo crear el repuesto.
";
        }
    }

    public function listSpareParts() {
        echo "--- Listado de Repuestos ---
";
        $repuestos = $this->db->getAllRepuestos();
        if (empty($repuestos)) {
            echo "No hay repuestos en el inventario.
";
            return;
        }

        foreach ($repuestos as $repuesto) {
            echo "--------------------------------------
";
            echo "ID: " . $repuesto->getId() . "
";
            echo "Nombre: " . $repuesto->getNombre() . "
";
            echo "Descripción: " . $repuesto->getDescripcion() . "
";
            echo "Precio: " . $repuesto->getPrecio() . "
";
            echo "Cantidad: " . $repuesto->getCantidad() . "
";
            echo "Categoría: " . $repuesto->getCategoria() . "
";
            echo "Marca: " . $repuesto->getMarca() . "
";
            echo "Modelo: " . $repuesto->getModelo() . "
";
            if ($repuesto instanceof RepuestoCamioneta) {
                echo "Tracción: " . $repuesto->getTraccion() . "
";
            }
        }
        echo "--------------------------------------
";
    }

    public function editSparePart() {
        echo "--- Editar Repuesto ---\n";
        echo "Ingrese el ID del repuesto a editar: ";
        $id = (int)trim(fgets(STDIN));

        $repuesto = $this->db->getRepuestoById($id);

        if (!$repuesto) {
            echo "Repuesto con ID " . $id . " no encontrado.\n";
            return;
        }

        echo "Repuesto actual: " . $repuesto->getNombre() . " (ID: " . $repuesto->getId() . ")\n";
        echo "Ingrese nuevos valores (deje en blanco para mantener el actual):\n";

        echo "Nombre (actual: " . $repuesto->getNombre() . "): ";
        $nombre = trim(fgets(STDIN));
        if (!empty($nombre)) { $repuesto->setNombre($nombre); }

        echo "Descripción (actual: " . $repuesto->getDescripcion() . "): ";
        $descripcion = trim(fgets(STDIN));
        if (!empty($descripcion)) { $repuesto->setDescripcion($descripcion); }

        echo "Precio (actual: " . $repuesto->getPrecio() . "): ";
        $precio = trim(fgets(STDIN));
        if (!empty($precio)) { $repuesto->setPrecio((float)$precio); }

        echo "Cantidad (actual: " . $repuesto->getCantidad() . "): ";
        $cantidad = trim(fgets(STDIN));
        if (!empty($cantidad)) { $repuesto->setCantidad((int)$cantidad); }

        echo "Marca (actual: " . $repuesto->getMarca() . "): ";
        $marca = trim(fgets(STDIN));
        if (!empty($marca)) { $repuesto->setMarca($marca); }

        echo "Modelo (actual: " . $repuesto->getModelo() . "): ";
        $modelo = trim(fgets(STDIN));
        if (!empty($modelo)) { $repuesto->setModelo($modelo); }

        if ($repuesto instanceof RepuestoCamioneta) {
            echo "Tracción (actual: " . $repuesto->getTraccion() . "): ";
            $traccion = trim(fgets(STDIN));
            if (!empty($traccion)) { $repuesto->setTraccion($traccion); }
        }

        echo "Repuesto con ID " . $id . " actualizado con éxito.\n";
    }

    public function deleteSparePart() {
        echo "--- Eliminar Repuesto ---\\n";
        echo "Ingrese el ID del repuesto a eliminar: ";
        $id = (int)trim(fgets(STDIN));

        if ($this->db->removeRepuesto($id)) {
            echo "Repuesto con ID " . $id . " eliminado con éxito.\\n";
        } else {
            echo "Repuesto con ID " . $id . " no encontrado.\\n";
        }
    }

    public function exitApplication() {
        echo "Saliendo de la aplicación...
";
    }
}

?>