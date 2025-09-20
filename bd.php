<?php

class InMemoryDatabase {
  private static $repuestos = [];
    private static $nextId = 1;

    public function connect() {
        return $this;
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

    public static function clear() {
        self::$repuestos = [];
        self::$nextId = 1;
    }
}

?>
