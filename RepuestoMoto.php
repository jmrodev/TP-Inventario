<?php 

include_once 'Repuesto.php';

class RepuestoMoto extends Repuesto {
    public function __construct($id, $nombre, $descripcion, $precio, $cantidad, $marca, $modelo) {
        parent::__construct($id, $nombre, $descripcion, $precio, $cantidad, "Moto", $marca, $modelo);
    }
}
