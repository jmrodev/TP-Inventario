<?php 

include_once 'Repuesto.php';

class RepuestoCamion extends Repuesto {
    public function __construct($id, $nombre, $descripcion, $precio, $cantidad, $marca, $modelo) {
        parent::__construct($id, $nombre, $descripcion, $precio, $cantidad, "Camion", $marca, $modelo);
    }
}
