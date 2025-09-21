<?php 

namespace App\Models;

use App\Models\Repuesto;

class RepuestoCamion extends Repuesto {
    public function __construct($id, $nombre, $descripcion, $precio, $cantidad, $marca, $modelo) {
        parent::__construct($id, $nombre, $descripcion, $precio, $cantidad, "Camion", $marca, $modelo);
    }
}
