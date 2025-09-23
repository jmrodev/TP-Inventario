<?php

class InMemoryDatabase {
    
    private static $instance = null;

    private static $repuestos = [];
    private static $nextId = 1;

    private static $clientes = [];
    private static $nextIdCliente = 1;

    
    private function __construct() {
    }

    public static function getInstance(): InMemoryDatabase {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function agregarRepuesto($repuesto) {
        $repuesto->setId(self::$nextId++);
        self::$repuestos[$repuesto->getId()] = $repuesto;
        return $repuesto;
    }

    public function obtenerTodosLosRepuestos() {
        return array_values(self::$repuestos);
    }

    public function obtenerRepuestoPorId($id) {
        return self::$repuestos[$id] ?? null;
    }

    public function actualizarRepuesto($repuesto) {
        if (isset(self::$repuestos[$repuesto->getId()])) {
            self::$repuestos[$repuesto->getId()] = $repuesto;
            return true;
        }
        return false;
    }

    public function eliminarRepuesto($id) {
        if (isset(self::$repuestos[$id])) {
            unset(self::$repuestos[$id]);
            return true;
        }
        return false;
    }

    // Métodos CRUD para Cliente
    public function agregarCliente($cliente) {
        $cliente->setId(self::$nextIdCliente++);
        self::$clientes[$cliente->getId()] = $cliente;
        return $cliente;
    }

    public function obtenerTodosLosClientes() {
        return array_values(self::$clientes);
    }

    public function obtenerClientePorId($id) {
        return self::$clientes[$id] ?? null;
    }

    public function actualizarCliente($cliente) {
        if (isset(self::$clientes[$cliente->getId()])) {
            self::$clientes[$cliente->getId()] = $cliente;
            return true;
        }
        return false;
    }

    public function eliminarCliente($id) {
        if (isset(self::$clientes[$id])) {
            unset(self::$clientes[$id]);
            return true;
        }
        return false;
    }
}

?>
