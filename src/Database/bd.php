<?php

namespace App\Database;

use App\Models\Repuesto;
use App\Models\RepuestoMoto;
use App\Models\RepuestoCamion;
use App\Models\RepuestoCamioneta;
class InMemoryDatabase {
    
    private static $instance = null;

    private static $repuestos = [];
    private static $nextId = 1;

    
    private function __construct() {
        echo "InMemoryDatabase: Instancia creada y lista.\n";
        $this->seedData();
    }

    private function seedData() {


        $repuesto1 = new RepuestoMoto(
            null, // ID se asigna en addRepuesto
            'Filtro de Aire Moto', 
            'Filtro de aire de alto rendimiento para motos',
            25.50, 
            10, 
            'K&N', 
            'Universal'
        );
        if ($repuesto1) $this->addRepuesto($repuesto1);

        $repuesto2 = new RepuestoCamion(
            null, // ID se asigna en addRepuesto
            'Pastillas de Freno Camion', 
            'Pastillas de freno para camiones de carga pesada',
            120.00, 
            5, 
            'Brembo', 
            'Serie 500'
        );
        if ($repuesto2) $this->addRepuesto($repuesto2);

        $repuesto3 = new RepuestoCamioneta(
            null, // ID se asigna en addRepuesto
            'Amortiguador Camioneta', 
            'Amortiguador trasero para camioneta 4x4',
            85.75, 
            8,
            '4x4', // traccion
            'Monroe', 
            'Hilux'
        );
        if ($repuesto3) $this->addRepuesto($repuesto3);

        echo "InMemoryDatabase: Datos de ejemplo cargados.\n";
    }

    
    public static function getInstance(): InMemoryDatabase {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    
    public function addRepuesto($repuesto) {
        $repuesto->setId(self::$nextId++);
        self::$repuestos[$repuesto->getId()] = $repuesto;
        return $repuesto;
    }

    
    public function getRepuestoById($id) {
        return self::$repuestos[$id] ?? null;
    }

    
    public function getAllRepuestos() {
        return self::$repuestos;
    }

    
    public function removeRepuesto($id): bool {
        if (isset(self::$repuestos[$id])) {
            unset(self::$repuestos[$id]);
            return true;
        }
        return false;
    }

    
    public static function clear() {
        self::$repuestos = [];
        self::$nextId = 1;
    }

    
    private function __clone() {}
    
    public function __wakeup() {}
}

?>
