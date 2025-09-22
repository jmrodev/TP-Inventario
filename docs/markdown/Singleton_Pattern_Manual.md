# Manual del Patrón de Diseño Singleton (Instancia Única)

El patrón de diseño **Singleton** (Instancia Única) es uno de los patrones de diseño creacionales más simples. Su propósito es asegurar que una clase tenga **una sola instancia** y proporcionar un punto de acceso global a ella.

## 1. ¿Qué Problema Resuelve el Singleton?

Imagina que tienes un recurso en tu aplicación que solo debe existir una vez. Por ejemplo:

*   **Una conexión a una base de datos:** No quieres abrir múltiples conexiones a la misma base de datos, ya que es ineficiente y puede causar problemas.
*   **Un gestor de configuración:** Solo debe haber una forma de acceder a la configuración global de tu aplicación.
*   **Tu `InMemoryDatabase`:** Solo quieres una "copia" de tu base de datos en memoria para que todos los repuestos se guarden y se lean del mismo lugar.

El patrón Singleton resuelve este problema asegurando que una clase tenga **una y solo una instancia** en toda la aplicación, y que haya una forma fácil y global de acceder a esa única instancia.

## 2. Los Tres Pilares del Singleton

Para construir una clase Singleton, necesitas tres componentes clave:

### Pilar 1: El Constructor Privado (`private __construct()`)

*   **Propósito:** Evitar que alguien cree nuevas instancias de la clase usando `new MiClase()` desde fuera de la clase. Si el constructor es privado, solo la propia clase puede llamarlo.
*   **Analogía:** Es como si la fábrica de un producto especial solo tuviera una puerta de entrada que solo el gerente de la fábrica puede abrir. Nadie más puede entrar y pedir que se fabrique un nuevo producto.

### Pilar 2: La Propiedad Estática Privada (`private static $instancia`)

*   **Propósito:** Almacenar la única instancia de la clase una vez que ha sido creada. Como es `static`, esta propiedad pertenece a la clase misma, no a un objeto específico, y su valor es compartido por todas las partes de la aplicación que interactúan con la clase. Como es `private`, solo la clase puede acceder a ella directamente.
*   **Analogía:** Es como una caja fuerte dentro de la fábrica donde se guarda el "producto único" una vez que se ha fabricado. Solo la fábrica sabe dónde está y cómo acceder a él.

### Pilar 3: El Método Estático Público (`public static function getInstance()`)

*   **Propósito:** Este es el "guardián" del Singleton. Es el único punto de acceso para obtener la instancia de la clase. Su trabajo es verificar si la instancia ya existe. Si no existe, la crea y la guarda. Si ya existe, simplemente devuelve la que ya tiene guardada.
*   **Analogía:** Es el recepcionista de la fábrica. Cuando alguien pide el "producto único", el recepcionista primero mira en la caja fuerte. Si el producto no está, lo fabrica (usando la puerta privada) y lo guarda. Luego, le entrega el producto (ya sea el recién fabricado o el que ya estaba) a quien lo pidió.

## 3. ¿Cómo Funciona Paso a Paso?

Cuando llamas a `MiClase::getInstance()`:

### Primera Llamada:

*   El método `getInstance()` verifica si `$instancia` está vacío (`null`).
*   Como es la primera vez, `$instancia` está vacío.
*   Entonces, `getInstance()` llama al constructor privado (`new self()`) para crear la única instancia de la clase.
*   Esta nueva instancia se guarda en `$instancia`.
*   Finalmente, `getInstance()` devuelve esta instancia recién creada.

### Llamadas Posteriores:

*   El método `getInstance()` verifica si `$instancia` está vacío (`null`).
*   Como ya se creó en la primera llamada, `$instancia` *no* está vacío.
*   Entonces, `getInstance()` *no* crea una nueva instancia.
*   Simplemente devuelve la instancia que ya tiene guardada en `$instancia`.

De esta manera, no importa cuántas veces llames a `MiClase::getInstance()`, siempre obtendrás el mismo objeto.

## 4. Ejemplo Básico en PHP

```php
<?php

class Logger {
    private static $instance = null; // Pilar 2: Guarda la única instancia
    private $logFile;

    // Pilar 1: Constructor privado
    private function __construct() {
        $this->logFile = 'app.log';
        echo "Logger: Inicializando el sistema de registro.\n";
    }

    // Pilar 3: Método estático público para obtener la instancia
    public static function getInstance(): Logger {
        if (self::$instance === null) {
            self::$instance = new self(); // Crea la instancia si no existe
        }
        return self::$instance; // Devuelve la instancia existente
    }

    public function logMessage(string $message) {
        file_put_contents($this->logFile, date('Y-m-d H:i:s') . " - " . $message . "\n", FILE_APPEND);
        echo "Mensaje registrado: " . $message . "\n";
    }

    // Opcional: Evitar la clonación del objeto
    private function __clone() {}
    // Opcional: Evitar la deserialización del objeto
    private function __wakeup() {}
}

// --- Cómo usar el Singleton ---

// Primera vez que obtenemos el logger
$logger1 = Logger::getInstance();
$logger1->logMessage("La aplicación ha iniciado.");

// Segunda vez que obtenemos el logger
$logger2 = Logger::getInstance();
$logger2->logMessage("Un usuario ha iniciado sesión.");

// Comprobamos si \$logger1 y \$logger2 son el mismo objeto
if ($logger1 === $logger2) {
    echo "¡Correcto! \$logger1 y \$logger2 son la misma instancia.\n";
} else {
    echo "Error: Se crearon múltiples instancias del Logger.\n";
}

// Intentar crear una instancia directamente (esto causaría un error fatal)
// \$otroLogger = new Logger(); // Fatal Error: Call to private Logger::__construct()

?>
```

## 5. Relevancia para tu `InMemoryDatabase`

Aplicar el Singleton a `InMemoryDatabase` es perfecto porque asegura que todos los componentes de tu aplicación siempre trabajen con la misma colección de repuestos y evita la confusión de tener múltiples "bases de datos" en memoria, cada una con su propia lista de repuestos.

```
