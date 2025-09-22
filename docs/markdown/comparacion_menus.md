# Análisis Comparativo de Implementaciones de Menú (POO PHP)

Este documento compara dos implementaciones de sistemas de menú basadas en Programación Orientada a Objetos (POO) en PHP, una encontrada en el proyecto `gestionbase` y otra en `TP-Inventario`.

## Clase `Opcion`

| Característica | Implementación `gestionbase` (librerias/Opcion.php) | Implementación `TP-Inventario` (Menu.php) |
| :--- | :--- | :--- |
| **Nombre Propiedad Acción** | `$funcion` | `$accion` |
| **Propósito** | Almacena el nombre visible y la función asociada. | Almacena el nombre visible y la acción asociada. |
| **Encapsulamiento** | Propiedades `private`, `getters` públicos. | Propiedades `private`, `getters` públicos. |
| **Constructor** | `__construct($nombre, $funcion)` | `__construct($nombre, $accion)` |

**Conclusión `Opcion`:** Ambas clases `Opcion` son conceptualmente idénticas, sirviendo para encapsular el texto a mostrar y la acción a ejecutar. La diferencia en el nombre de la propiedad (`$funcion` vs. `$accion`) es meramente semántica.

## Clase `Menu`

| Característica | Implementación `gestionbase` (librerias/Menu.php) | Implementación `TP-Inventario` (Menu.php) |
| :--- | :--- | :--- |
| **Propiedades** | `$titulo`, `$opciones` (array de `Opcion`) | `$titulo`, `$opciones` (array de `Opcion`) |
| **Constructor** | `__construct($titulo)` | `__construct($titulo)` |
| **Método `addOpcion`** | `addOpcion($opcion)` | `addOpcion($opcion)` |
| **Método `mostrar`** | Llama a `system('clear')`, usa una función global `mostrar()` para imprimir título y opciones. | Llama a `system('clear')`, usa `echo` directamente para imprimir título y opciones. |
| **Método `elegir`** | Llama a `mostrar()`, lee `STDIN`, bucle `do-while` para entrada no vacía. Devuelve el objeto `Opcion` seleccionado. | Llama a `mostrar()`, lee `STDIN`, bucle `do-while` con **validación robusta** (numérico, rango). Devuelve el objeto `Opcion` seleccionado. |
| **Métodos Estáticos** | **Sí:** `getMenuPrincipal()`, `getMenuCiudades()` para crear menús predefinidos. | **No:** No incluye métodos estáticos para la creación de menús. |
| **Manejo de Errores/Validación** | Validación básica de entrada no vacía en `elegir()`. | **Validación explícita y robusta** de la entrada del usuario (numérico y dentro del rango de opciones) en `elegir()`. |
| **Dependencias** | `require_once ('Opcion.php');` y asume una función global `mostrar()`. | La clase `Opcion` está definida en el mismo archivo, no requiere `require_once` externo para `Opcion`. Usa `echo` directamente. |

**Conclusión `Menu`:** La clase `Menu` en `TP-Inventario` presenta una implementación más autocontenida y robusta en cuanto a la validación de la entrada del usuario. Al incluir la clase `Opcion` en el mismo archivo, se reduce la necesidad de `require_once` externos para la funcionalidad básica del menú.

Por otro lado, la implementación de `gestionbase` ofrece una característica útil con sus **métodos estáticos para la creación de menús predefinidos**. Esto puede simplificar la configuración de menús comunes en una aplicación más grande, actuando como "fábricas" de menús.

## Conceptos de POO Aplicados (Comunes a Ambos)

*   **Encapsulamiento:** Ambas implementaciones utilizan propiedades `private` y métodos `public` (getters y setters) para controlar el acceso a los datos internos de las clases `Opcion` y `Menu`.
*   **Composición:** La clase `Menu` en ambos casos "compone" o "tiene" una colección de objetos `Opcion`, demostrando una relación "has-a".
*   **Abstracción:** Ambas clases abstraen la complejidad de la gestión de menús, proporcionando una interfaz sencilla para añadir opciones, mostrarlas y obtener la selección del usuario.

## Recomendaciones

*   Para proyectos donde se necesiten muchos menús predefinidos o una estructura de menú jerárquica, la aproximación con **métodos estáticos de fábrica** (como en `gestionbase`) puede ser muy eficiente.
*   Para una implementación de menú más **autocontenida y con validación de entrada robusta** directamente en la clase, la versión de `TP-Inventario` es excelente.
*   Se podría considerar **combinar las mejores características** de ambas:
    *   Mantener la validación robusta de `TP-Inventario`.
    *   Añadir métodos estáticos de fábrica a la clase `Menu` (si se considera útil para el proyecto `TP-Inventario`) para simplificar la creación de menús comunes.
    *   Asegurarse de que la función `mostrar()` (si se usa una global) esté bien definida o usar `echo` directamente para evitar dependencias ocultas.
