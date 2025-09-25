<?php

include_once __DIR__ . '/../Models/Venta.php';
include_once __DIR__ . '/../Models/Repuesto.php';
include_once __DIR__ . '/../Models/Cliente.php';
include_once __DIR__ . '/RepuestoController.php';

class VentaController
{
    private $repuestoController;
    private $clienteController;  

    public function __construct() {
        $this->repuestoController = new RepuestoController();
        $this->clienteController = new ClienteController(); 
    }

    public function listarVentas(): array
    {
        return Venta::obtenerTodos();
    }

    public function agregarVenta(Repuesto $repuesto, Cliente $cliente, int $cantidad): ?Venta
    {
        if ($repuesto->getCantidad() < $cantidad) {
            echo "[ERROR] No hay suficiente stock del repuesto '" . $repuesto->getNombre() . "'. Stock actual: " . $repuesto->getCantidad() . "\n";
            return null;
        }

        $repuesto->setCantidad($repuesto->getCantidad() - $cantidad);
        $this->repuestoController->actualizarRepuesto(
            $repuesto->getId(),
            $repuesto->getNombre(),
            $repuesto->getPrecio(),
            $repuesto->getCantidad()
        );

        $fecha = date('d-m-Y H:i:s');
        $venta = new Venta(null, $repuesto, $cliente, $cantidad, $fecha);
        if ($venta->guardar()) {
            $cliente->addVenta($venta);
            $this->clienteController->actualizarCliente(
                $cliente->getId(),
                $cliente->getNombre(),
                $cliente->getDni()
            );
            return $venta;
        }
        return null; 
    }

    public function obtenerPorId(int $id): ?Venta
    {
        return Venta::obtenerPorId($id);
    }

    public function eliminarVenta(int $id): bool
    {
        $venta = Venta::obtenerPorId($id);
        if ($venta) {
            $repuesto = $venta->getRepuesto();
            $repuesto->setCantidad($repuesto->getCantidad() + $venta->getCantidad());
            $this->repuestoController->actualizarRepuesto(
                $repuesto->getId(),
                $repuesto->getNombre(),
                $repuesto->getPrecio(),
                $repuesto->getCantidad()
            );
            return $venta->eliminar();
        }
        return false;
    }
}
