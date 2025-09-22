# Explicación del Patrón Modelo-Vista-Controlador (MVC) en TP-Inventario

El patrón de diseño Modelo-Vista-Controlador (MVC) es una arquitectura de software que separa la lógica de una aplicación en tres componentes principales interconectados. Esto ayuda a organizar el código, mejorar la mantenibilidad y facilitar el desarrollo colaborativo.

## Componentes del MVC

### 1. Modelo (Model)
El Modelo representa la lógica de negocio de la aplicación, los datos y las reglas para manipular esos datos. Es independiente de la interfaz de usuario y de cómo se presentan los datos.

En el proyecto TP-Inventario, los componentes del Modelo incluyen:
*   **Clases de Repuestos (`Repuesto.php`, `RepuestoMoto.php`, `RepuestoCamion.php`, `RepuestoCamioneta.php`):** Estas clases definen la estructura y el comportamiento de los diferentes tipos de repuestos. Contienen las propiedades (nombre, precio, cantidad, etc.) y los métodos para acceder y modificar esos datos (getters y setters).
*   **`InMemoryDatabase.php`:** Simula una base de datos para almacenar y gestionar los objetos `Repuesto`. Contiene la lógica para añadir, obtener, actualizar y eliminar repuestos.
*   **`InventoryManager.php`:** Actúa como una capa de servicio que interactúa con la base de datos y las clases de repuestos. Contiene la lógica de negocio principal para la gestión del inventario, como añadir un repuesto, listar todos los repuestos, etc. También utiliza el `RepuestoFactory` para la creación de objetos.
*   **`RepuestoFactory.php`:** Es una fábrica que se encarga de crear instancias de los diferentes tipos de repuestos (Moto, Camion, Camioneta) basándose en el tipo proporcionado. Esto centraliza la lógica de creación de objetos y permite añadir nuevos tipos de repuestos de forma más organizada.

### 2. Vista (View)
La Vista es responsable de la presentación de los datos al usuario. No contiene lógica de negocio, solo se encarga de mostrar lo que el Modelo le proporciona.

En TP-Inventario, la Vista es:
*   **`ConsoleView.php`:** Esta clase se encarga de toda la interacción con el usuario a través de la consola. Muestra mensajes, errores, listas de repuestos y solicita entradas al usuario. Su única responsabilidad es la interfaz de usuario en la consola.
```php
// Ejemplo de cómo la Vista muestra un mensaje
$this->view->displayMessage("Repuesto añadido con éxito.");

// Ejemplo de cómo la Vista solicita una entrada
$nombre = $this->view->displayInputPrompt("Nombre: ");
```

### 3. Controlador (Controller)
El Controlador actúa como un intermediario entre el Modelo y la Vista. Recibe las entradas del usuario (a través de la Vista), las procesa, interactúa con el Modelo para realizar las operaciones necesarias y luego actualiza la Vista con los resultados.

En TP-Inventario, el Controlador es:
*   **`InventoryController.php`:** Este es el cerebro de la aplicación.
    *   Recibe las acciones del usuario (por ejemplo, "Añadir Repuesto") a través del menú.
    *   Llama a los métodos apropiados del `InventoryManager` (Modelo) para realizar la lógica de negocio (ej. `addSparePart`).
    *   Utiliza la `ConsoleView` (Vista) para mostrar información al usuario (mensajes de éxito, errores) y para solicitar más datos.
    *   Gestiona el flujo de la aplicación, decidiendo qué hacer en función de la entrada del usuario.
```php
// Ejemplo de cómo el Controlador interactúa con la Vista y el Modelo
private function addSparePart(): void
{
    $this->view->displayMessage("--- Añadir Nuevo Repuesto ---");
    $tipo = $this->view->displayInputPrompt("Tipo de repuesto (Moto, Camion, Camioneta): ");
    // ... más entradas ...

    try {
        $this->inventoryManager->addSparePart($tipo, $nombre, $descripcion, $precio, $cantidad, $marca, $modelo, $additionalData);
        $this->view->displayMessage("Repuesto añadido con éxito.");
    } catch (\Exception $e) {
        $this->view->displayError($e->getMessage());
    }
}
```

## Interacción entre Componentes
La interacción sigue un flujo claro:
1.  El usuario interactúa con la **Vista** (por ejemplo, selecciona una opción del menú).
2.  La **Vista** notifica al **Controlador** sobre la acción del usuario.
3.  El **Controlador** procesa la entrada, puede solicitar más información a la **Vista**, y luego invoca la lógica de negocio apropiada en el **Modelo**.
4.  El **Modelo** realiza la operación (ej. guarda un repuesto en la base de datos) y notifica al **Controlador** sobre el resultado.
5.  El **Controlador** recibe el resultado del **Modelo** y decide cómo actualizar la **Vista** (ej. mostrar un mensaje de éxito o un error).
6.  La **Vista** se actualiza para reflejar el nuevo estado de la aplicación.

**Nota:** En esta implementación de consola, la "notificación" del Modelo al Controlador y del Controlador a la Vista a menudo se realiza mediante llamadas directas a métodos, ya que no hay un sistema de eventos complejo como en aplicaciones GUI o web.

## Beneficios del MVC en TP-Inventario
*   **Separación de Responsabilidades:** Cada componente tiene una única responsabilidad clara, lo que facilita entender, mantener y depurar el código.
*   **Reusabilidad:** Los componentes del Modelo (lógica de negocio y datos) pueden ser reutilizados en diferentes interfaces de usuario (por ejemplo, una interfaz web o una API).
*   **Flexibilidad:** Permite cambiar la interfaz de usuario (Vista) sin afectar la lógica de negocio (Modelo) y viceversa.
*   **Organización:** El código está mejor estructurado y es más fácil de navegar para nuevos desarrolladores.
