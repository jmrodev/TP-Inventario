# Documentación: Refactorización del Sistema de Menú e Inventario (TP-Inventario)

Esta refactorización se llevó a cabo con el objetivo principal de mejorar la modularidad, la adherencia a los principios de la Programación Orientada a Objetos (POO) y simplificar la lógica en el archivo principal `Main.php`. Los cambios se centraron en separar las responsabilidades de la lógica de negocio del inventario de la presentación del menú.

## Cambios Realizados

### 1. Nueva Clase: `InventoryManager.php`
*   **Propósito:** Encapsular toda la lógica de negocio relacionada con la gestión de repuestos. Esto incluye las operaciones CRUD (Crear, Leer, Actualizar, Eliminar) sobre los objetos `Repuesto`.
*   **Responsabilidades:
    *   Manejar la interacción con el usuario para la entrada de datos de repuestos.
    *   Utilizar `RepuestoFactory` para crear instancias de `Repuesto` según el tipo.
    *   Interactuar con `InMemoryDatabase` para almacenar, recuperar, actualizar y eliminar repuestos.
*   **Dependencias:** Recibe instancias de `InMemoryDatabase` y `RepuestoFactory` a través de su constructor (Inyección de Dependencias).
*   **Métodos Implementados:**
    *   `addSparePart()`: Permite al usuario añadir un nuevo repuesto al inventario.
    *   `listSpareParts()`: Muestra un listado detallado de todos los repuestos en el inventario.
    *   `editSparePart()`: Permite al usuario buscar y modificar los detalles de un repuesto existente.
    *   `deleteSparePart()`: Permite al usuario eliminar un repuesto por su ID.
    *   `exitApplication()`: Un método simple para indicar la salida de la aplicación.

### 2. Modificación de la Clase `Menu` (`Menu.php`)
*   **Adición de un Método Estático de Fábrica:** Se añadió el método `public static function createMainMenu(InventoryManager $manager): self`.
*   **Propósito:** Centralizar la definición de las opciones del menú principal y sus acciones asociadas. En lugar de definir las acciones como funciones anónimas en `Main.php`, ahora se referencian los métodos de la instancia de `InventoryManager`.
*   **Beneficio:** `Main.php` se vuelve más limpio y declarativo, ya que la configuración del menú se abstrae dentro de la propia clase `Menu`.

### 3. Modificación de `Main.php`
*   **Antes:** Contenía la lógica detallada de las acciones del menú dentro de funciones anónimas, lo que lo hacía denso y menos mantenible. También era responsable de la creación explícita del objeto `Menu` con todas sus opciones.
*   **Después:** Su rol se ha simplificado a la orquestación de la aplicación. Ahora se encarga de:
    *   Inicializar las dependencias clave (`InMemoryDatabase`, `RepuestoFactory`).
    *   Crear una instancia de `InventoryManager`.
    *   Utilizar el método estático de fábrica `Menu::createMainMenu()` para obtener una instancia del menú principal, pasándole el `InventoryManager`.
    *   Iniciar el ciclo del menú.

### 4. Correcciones en `bd.php`
*   **Arreglo del Patrón Singleton:** Se corrigió el método `InMemoryDatabase::getInstance()` para asegurar que la instancia de la base de datos se cree correctamente la primera vez que se solicita, evitando un `TypeError`.
*   **Corrección de Visibilidad de `__wakeup()`:** Se cambió la visibilidad del método mágico `__wakeup()` de `private` a `public`, según lo requiere PHP.

## Comparación de Código (Antes y Después)

### `Main.php`
#### Antes:
```php
<?php

require_once 'bd.php';
require_once 'Repuesto.php';
require_once 'RepuestoMoto.php';
require_once 'RepuestoCamion.php';
require_once 'RepuestoCamioneta.php';
require_once 'Menu.php';
require_once 'RepuestoFactory.php';


$db = InMemoryDatabase::getInstance();

$opcionesMenuPrincipal = [
    1 => ['descripcion' => 'Añadir Repuesto', 'accion' => function() use ($db) {
        echo "--- Añadir Nuevo Repuesto ---
";
        echo "Seleccione el tipo de repuesto:
";
        echo "1. Moto
";
        echo "2. Camion
";
        echo "3. Camioneta
";
        echo "Ingrese su opción: ";
        $tipoOpcion = trim(fgets(STDIN));

        $tipoRepuesto = '';
        switch ($tipoOpcion) {
            case '1': $tipoRepuesto = 'Moto'; break;
            case '2': $tipoRepuesto = 'Camion'; break;
            case '3': $tipoRepuesto = 'Camioneta'; break;
            default:
                echo "Opción de tipo de repuesto inválida.
";
                return;
        }

        echo "Nombre: ";
        $nombre = trim(fgets(STDIN));
        echo "Descripción: ";
        $descripcion = trim(fgets(STDIN));
        echo "Precio: ";
        $precio = (float)trim(fgets(STDIN));
        echo "Cantidad: ";
        $cantidad = (int)trim(fgets(STDIN));
        echo "Marca: ";
        $marca = trim(fgets(STDIN));
        echo "Modelo: ";
        $modelo = trim(fgets(STDIN));

        $datosRepuesto = [
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'cantidad' => $cantidad,
            'marca' => $marca,
            'modelo' => $modelo,
        ];

        if ($tipoRepuesto === 'Camioneta') {
            echo "Tracción (ej: 4x2, 4x4): ";
            $datosRepuesto['traccion'] = trim(fgets(STDIN));
        }

        $repuesto = RepuestoFactory::crearRepuesto($tipoRepuesto, $datosRepuesto);

        if ($repuesto) {
            $db->addRepuesto($repuesto);
            echo "Repuesto de " . $tipoRepuesto . " añadido con éxito (ID: " . $repuesto->getId() . ").\n";
        } else {
            echo "No se pudo crear el repuesto.\n";
        }
    }],
    2 => ['descripcion' => 'Listar Repuestos (funcionalidad no disponible)', 'accion' => function() { echo "Funcionalidad de listar repuestos no implementada.\n"; }],
    3 => ['descripcion' => 'Editar Repuesto (funcionalidad no disponible)', 'accion' => function() { echo "Funcionalidad de editar repuesto no implementada.\n"; }],
    4 => ['descripcion' => 'Eliminar Repuesto (funcionalidad no disponible)', 'accion' => function() { echo "Funcionalidad de eliminar repuesto no implementada.\n"; }],
    5 => ['descripcion' => 'Salir', 'accion' => function() { echo "Saliendo de la aplicación...\n"; }]
];

$menuPrincipal = new Menu("Menú Principal de Inventario", $opcionesMenuPrincipal);

$menuPrincipal->iniciar();

echo "¡Aplicación finalizada!\n";

?>
```

#### Después:
```php
<?php

require_once 'bd.php';
require_once 'Repuesto.php';
require_once 'RepuestoMoto.php';
require_once 'RepuestoCamion.php';
require_once 'RepuestoCamioneta.php';
require_once 'RepuestoFactory.php';
require_once 'Menu.php';
require_once 'InventoryManager.php';

// Inicialización de dependencias
$db = InMemoryDatabase::getInstance();
$repuestoFactory = new RepuestoFactory();

// Instanciar el manejador de inventario
$inventoryManager = new InventoryManager($db, $repuestoFactory);

// Crear el menú principal usando el método estático de fábrica
$menuPrincipal = Menu::createMainMenu($inventoryManager);

// Iniciar el menú
$menuPrincipal->iniciar();

echo "¡Aplicación finalizada!\n";

?>
```

### `Menu.php`
#### Antes (fragmento relevante del final de la clase):
```php
    public function iniciar() {
        $continuarMenu = true;

        do {
            $this->mostrar();
            $seleccion = $this->obtenerSeleccion();
            $continuarMenu = $this->ejecutarOpcion($seleccion);
        } while ($continuarMenu);

        echo "Saliendo del menú...\n";
    }
}

?>
```

#### Después (fragmento relevante del final de la clase):
```php
    public function iniciar() {
        $continuarMenu = true;

        do {
            $this->mostrar();
            $seleccion = $this->obtenerSeleccion();
            $continuarMenu = $this->ejecutarOpcion($seleccion);
        } while ($continuarMenu);

        echo "Saliendo del menú...\n";
    }

    /**
     * Método estático de fábrica para crear el menú principal de inventario.
     *
     * @param InventoryManager $manager La instancia de InventoryManager para ejecutar las acciones.
     * @return Menu Una nueva instancia del menú principal.
     */
    public static function createMainMenu(InventoryManager $manager): self {
        $opciones = [
            1 => ['descripcion' => 'Añadir Repuesto', 'accion' => [$manager, 'addSparePart']],
            2 => ['descripcion' => 'Listar Repuestos', 'accion' => [$manager, 'listSpareParts']],
            3 => ['descripcion' => 'Editar Repuesto', 'accion' => [$manager, 'editSparePart']],
            4 => ['descripcion' => 'Eliminar Repuesto', 'accion' => [$manager, 'deleteSparePart']],
            5 => ['descripcion' => 'Salir', 'accion' => [$manager, 'exitApplication']]
        ];
        return new self("Menú Principal de Inventario", $opciones);
    }
}

?>
```

### `InventoryManager.php`
#### Después (Archivo completo, ya que es nuevo):
```php
<?php

require_once 'bd.php';
require_once 'RepuestoFactory.php';
require_once 'Repuesto.php'; // Asegurarse de que Repuesto.php esté incluido para el tipo Repuesto
require_once 'RepuestoCamioneta.php'; // Necesario para instanceof en listSpareParts y editSparePart

class InventoryManager {
    private $db;
    private $repuestoFactory;

    public function __construct(InMemoryDatabase $db, RepuestoFactory $repuestoFactory) {
        $this->db = $db;
        $this->repuestoFactory = $repuestoFactory;
    }

    public function addSparePart() {
        echo "--- Añadir Nuevo Repuesto ---
";
        echo "Seleccione el tipo de repuesto:
";
        echo "1. Moto
";
        echo "2. Camion
";
        echo "3. Camioneta
";
        echo "Ingrese su opción: ";
        $tipoOpcion = trim(fgets(STDIN));

        $tipoRepuesto = '';
        switch ($tipoOpcion) {
            case '1': $tipoRepuesto = 'Moto'; break;
            case '2': $tipoRepuesto = 'Camion'; break;
            case '3': $tipoRepuesto = 'Camioneta'; break;
            default:
                echo "Opción de tipo de repuesto inválida.
";
                return;
        }

        echo "Nombre: ";
        $nombre = trim(fgets(STDIN));
        echo "Descripción: ";
        $descripcion = trim(fgets(STDIN));
        echo "Precio: ";
        $precio = (float)trim(fgets(STDIN));
        echo "Cantidad: ";
        $cantidad = (int)trim(fgets(STDIN));
        echo "Marca: ";
        $marca = trim(fgets(STDIN));
        echo "Modelo: ";
        $modelo = trim(fgets(STDIN));

        $datosRepuesto = [
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'cantidad' => $cantidad,
            'marca' => $marca,
            'modelo' => $modelo,
        ];

        if ($tipoRepuesto === 'Camioneta') {
            echo "Tracción (ej: 4x2, 4x4): ";
            $datosRepuesto['traccion'] = trim(fgets(STDIN));
        }

        $repuesto = $this->repuestoFactory->crearRepuesto($tipoRepuesto, $datosRepuesto);

        if ($repuesto) {
            $this->db->addRepuesto($repuesto);
            echo "Repuesto de " . $tipoRepuesto . " añadido con éxito (ID: " . $repuesto->getId() . ").\n";
        } else {
            echo "No se pudo crear el repuesto.\n";
        }
    }

    public function listSpareParts() {
        echo "--- Listado de Repuestos ---
";
        $repuestos = $this->db->getAllRepuestos();
        if (empty($repuestos)) {
            echo "No hay repuestos en el inventario.\n";
            return;
        }

        foreach ($repuestos as $repuesto) {
            echo "--------------------------------------\n";
            echo "ID: " . $repuesto->getId() . "\n";
            echo "Nombre: " . $repuesto->getNombre() . "\n";
            echo "Descripción: " . $repuesto->getDescripcion() . "\n";
            echo "Precio: " . $repuesto->getPrecio() . "\n";
            echo "Cantidad: " . $repuesto->getCantidad() . "\n";
            echo "Categoría: " . $repuesto->getCategoria() . "\n";
            echo "Marca: " . $repuesto->getMarca() . "\n";
            echo "Modelo: " . $repuesto->getModelo() . "\n";
            if ($repuesto instanceof RepuestoCamioneta) {
                echo "Tracción: " . $repuesto->getTraccion() . "\n";
            }
        }
        echo "--------------------------------------\n";
    }

    public function editSparePart() {
        echo "--- Editar Repuesto ---
";
        echo "Ingrese el ID del repuesto a editar: ";
        $id = (int)trim(fgets(STDIN));

        $repuesto = $this->db->getRepuestoById($id);

        if (!$repuesto) {
            echo "Repuesto con ID " . $id . " no encontrado.\n";
            return;
        }

        echo "Repuesto actual: " . $repuesto->getNombre() . " (ID: " . $repuesto->getId() . ")\n";
        echo "Ingrese nuevos valores (deje en blanco para mantener el actual):\n";

        echo "Nombre (actual: " . $repuesto->getNombre() . "): ";
        $nombre = trim(fgets(STDIN));
        if (!empty($nombre)) { $repuesto->setNombre($nombre); }

        echo "Descripción (actual: " . $repuesto->getDescripcion() . "): ";
        $descripcion = trim(fgets(STDIN));
        if (!empty($descripcion)) { $repuesto->setDescripcion($descripcion); }

        echo "Precio (actual: " . $repuesto->getPrecio() . "): ";
        $precio = trim(fgets(STDIN));
        if (!empty($precio)) { $repuesto->setPrecio((float)$precio); }

        echo "Cantidad (actual: " . $repuesto->getCantidad() . "): ";
        $cantidad = trim(fgets(STDIN));
        if (!empty($cantidad)) { $repuesto->setCantidad((int)$cantidad); }

        echo "Marca (actual: " . $repuesto->getMarca() . "): ";
        $marca = trim(fgets(STDIN));
        if (!empty($marca)) { $repuesto->setMarca($marca); }

        echo "Modelo (actual: " . $repuesto->getModelo() . "): ";
        $modelo = trim(fgets(STDIN));
        if (!empty($modelo)) { $repuesto->setModelo($modelo); }

        if ($repuesto instanceof RepuestoCamioneta) {
            echo "Tracción (actual: " . $repuesto->getTraccion() . "): ";
            $traccion = trim(fgets(STDIN));
            if (!empty($traccion)) { $repuesto->setTraccion($traccion); }
        }

        echo "Repuesto con ID " . $id . " actualizado con éxito.\n";
    }

    public function deleteSparePart() {
        echo "--- Eliminar Repuesto ---
";
        echo "Ingrese el ID del repuesto a eliminar: ";
        $id = (int)trim(fgets(STDIN));

        if ($this->db->removeRepuesto($id)) {
            echo "Repuesto con ID " . $id . " eliminado con éxito.\n";
        } else {
            echo "Repuesto con ID " . $id . " no encontrado.\n";
        }
    }

    public function exitApplication() {
        echo "Saliendo de la aplicación...\n";
    }
}

?>
```

### `bd.php`
#### Antes (fragmento relevante):
```php
    public static function getInstance(): InMemoryDatabase {
        if (self::$instance === null) {
            
        }
        return self::$instance;
    }

    // ...

    private function __wakeup() {}
}
```

#### Después (fragmento relevante):
```php
    public static function getInstance(): InMemoryDatabase {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // ...

    public function __wakeup() {}
}
```