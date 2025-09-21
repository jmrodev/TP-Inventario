<?php

require_once 'Repuesto.php';
require_once 'RepuestoMoto.php';
require_once 'RepuestoCamion.php';
require_once 'RepuestoCamioneta.php';
require_once 'RepuestoFactory.php';

class InMemoryDatabase {
    
    private static $instance = null;

    private static $repuestos = [];
    private static $nextId = 1;

    
    private function __construct() {
        echo "InMemoryDatabase: Instancia creada y lista.\n";
        $this->seedData();
    }

    private function seedData() {
        // Create a temporary factory instance for seeding
        $factory = new RepuestoFactory();

        $repuesto1 = $factory->crearRepuesto('Moto', [
            'nombre' => 'Filtro de Aire Moto', 
            'descripcion' => 'Filtro de aire de alto rendimiento para motos',
            'precio' => 25.50, 
            'cantidad' => 10, 
            'marca' => 'K&N', 
            'modelo' => 'Universal'
        ]);
        if ($repuesto1) $this->addRepuesto($repuesto1);

        $repuesto2 = $factory->crearRepuesto('Camion', [
            'nombre' => 'Pastillas de Freno Camion', 
            'descripcion' => 'Pastillas de freno para camiones de carga pesada',
            'precio' => 120.00, 
            'cantidad' => 5, 
            'marca' => 'Brembo', 
            'modelo' => 'Serie 500'
        ]);
        if ($repuesto2) $this->addRepuesto($repuesto2);

        $repuesto3 = $factory->crearRepuesto('Camioneta', [
            'nombre' => 'Amortiguador Camioneta', 
            'descripcion' => 'Amortiguador trasero para camioneta 4x4',
            'precio' => 85.75, 
            'cantidad' => 8, 
            'marca' => 'Monroe', 
            'modelo' => 'Hilux', 
            'traccion' => '4x4'
        ]);
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