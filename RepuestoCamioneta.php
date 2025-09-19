<?php 

include_once 'Repuesto.php';

class RepuestoCamioneta extends Repuesto {
  private $traccion;

    public function __construct($id, $nombre, $descripcion, $precio, $cantidad, $traccion, $marca, $modelo) {
        parent::__construct($id, $nombre, $descripcion, $precio, $cantidad, "Camioneta", $marca, $modelo);
        $this->traccion = $traccion;
    }

    public function getTraccion() {
        return $this->traccion;
    }

    public function setTraccion($traccion) {
        $this->traccion = $traccion;
    }
}
