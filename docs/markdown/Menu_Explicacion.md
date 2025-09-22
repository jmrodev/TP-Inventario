# Explicación Detallada de la Clase `Menu` (POO PHP)

Esta documentación explica la implementación de una clase `Menu` en PHP, diseñada para aplicaciones de línea de comandos (CLI). El objetivo es proporcionar una interfaz de usuario sencilla y modular para interactuar con la aplicación, siguiendo principios básicos de la Programación Orientada a Objetos (POO).

## Concepto General

La clase `Menu` encapsula toda la lógica necesaria para mostrar opciones al usuario, capturar su selección y ejecutar una acción predefinida. Esto permite que el código principal de la aplicación se mantenga limpio y se enfoque en la lógica de negocio, delegando la interacción con el usuario al objeto `Menu`.

## Estructura de la Clase `Menu`

```php
<?php

class Menu {
    private $titulo;
    private $opciones;

    // ... métodos ...
}

?>
```

### Propiedades (Atributos)

*   `private $titulo;`: Una cadena de texto que almacena el título principal del menú (ej., "Menú Principal de Inventario"). Es `private` para que solo los métodos de la propia clase puedan acceder o modificarlo directamente, promoviendo el encapsulamiento.
*   `private $opciones;`: Un array asociativo donde la clave es el número de la opción (ej., `1`, `2`, `3`) y el valor es **otro array asociativo** con dos claves:
    *   `'descripcion'`: Una cadena de texto que describe la opción (ej., "Añadir Repuesto").
    *   `'accion'`: Un "callable" (una función anónima o un array `[$objeto, 'nombreMetodo']`) que se ejecutará cuando el usuario seleccione esta opción.
    Es `private` por las mismas razones de encapsulamiento.

## Métodos (Comportamientos)

### `__construct($titulo, array $opciones)`

Este es el **constructor** de la clase. Se ejecuta automáticamente cada vez que se crea una nueva instancia (objeto) de `Menu`.

*   **Propósito:** Inicializar las propiedades `$titulo` y `$opciones` del objeto `Menu` con los valores proporcionados al momento de su creación.
*   **Parámetros:**
    *   `$titulo`: La cadena de texto que será el título del menú.
    *   `array $opciones`: Un array asociativo con las opciones del menú, siguiendo la estructura `[numero => ['descripcion' => '...', 'accion' => callable]]`.
*   **Funcionamiento:** Asigna los valores de los parámetros a las propiedades internas `$this->titulo` y `$this->opciones`.

```php
public function __construct($titulo, array $opciones) {
    $this->titulo = $titulo;
    $this->opciones = $opciones;
}
```

### `mostrar()`

Este método se encarga de presentar visualmente el menú al usuario en la consola.

*   **Propósito:** Imprimir el título del menú y cada una de las opciones numeradas con su descripción.
*   **Funcionamiento:**
    1.  Imprime el `$titulo` del menú, enmarcado para una mejor visibilidad.
    2.  Recorre el array `$opciones` usando un bucle `foreach`.
    3.  Para cada opción, imprime su número (clave) y su `'descripcion'` (valor del sub-array) en una nueva línea.
    4.  Añade un separador al final para mejorar la legibilidad.

```php
public function mostrar() {
    echo PHP_EOL . "--------------------------------------" . PHP_EOL;
    echo " --- " . $this->titulo . " ---
";
    foreach ($this->opciones as $numero => $opcion) {
        echo $numero . " . " . $opcion['descripcion'] . PHP_EOL;
    }
    echo "--------------------------------------" . PHP_EOL;
}
```

### `obtenerSeleccion()`

Este método interactúa con el usuario para obtener su elección.

*   **Propósito:** Solicitar al usuario que ingrese su opción y capturar esa entrada desde la consola.
*   **Funcionamiento:**
    1.  Imprime un mensaje pidiendo al usuario que ingrese su opción.
    2.  Utiliza `fgets(STDIN)` para leer la línea completa que el usuario escribe. `STDIN` representa la entrada estándar (el teclado).
    3.  Utiliza `trim()` para eliminar cualquier espacio en blanco o salto de línea extra que `fgets()` pueda haber capturado, asegurando una entrada limpia.
    4.  Devuelve la entrada limpia del usuario.

```php
public function obtenerSeleccion() {
    echo "Ingrese su opción: ";
    $seleccion = trim(fgets(STDIN));
    return $seleccion;
}
```

### `ejecutarOpcion($seleccion)`

Este método procesa la opción elegida por el usuario y ejecuta la acción asociada.

*   **Propósito:** Tomar la selección del usuario, verificar su validez y ejecutar el "callable" (función o método) asociado a esa opción.
*   **Parámetros:**
    *   `$seleccion`: La opción (número) ingresada por el usuario.
*   **Funcionamiento:**
    1.  Verifica si la `$seleccion` existe como una clave válida en el array `$opciones` usando `array_key_exists()`.
    2.  Si la opción es válida:
        *   Obtiene el sub-array de la opción seleccionada, que contiene la `'descripcion'` y la `'accion'`.
        *   Imprime un mensaje confirmando la selección.
        *   Verifica si la `'accion'` es un "callable" (una función o un método ejecutable) usando `is_callable()`.
        *   Si es un callable, lo ejecuta usando `call_user_func($accion)`.
        *   Si la acción no es ejecutable, imprime un mensaje de error.
        *   Si la `'descripcion'` de la opción es "Salir", devuelve `false` para indicar que el bucle principal del menú debe terminar.
    3.  Si la opción no es válida, imprime un mensaje de error.
    4.  En cualquier otro caso (opción válida pero no "Salir"), devuelve `true` para indicar que el menú debe continuar.

```php
public function ejecutarOpcion($seleccion) {
    if (array_key_exists($seleccion, $this->opciones)) {
        $opcionSeleccionada = $this->opciones[$seleccion];
        $descripcion = $opcionSeleccionada['descripcion'];
        $accion = $opcionSeleccionada['accion'];

        echo "Ha seleccionado: " . $descripcion . PHP_EOL;

        if (is_callable($accion)) {
            call_user_func($accion);
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

### `iniciar()`

Este es el método principal que orquesta el funcionamiento del menú.

*   **Propósito:** Ejecutar el ciclo completo del menú (mostrar, obtener selección, ejecutar acción) de forma repetida hasta que el usuario decida salir.
*   **Funcionamiento:**
    1.  Inicializa una variable booleana `$continuarMenu` a `true`.
    2.  Entra en un bucle `do-while`, lo que asegura que el menú se muestre al menos una vez.
    3.  Dentro del bucle:
        *   Llama a `$this->mostrar()` para imprimir el menú.
        *   Llama a `$this->obtenerSeleccion()` para capturar la entrada del usuario.
        *   Llama a `$this->ejecutarOpcion($seleccion)`. El valor de retorno de este método (`true` o `false`) se asigna a `$continuarMenu`.
    4.  El bucle `while ($continuarMenu)` continúa mientras `$continuarMenu` sea `true`. Cuando `ejecutarOpcion()` devuelve `false` (porque el usuario eligió "Salir"), el bucle termina.
    5.  Finalmente, imprime un mensaje de despedida.

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
```

## Ejemplo de Uso (en `Main.php`)

Para utilizar esta clase `Menu`, en tu archivo principal (ahora `Main.php`), necesitarías:

1.  Incluir el archivo `Menu.php`.
2.  Definir las opciones de tu menú en un array asociativo, donde cada opción es un sub-array con `'descripcion'` y `'accion'` (un callable).
3.  Crear una instancia de la clase `Menu`, pasándole el título y las opciones.
4.  Llamar al método `iniciar()` de tu objeto `Menu`.

```php
<?php
// Incluir la definición de la clase Menu
require_once 'Menu.php';

// Definir las opciones del menú principal
$opcionesMenuPrincipal = [
    1 => ['descripcion' => 'Añadir Repuesto', 'accion' => function() { echo "Acción de añadir repuesto."; }],
    2 => ['descripcion' => 'Listar Repuestos', 'accion' => function() { echo "Acción de listar repuestos."; }],
    3 => ['descripcion' => 'Salir', 'accion' => function() { echo "Saliendo..."; }]
];

// Crear una instancia del menú
$menuPrincipal = new Menu("Menú Principal de Inventario", $opcionesMenuPrincipal);

// Iniciar el menú
$menuPrincipal->iniciar();

echo "¡Aplicación finalizada!\n";
?>
```

```