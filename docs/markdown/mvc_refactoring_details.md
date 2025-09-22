# Refactorización a MVC en TP-Inventario: Detalles de la Transformación

Este documento detalla cómo las funcionalidades del proyecto TP-Inventario fueron refactorizadas para adherirse al patrón Modelo-Vista-Controlador (MVC), separando claramente las responsabilidades y mejorando la estructura del código.

---

## 1. Separación de la Lógica de Presentación (Vista)
### Antes: Lógica de E/S mezclada
Originalmente, la lógica para mostrar mensajes, menús y solicitar entradas al usuario probablemente estaba dispersa en varias partes del código, mezclada con la lógica de negocio o de control.
```php
// Posible código antes de la refactorización (ejemplo conceptual)
// En un solo archivo o función:
echo "--- Menú Principal ---" . PHP_EOL;
echo "1. Añadir Repuesto" . PHP_EOL;
$opcion = trim(fgets(STDIN));

if ($opcion == 1) {
    echo "Tipo de repuesto: ";
    $tipo = trim(fgets(STDIN));
    // ... lógica de negocio para añadir repuesto ...
}
```

### Después: `ConsoleView.php` como Vista dedicada
Se creó la clase `ConsoleView` para encapsular toda la interacción con la consola. Ahora, cualquier operación de entrada o salida se delega a esta clase, asegurando que la lógica de presentación esté centralizada y sea reutilizable.
```php
// src/Views/ConsoleView.php
namespace App\Views;

class ConsoleView
{
    public function displayMessage(string $message): void { /* ... */ }
    public function displayError(string $error): void { /* ... */ }
    public function displayInputPrompt(string $prompt): string { /* ... */ }
    public function displayMenuAndGetChoice(string $prompt, array $options): string { /* ... */ }
    // ... otras funciones de presentación ...
}
```
**Impacto MVC:** `ConsoleView` ahora es la **Vista**. Su única responsabilidad es mostrar información y obtener entradas del usuario, sin saber nada sobre la lógica de negocio.

---

## 2. Encapsulación de la Lógica de Negocio (Modelo)
### Antes: Lógica de negocio dispersa
La creación de objetos, la gestión de la base de datos (in-memory) y las reglas de negocio para el inventario podrían haber estado mezcladas con la interfaz de usuario o la lógica de control.

### Después: `Repuesto`, `InMemoryDatabase`, `RepuestoFactory` y `InventoryManager` como Modelo
La lógica de negocio se dividió en varias clases, cada una con una responsabilidad específica dentro del Modelo:
*   **Clases `Repuesto` (`Repuesto.php`, `RepuestoMoto.php`, etc.):** Definen la estructura de los datos y su comportamiento básico.
*   **`InMemoryDatabase.php`:** Se encarga de la persistencia de los datos (simulada).
*   **`RepuestoFactory.php`:** Centraliza la creación de instancias de `Repuesto`, desacoplando la lógica de creación del resto de la aplicación.
*   **`InventoryManager.php`:** Es el corazón del Modelo. Contiene las reglas de negocio para añadir, listar, editar y eliminar repuestos. Interactúa con `InMemoryDatabase` y `RepuestoFactory`, pero no directamente con la Vista o el Controlador.
```php
// src/Core/InventoryManager.php (ejemplo de método)
namespace App\Core;

use App\Database\InMemoryDatabase;
use App\Factories\RepuestoFactory;
use App\Models\Repuesto;

class InventoryManager
{
    private $db;
    private $repuestoFactory;

    public function __construct(InMemoryDatabase $db, RepuestoFactory $repuestoFactory) { /* ... */ }

    public function addSparePart(string $tipoRepuesto, /* ... */): Repuesto
    {
        // ... lógica para crear y añadir un repuesto ...
        $repuesto = $this->repuestoFactory->crearRepuesto($tipoRepuesto, $datosRepuesto);
        $this->db->addRepuesto($repuesto);
        return $repuesto;
    }

    public function getSparePartById(int $id): ?Repuesto
    {
        return $this->db->getRepuestoById($id);
    }
    // ... otros métodos de negocio ...
}
```
**Impacto MVC:** Estas clases forman el **Modelo**. Contienen los datos y la lógica de negocio, siendo completamente independientes de cómo se presentan o cómo se interactúa con el usuario.

---

## 3. Orquestación de la Lógica (Controlador)
### Antes: Lógica de control y flujo mezclada
El flujo de la aplicación y la respuesta a las acciones del usuario probablemente estaban entrelazados con la lógica de negocio y la presentación.

### Después: `InventoryController.php` como Controlador dedicado
La clase `InventoryController` se encarga de recibir las acciones del usuario (a través de la Vista), decidir qué lógica de negocio ejecutar (en el Modelo) y cómo actualizar la Vista. Actúa como el intermediario principal.
```php
// src/Controllers/InventoryController.php (ejemplo de método)
namespace App\Controllers;

use App\Views\ConsoleView;
use App\Core\InventoryManager;
use App\Core\Menu;

class InventoryController
{
    private InventoryManager $inventoryManager;
    private ConsoleView $view;
    private Menu $mainMenu;

    public function __construct(InventoryManager $inventoryManager, ConsoleView $view, Menu $mainMenu) { /* ... */ }

    public function run(): void
    {
        while (true) {
            $this->mainMenu->mostrar();
            $opcion = $this->mainMenu->obtenerSeleccion();

            switch ($opcion) {
                case 1: // Añadir Repuesto
                    $this->addSparePart();
                    break;
                // ... otros casos ...
            }
        }
    }

    private function addSparePart(): void
    {
        $this->view->displayMessage("--- Añadir Nuevo Repuesto ---");
        $availableTypes = ['Moto', 'Camion', 'Camioneta'];
        $tipo = $this->view->displayMenuAndGetChoice("Tipo de repuesto:", $availableTypes);
        $nombre = $this->view->displayInputPrompt("Nombre: ");
        // ... obtiene más datos de la Vista ...

        try {
            $this->inventoryManager->addSparePart($tipo, $nombre, /* ... */);
            $this->view->displayMessage("Repuesto añadido con éxito.");
        } catch (\Exception $e) {
            $this->view->displayError($e->getMessage());
        }
    }
}
```
**Impacto MVC:** `InventoryController` es el **Controlador**. Maneja la entrada del usuario, coordina las interacciones entre el Modelo y la Vista, y controla el flujo de la aplicación.

---

## 4. Punto de Entrada de la Aplicación (`Main.php`)
### Antes: Lógica de inicialización y ejecución mezclada
El archivo principal podría haber contenido una mezcla de inicialización, lógica de negocio y bucles de interacción.

### Después: `Main.php` como Bootstrap
Ahora, `Main.php` se encarga únicamente de inicializar todas las dependencias (Modelo, Vista, Controlador) y de iniciar el ciclo de ejecución del Controlador. Es un punto de entrada limpio y desacoplado.
```php
// src/Core/Main.php
// ... require_once de todas las clases ...

use App\Core\Menu;
use App\Core\InventoryManager;
use App\Core\ConsoleMenuRenderer;
use App\Controllers\InventoryController;
use App\Views\ConsoleView;
use App\Database\InMemoryDatabase;
use App\Factories\RepuestoFactory;

$db = InMemoryDatabase::getInstance();
$repuestoFactory = new RepuestoFactory();
$inventoryManager = new InventoryManager($db, $repuestoFactory);
$consoleRenderer = new ConsoleMenuRenderer();
$consoleView = new ConsoleView();
$mainMenu = Menu::createMainMenu($inventoryManager, $consoleRenderer);

$controller = new InventoryController($inventoryManager, $consoleView, $mainMenu);
$controller->run(); // Inicia el ciclo de la aplicación
```
**Impacto MVC:** `Main.php` actúa como el orquestador de alto nivel que ensambla los componentes MVC y pone la aplicación en marcha.

**Conclusión:** Esta refactorización ha transformado una aplicación potencialmente monolítica en una estructura MVC clara, donde cada componente tiene una responsabilidad única. Esto facilita la comprensión, el mantenimiento y la escalabilidad del código.
