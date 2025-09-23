<?php
include_once __DIR__ . '/../Models/Repuesto.php';

class RepuestoController
{

    public function listarRepuestos()
    {
        return Repuesto::obtenerTodos();
    }

    public function agregarRepuesto($nombre, $precio, $cantidad)
    {
        $repuesto = new Repuesto(null, $nombre, $precio, $cantidad);
        return $repuesto->guardar();
    }

    public function actualizarRepuesto($id, $nombre, $precio, $cantidad)
    {
        $repuesto = new Repuesto($id, $nombre, $precio, $cantidad);
        return $repuesto->guardar();
    }

    public function eliminarRepuesto($id)
    {
        $repuesto = Repuesto::obtenerPorId($id);
        if ($repuesto) {
            return $repuesto->eliminar();
        }
        return false; 
    }
}
?> 
