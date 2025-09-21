<?php

namespace App\Factories;

use App\Models\Repuesto;
use App\Models\RepuestoMoto;
use App\Models\RepuestoCamion;
use App\Models\RepuestoCamioneta;

class RepuestoFactory {

    
    public static function crearRepuesto(string $tipo, array $datos): ?Repuesto {
        
        $id = null; 
        $nombre = $datos['nombre'] ?? '';
        $descripcion = $datos['descripcion'] ?? '';
        $precio = $datos['precio'] ?? 0.0;
        $cantidad = $datos['cantidad'] ?? 0;
        $marca = $datos['marca'] ?? '';
        $modelo = $datos['modelo'] ?? '';

        switch ($tipo) {
            case 'Moto':
                return new RepuestoMoto($id, $nombre, $descripcion, $precio, $cantidad, $marca, $modelo);
            case 'Camion':
                return new RepuestoCamion($id, $nombre, $descripcion, $precio, $cantidad, $marca, $modelo);
            case 'Camioneta':
                $traccion = $datos['traccion'] ?? '';
                return new RepuestoCamioneta($id, $nombre, $descripcion, $precio, $cantidad, $traccion, $marca, $modelo);
            default:
                echo "Tipo de repuesto inválido para la fábrica.\n";
                return null;
        }
    }
}

?>