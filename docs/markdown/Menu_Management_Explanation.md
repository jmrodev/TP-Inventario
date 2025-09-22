# Gestión de Menús en Aplicaciones CLI (POO PHP)

En el desarrollo de aplicaciones de línea de comandos (CLI) con PHP y Programación Orientada a Objetos (POO), la gestión de menús es un componente fundamental para la interacción con el usuario. Este documento explora dos enfoques para manejar las opciones de un menú, destacando sus ventajas y desventajas.

## 1. Gestión de Menú con Sentencias `if` (Enfoque Básico)

Este enfoque es intuitivo para principiantes y se basa en capturar la descripción de la opción seleccionada por el usuario y luego usar sentencias condicionales (`if`, `else if`) para determinar qué acción ejecutar.

### Concepto

Después de que el usuario selecciona una opción, se obtiene la descripción textual asociada a esa opción (por ejemplo, "Añadir Repuesto"). Luego, se compara esta descripción con una serie de condiciones predefinidas para ejecutar el código correspondiente.

### Ejemplo (dentro de `ejecutarOpcion` o similar)

```php
public function ejecutarOpcion($seleccion) {
    if (array_key_exists($seleccion, $this->opciones)) {
        $descripcion = $this->opciones[$seleccion]; // Capturamos la descripción

        echo "Has seleccionado: " . $descripcion . "\n";

        if ($descripcion === 'Añadir Repuesto') {
            // Lógica para añadir un repuesto
            echo "Ejecutando la función para añadir un repuesto...\n";
        } else if ($descripcion === 'Listar Repuestos') {
            // Lógica para listar repuestos
            echo "Ejecutando la función para listar repuestos...\n";
        } else if ($descripcion === 'Salir') {
            return false; // Indica que el menú debe detenerse
        } else {
            echo "Acción no implementada para: " . $descripcion . "\n";
        }
    } else {
        echo "Opción inválida. Por favor, intente de nuevo.\n";
    }
    return true; // Indica que el menú debe continuar
}
```

### Ventajas

*   **Simplicidad:** Fácil de entender e implementar para menús pequeños y estáticos.
*   **Claridad Directa:** La lógica es muy explícita, ya que cada `if` corresponde directamente a una descripción de opción.

### Desventajas

*   **Ineficiencia para Menús Dinámicos:** Si las opciones del menú cambian frecuentemente o se generan dinámicamente, mantener una larga cadena de `if/else if` se vuelve tedioso y propenso a errores.
*   **Acoplamiento Fuerte:** El código de la lógica de ejecución está fuertemente acoplado a las descripciones textuales de las opciones. Un cambio en la descripción requiere un cambio en la lógica condicional.
*   **Escalabilidad Limitada:** A medida que el número de opciones crece, el método `ejecutarOpcion` se vuelve muy largo y difícil de manejar.

## 2. Gestión de Menú Dinámica con el Array de Opciones (Enfoque Recomendado)

Este enfoque es más robusto y flexible, ideal para menús que pueden crecer o cambiar. Se basa en asociar cada opción no solo con una descripción, sino también con una acción (por ejemplo, una función o un método) que se ejecutará.

### Concepto

En lugar de solo almacenar descripciones, el array `$opciones` puede almacenar pares de clave-valor donde la clave es el número de la opción y el valor es un array asociativo que contiene tanto la descripción como la acción a ejecutar (por ejemplo, un "callback" o una referencia a una función/método).

### Modificación de la Clase `Menu` (Ejemplo Conceptual)

Para implementar esto, la propiedad `$opciones` y el método `ejecutarOpcion` necesitarían ser modificados. Aquí un ejemplo conceptual de cómo se podría estructurar el array de opciones y cómo se ejecutaría la acción.

#### Definición de Opciones (en `Main.php` o similar)

```php
// Definir las opciones del menú principal con acciones asociadas
$opcionesMenuPrincipal = [
    1 => ['descripcion' => 'Añadir Repuesto', 'accion' => function() {
        echo "Ejecutando la función para añadir un repuesto (desde un callback)...";
        // Aquí iría la llamada a la función o método real para añadir repuestos
    }],
    2 => ['descripcion' => 'Listar Repuestos', 'accion' => function() {
        echo "Ejecutando la función para listar repuestos (desde un callback)...";
        // Aquí iría la llamada a la función o método real para listar repuestos
    }],
    3 => ['descripcion' => 'Salir', 'accion' => function() {
        echo "Saliendo de la aplicación...";
    }]
];

// Crear una instancia del menú (el constructor necesitaría adaptarse)
// $menuPrincipal = new Menu("Menú Principal de Inventario", $opcionesMenuPrincipal);
```

#### Método `ejecutarOpcion` Modificado (Ejemplo Conceptual)

```php
public function ejecutarOpcion($seleccion) {
    if (array_key_exists($seleccion, $this->opciones)) {
        $opcionSeleccionada = $this->opciones[$seleccion];
        $descripcion = $opcionSeleccionada['descripcion'];
        $accion = $opcionSeleccionada['accion']; // Obtenemos la acción asociada

        echo "Has seleccionado: " . $descripcion . "\n";

        // Ejecutamos la acción (si es un callable)
        if (is_callable($accion)) {
            call_user_func($accion); // Ejecuta la función anónima o callback
        } else {
            echo "La acción para '" . $descripcion . "' no es ejecutable.\n";
        }

        if ($descripcion === 'Salir') {
            return false; // Indica que el menú debe detenerse
        }
    } else {
        echo "Opción inválida. Por favor, intente de nuevo.\n";
    }
    return true; // Indica que el menú debe continuar
}
```

### Ventajas

*   **Dinamismo y Flexibilidad:** Las opciones y sus acciones pueden ser definidas y modificadas fácilmente sin alterar la lógica central del menú.
*   **Bajo Acoplamiento:** La clase `Menu` no necesita saber los detalles de cada acción; simplemente las ejecuta. Esto promueve un diseño más modular.
*   **Escalabilidad:** Añadir nuevas opciones es tan simple como agregar un nuevo elemento al array `$opciones`.
*   **Reutilización:** Las funciones o métodos que realizan las acciones pueden ser reutilizados en otras partes de la aplicación.

### Desventajas

*   **Curva de Aprendizaje Inicial:** Puede ser un poco más complejo de entender al principio, especialmente el concepto de "callbacks" o funciones anónimas.
*   **Mayor Complejidad en la Definición:** La definición del array de opciones es más detallada.

### Uso de Métodos de Objeto como Acciones

Una extensión natural del enfoque dinámico es asociar las opciones del menú con métodos de objetos específicos. Esto es particularmente útil en POO, ya que permite que cada acción esté encapsulada dentro de la clase o clases responsables de esa funcionalidad.

#### Concepto

En lugar de una función anónima, la 'acción' en el array `$opciones` puede ser un array que especifique un objeto y el nombre de uno de sus métodos (`[$objeto, 'nombreMetodo']`). PHP permite llamar a estos "callables" de la misma manera que a las funciones anónimas.

#### Ejemplo: Clase `ManejadorInventario`

Imaginemos una clase `ManejadorInventario` que contiene la lógica para añadir y listar repuestos:

```php
class ManejadorInventario {
    public function añadirRepuesto() {
        echo "Lógica para añadir un nuevo repuesto (desde ManejadorInventario::añadirRepuesto)...";
    }

    public function listarRepuestos() {
        echo "Lógica para listar todos los repuestos (desde ManejadorInventario::listarRepuestos)...";
    }

    public function salirAplicacion() {
        echo "Cerrando la aplicación de inventario (desde ManejadorInventario::salirAplicacion)...";
    }
}
```

#### Definición de Opciones con Métodos de Objeto

```php
// Crear una instancia del manejador de inventario
$manejador = new ManejadorInventario();

// Definir las opciones del menú principal, asociando métodos de objeto
$opcionesMenuPrincipal = [
    1 => ['descripcion' => 'Añadir Repuesto', 'accion' => [$manejador, 'añadirRepuesto']],
    2 => ['descripcion' => 'Listar Repuestos', 'accion' => [$manejador, 'listarRepuestos']],
    3 => ['descripcion' => 'Salir', 'accion' => [$manejador, 'salirAplicacion']]
];

// El constructor del menú necesitaría recibir estas opciones
// $menuPrincipal = new Menu("Menú Principal de Inventario", $opcionesMenuPrincipal);
```

#### Método `ejecutarOpcion` (sin cambios, ya soporta callables)

La belleza de este enfoque es que el método `ejecutarOpcion` que ya hemos visto no necesita cambios, ya que `is_callable()` y `call_user_func()` de PHP son lo suficientemente flexibles como para manejar tanto funciones anónimas como arrays `[$objeto, 'nombreMetodo']`.

```php
public function ejecutarOpcion($seleccion) {
    if (array_key_exists($seleccion, $this->opciones)) {
        $opcionSeleccionada = $this->opciones[$seleccion];
        $descripcion = $opcionSeleccionada['descripcion'];
        $accion = $opcionSeleccionada['accion'];

        echo "Has seleccionado: " . $descripcion . "\n";

        if (is_callable($accion)) {
            call_user_func($accion); // Esto ejecutará el método del objeto
        } else {
            echo "La acción para '" . $descripcion . "' no es ejecutable.\n";
        }

        if ($descripcion === 'Salir') {
            return false;
        }
    } else {
        echo "Opción inválida. Por favor, intente de nuevo.\n";
    }
    return true;
}
```

### Ventajas Adicionales de Usar Métodos de Objeto

*   **Encapsulamiento:** La lógica de cada acción está contenida dentro de su propia clase, mejorando la organización del código.
*   **Cohesión:** Las clases se vuelven más cohesivas, ya que agrupan funcionalidades relacionadas.
*   **Reutilización y Mantenibilidad:** Facilita la reutilización de la lógica de negocio y simplifica el mantenimiento al tener responsabilidades claras.

## Conclusión

Mientras que el uso de sentencias `if` para gestionar menús es un buen punto de partida para comprender la lógica básica, el enfoque dinámico utilizando un array de opciones con acciones asociadas (callbacks) es significativamente más potente y escalable para aplicaciones POO en PHP. Este último método promueve un código más limpio, modular y fácil de mantener a largo plazo.

```