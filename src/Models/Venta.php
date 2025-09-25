<?php

include_once __DIR__ . '/../Database/bd.php';
include_once __DIR__ . '/Repuesto.php';
include_once __DIR__ . '/Cliente.php';

class Venta {
    private $id;
    private $repuesto;
    private $cliente;
    private $cantidad;
    private $fecha;

    public function __construct(?int $id, Repuesto $repuesto, Cliente $cliente, int $cantidad, string $fecha) {
        $this->id = $id;
        $this->repuesto = $repuesto;
        $this->cliente = $cliente;
        $this->cantidad = $cantidad;
        $this->fecha = $fecha;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getRepuesto(): Repuesto {
        return $this->repuesto;
    }

    public function getCliente(): Cliente {
        return $this->cliente;
    }

    public function getCantidad(): int {
        return $this->cantidad;
    }

    public function getFecha(): string {
        return $this->fecha;
    }

    public function guardar(): bool {
        $db = InMemoryDatabase::getInstance();
        $db->addVenta($this);
        return true;
    }

    public function eliminar(): bool {
        $db = InMemoryDatabase::getInstance();
        return $db->removeVenta($this->id);
    }

    public static function obtenerTodos(): array {
        $db = InMemoryDatabase::getInstance();
        return $db->getAllVentas();
    }

    public static function obtenerPorId(int $id): ?Venta {
        $db = InMemoryDatabase::getInstance();
        return $db->getVentaById($id);
    }
}
