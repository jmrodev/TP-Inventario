# Documentación de Objetos `Repuesto` y Avance del Proyecto (POO PHP)

Esta documentación detalla la jerarquía de clases para los objetos `Repuesto` en el sistema de inventario, así como un resumen del progreso realizado en el proyecto hasta la fecha.

## Jerarquía de Clases `Repuesto`

El sistema de inventario se basa en una estructura de herencia para manejar diferentes tipos de repuestos, compartiendo características comunes y añadiendo propiedades específicas cuando es necesario.

### Clase Abstracta: `Repuesto`

`Repuesto` es la clase base abstracta de la cual heredan todos los tipos específicos de repuestos. Define las propiedades y comportamientos comunes a cualquier repuesto en el inventario.

```php
<?php

abstract class Repuesto {

    protected $id;
    protected $nombre;
    protected $descripcion;
    protected $precio;
    protected $cantidad;
    protected $categoria;
    protected $marca;
    protected $modelo;

    public function __construct($id, $nombre, $descripcion, $precio, $cantidad, $categoria, $marca, $modelo) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->cantidad = $cantidad;
        $this->categoria = $categoria;
        $this->marca = $marca;
        $this->modelo = $modelo;
    }

    // Getters y Setters para todas las propiedades...
}

?>
```

#### Propiedades (Atributos)

*   **`protected $id;`**: Identificador único del repuesto.
*   **`protected $nombre;`**: Nombre del repuesto.
*   **`protected $descripcion;`**: Descripción detallada del repuesto.
*   **`protected $precio;`**: Precio unitario del repuesto.
*   **`protected $cantidad;`**: Cantidad disponible en inventario.
*   **`protected $categoria;`**: Categoría a la que pertenece el repuesto (ej., "Camion", "Camioneta", "Moto").
*   **`protected $marca;`**: Marca del repuesto.
*   **`protected $modelo;`**: Modelo de vehículo al que aplica el repuesto.

Todas las propiedades son `protected`, lo que significa que son accesibles dentro de la propia clase y por las clases que heredan de ella. Esto permite un control adecuado sobre el acceso a los datos.

#### Constructor (`__construct`)

Inicializa todas las propiedades comunes al crear una nueva instancia de un repuesto.

#### Métodos (Getters y Setters)

La clase `Repuesto` incluye métodos `public` para obtener (`get`) y establecer (`set`) el valor de cada una de sus propiedades. Esto asegura que el acceso y la modificación de las propiedades se realicen de manera controlada (encapsulamiento).

### Clase: `RepuestoCamion`

Hereda de `Repuesto`. Representa un repuesto específico para camiones.

```php
<?php 

require_once 'Repuesto.php';

class RepuestoCamion extends Repuesto {
    public function __construct($id, $nombre, $descripcion, $precio, $cantidad, $marca, $modelo) {
        parent::__construct($id, $nombre, $descripcion, $precio, $cantidad, "Camion", $marca, $modelo);
    }
}

?>
```

#### Constructor (`__construct`)

Llama al constructor de la clase padre (`Repuesto`) usando `parent::__construct()`, pasando todos los parámetros necesarios y fijando la `categoria` como "Camion" automáticamente.

### Clase: `RepuestoCamioneta`

Hereda de `Repuesto`. Representa un repuesto específico para camionetas, añadiendo una propiedad única.

```php
<?php 

require_once 'Repuesto.php';

class RepuestoCamioneta extends Repuesto {
  private $traccion;

    public function __construct($id, $nombre, $descripcion, $precio, $cantidad, $traccion, $marca, $modelo) {
        parent::__construct($id, $nombre, $descripcion, $precio, $cantidad, "Camioneta", $marca, $modelo);
        $this->traccion = $traccion;
    }

    public function getTraccion() {
        return $this->traccion;
    }

    public function setTraccion($traccion) {
        $this->traccion = $traccion;
    }
}

?>
```

#### Propiedades Adicionales

*   **`private $traccion;`**: Tipo de tracción de la camioneta (ej., "4x2", "4x4"). Es `private` para ser gestionada internamente por la clase.

#### Constructor (`__construct`)

Llama al constructor de la clase padre, fijando la `categoria` como "Camioneta", y luego inicializa la propiedad `$traccion` específica de esta clase.

#### Métodos Específicos

Incluye `getTraccion()` y `setTraccion()` para acceder y modificar la propiedad `$traccion`.

### Clase: `RepuestoMoto`

Hereda de `Repuesto`. Representa un repuesto específico para motocicletas.

```php
<?php 

require_once 'Repuesto.php';

class RepuestoMoto extends Repuesto {
    public function __construct($id, $nombre, $descripcion, $precio, $cantidad, $marca, $modelo) {
        parent::__construct($id, $nombre, $descripcion, $precio, $cantidad, "Moto", $marca, $modelo);
    }
}

?>
```

#### Constructor (`__construct`)

Llama al constructor de la clase padre, fijando la `categoria` como "Moto" automáticamente.

## Cómo Hemos Llegado Hasta Aquí: Avance del Proyecto

El proyecto de inventario de repuestos ha evolucionado siguiendo un enfoque de Programación Orientada a Objetos (POO) y un aprendizaje iterativo, centrándonos en la simplicidad y la comprensión de los conceptos fundamentales.

### Hitos Clave:

*   **Definición de la Clase Base `Repuesto`:** Se estableció una clase abstracta `Repuesto` para encapsular las características comunes de todos los repuestos, sentando las bases para la herencia.
*   **Creación de Clases Heredadas:** Se implementaron `RepuestoCamion`, `RepuestoCamioneta` y `RepuestoMoto`, demostrando cómo las clases hijas pueden extender y especializar el comportamiento de la clase padre, incluyendo propiedades únicas como la `traccion` en `RepuestoCamioneta`.
*   **Simulación de Base de Datos (`InMemoryDatabase`):** Se desarrolló la clase `InMemoryDatabase` (en `bd.php`) para simular el almacenamiento y la gestión de objetos `Repuesto` en memoria, permitiendo probar la lógica de la aplicación sin necesidad de una base de datos real.
*   **Implementación de un Sistema de Menú (Clase `Menu`):** Se diseñó e implementó una clase `Menu` modular y sencilla para gestionar la interacción del usuario en la línea de comandos, permitiendo la navegación entre diferentes funcionalidades de la aplicación. Esto incluye métodos para mostrar opciones, obtener la selección del usuario y ejecutar acciones.
*   **Implementación del Patrón Factory (`RepuestoFactory`):** Se introdujo la clase `RepuestoFactory` para centralizar la lógica de creación de objetos `Repuesto`, desacoplando el código cliente de las clases concretas de repuestos y facilitando la adición de nuevos tipos.
*   **Documentación Detallada:** Se ha priorizado la creación de documentación clara y detallada (como este archivo y `Menu_Explicacion.html`) para cada componente clave, facilitando la comprensión y el aprendizaje.

### Filosofía de Desarrollo:

El desarrollo se ha guiado por los siguientes principios:

*   **Simplicidad:** Evitar conceptos avanzados y complejidades innecesarias, enfocándose en la comprensión de los fundamentos de POO.
*   **Discusión y Consulta:** Cada paso importante se ha discutido y consultado, asegurando que el proceso de aprendizaje sea interactivo y adaptado a las necesidades.
*   **Modularidad:** Separar las responsabilidades en clases distintas (`Repuesto`, `Menu`, `InMemoryDatabase`, `RepuestoFactory`) para facilitar el mantenimiento y la escalabilidad.
*   **Encapsulamiento:** Proteger las propiedades de los objetos mediante el uso de modificadores de acceso (`protected`, `private`) y proporcionar métodos públicos (getters/setters) para interactuar con ellas.

Este enfoque nos ha permitido construir una base sólida para la aplicación de inventario, entendiendo cada componente antes de avanzar a funcionalidades más complejas.
