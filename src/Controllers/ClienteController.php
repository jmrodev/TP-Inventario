<?php
include_once __DIR__ . '/../Models/Cliente.php';

class ClienteController
{
    public function listarClientes()
    {
        return Cliente::obtenerTodos();
    }

    public function agregarCliente($nombre, $dni)
    {
        $cliente = new Cliente(null, $nombre, $dni);
        return $cliente->guardar();
    }

    public function actualizarCliente($id, $nombre, $dni)
    {
        $cliente = new Cliente($id, $nombre, $dni);
        return $cliente->guardar();
    }

    public function eliminarCliente($id)
    {
        $cliente = Cliente::obtenerPorId($id);
        if ($cliente) {
            return $cliente->eliminar();
        }
        return false; // O manejar el error de otra manera
    }
}
