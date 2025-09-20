<?php

class InMemoryDatabase {
    
    private static $instance = null;

    private static $repuestos = [];
    private static $nextId = 1;

    
    private function __construct() {
        echo "InMemoryDatabase: Instancia creada y lista.\n";
    }

    
    public static function getInstance(): InMemoryDatabase {
        if (self::$instance === null) {
            
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
    
    private function __wakeup() {}
}

?>
