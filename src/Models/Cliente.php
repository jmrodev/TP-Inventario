<?php
include_once __DIR__ . '/../Database/bd.php';

class Cliente {

    protected $id;
    protected $nombre;
    protected $dni;

    public function __construct($id, $nombre, $dni) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->dni = $dni;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDni() {
        return $this->dni;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDni($dni) {
        $this->dni = $dni;
    }

    // Métodos estáticos para interactuar con la base de datos
    public static function obtenerTodos() {
        return InMemoryDatabase::getInstance()->obtenerTodosLosClientes();
    }

    public static function obtenerPorId($id) {
        return InMemoryDatabase::getInstance()->obtenerClientePorId($id);
    }

    public function guardar() {
        $db = InMemoryDatabase::getInstance();
        if ($this->id === null) {
            return $db->agregarCliente($this);
        } else {
            return $db->actualizarCliente($this);
        }
    }

    public function eliminar() {
        return InMemoryDatabase::getInstance()->eliminarCliente($this->id);
    }
}
