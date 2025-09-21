<?php

namespace App\Core;

use App\Database\InMemoryDatabase;
use App\Factories\RepuestoFactory;
use App\Models\Repuesto;
use App\Models\RepuestoCamioneta;

class InventoryManager {
    private $db;
    private $repuestoFactory;

    public function __construct(InMemoryDatabase $db, RepuestoFactory $repuestoFactory) {
        $this->db = $db;
        $this->repuestoFactory = $repuestoFactory;
    }

    public function addSparePart(string $tipoRepuesto, string $nombre, string $descripcion, float $precio, int $cantidad, string $marca, string $modelo, array $additionalData = []): Repuesto
    {
        $datosRepuesto = [
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'cantidad' => $cantidad,
            'marca' => $marca,
            'modelo' => $modelo,
        ];

        if ($tipoRepuesto === 'Camioneta' && isset($additionalData['traccion'])) {
            $datosRepuesto['traccion'] = $additionalData['traccion'];
        }

        $repuesto = $this->repuestoFactory->crearRepuesto($tipoRepuesto, $datosRepuesto);

        if ($repuesto) {
            $this->db->addRepuesto($repuesto);
            return $repuesto;
        } else {
            throw new \Exception("No se pudo crear el repuesto de tipo {$tipoRepuesto}.");
        }
    }

    public function getAllSpareParts(): array
    {
        return $this->db->getAllRepuestos();
    }

    public function getSparePartById(int $id): ?Repuesto
    {
        return $this->db->getRepuestoById($id);
    }

    public function updateSparePart(int $id, array $updatedData): bool
    {
        $repuesto = $this->db->getRepuestoById($id);

        if (!$repuesto) {
            throw new \Exception("Repuesto con ID {$id} no encontrado.");
        }

        if (isset($updatedData['nombre']) && !empty($updatedData['nombre'])) { $repuesto->setNombre($updatedData['nombre']); }
        if (isset($updatedData['descripcion']) && !empty($updatedData['descripcion'])) { $repuesto->setDescripcion($updatedData['descripcion']); }
        if (isset($updatedData['precio']) && !empty($updatedData['precio'])) { $repuesto->setPrecio((float)$updatedData['precio']); }
        if (isset($updatedData['cantidad']) && !empty($updatedData['cantidad'])) { $repuesto->setCantidad((int)$updatedData['cantidad']); }
        if (isset($updatedData['marca']) && !empty($updatedData['marca'])) { $repuesto->setMarca($updatedData['marca']); }
        if (isset($updatedData['modelo']) && !empty($updatedData['modelo'])) { $repuesto->setModelo($updatedData['modelo']); }

        if ($repuesto instanceof RepuestoCamioneta && isset($updatedData['traccion']) && !empty($updatedData['traccion'])) {
            $repuesto->setTraccion($updatedData['traccion']);
        }

        return true;
    }

    public function deleteSparePart(int $id): bool
    {
        if ($this->db->removeRepuesto($id)) {
            return true;
        } else {
            throw new \Exception("Repuesto con ID {$id} no encontrado.");
        }
    }

    
}

?>