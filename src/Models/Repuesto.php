<?php
include_once __DIR__ . '/../Database/bd.php';
class Repuesto {

    protected $id;
    protected $nombre;
    protected $precio;
    protected $cantidad;

    public function __construct($id, $nombre, $precio, $cantidad) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->cantidad = $cantidad;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public static function obtenerTodos() {
        return InMemoryDatabase::getInstance()->obtenerTodosLosRepuestos();
    }

    public static function obtenerPorId($id) {
        return InMemoryDatabase::getInstance()->obtenerRepuestoPorId($id);
    }

    public function guardar() {
        $db = InMemoryDatabase::getInstance();
        if ($this->id === null) {
            return $db->agregarRepuesto($this);
        } else {
            return $db->actualizarRepuesto($this);
        }
    }

    public function eliminar() {
        return InMemoryDatabase::getInstance()->eliminarRepuesto($this->id);
    }
}