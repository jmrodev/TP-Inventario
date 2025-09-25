<?php

include_once __DIR__ . '/../Models/Repuesto.php';
include_once __DIR__ . '/../Models/Cliente.php';

class InMemoryDatabase {
    
    private static $instance = null;

    private static $repuestos = [];
    private static $nextId = 1;

    private static $clientes = [];
    private static $nextIdCliente = 1;

    private static $ventas = [];
    private static $nextIdVenta = 1;

    
    private function __construct() {
        self::$repuestos[1] = new Repuesto(1, "Filtro de Aceite", 12.99, 150);
        self::$repuestos[2] = new Repuesto(2, "Batería", 75.00, 30);
        self::$repuestos[3] = new Repuesto(3, "Neumático", 120.50, 80);
        self::$nextId = 4;

        self::$clientes[1] = new Cliente(1, "Ana Torres", "11111111");
        self::$clientes[2] = new Cliente(2, "Pedro Gomez", "22222222");
        self::$clientes[3] = new Cliente(3, "Laura Fernandez", "33333333");
        self::$nextIdCliente = 4;
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

    public function addVenta($venta) {
        $venta->setId(self::$nextIdVenta++);
        self::$ventas[$venta->getId()] = $venta;
        return $venta;
    }

    public function getAllVentas() {
        return array_values(self::$ventas);
    }

    public function getVentaById($id) {
        return self::$ventas[$id] ?? null;
    }

    public function removeVenta($id) {
        if (isset(self::$ventas[$id])) {
            unset(self::$ventas[$id]);
            return true;
        }
        return false;
    }
}

?>
