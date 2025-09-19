**Avances del Proyecto - TP-Inventario (POO PHP)**

**Estado Actual:**

*   **`Repuesto.php`**: Clase abstracta base con propiedades `id`, `nombre`, `descripcion`, `precio`, `cantidad`, `categoria`, `marca`, `modelo`. Incluye getters y setters para todas las propiedades, y un `setId()` para la base de datos en memoria.
*   **`RepuestoCamion.php`**: Hereda de `Repuesto`. Constructor actualizado para pasar `id`, `nombre`, `descripcion`, `precio`, `cantidad`, `marca`, `modelo` al constructor padre, con categoría fija "Camion".
*   **`RepuestoCamioneta.php`**: Hereda de `Repuesto`. Propiedad `traccion` específica. Constructor actualizado para pasar `id`, `nombre`, `descripcion`, `precio`, `cantidad`, `traccion`, `marca`, `modelo` al constructor padre, con categoría fija "Camioneta". Incluye getter y setter para `traccion`.
*   **`RepuestoMoto.php`**: Hereda de `Repuesto`. Constructor actualizado para pasar `id`, `nombre`, `descripcion`, `precio`, `cantidad`, `marca`, `modelo` al constructor padre, con categoría fija "Moto".
*   **`bd.php`**: Contiene la clase `InMemoryDatabase` que simula una base de datos en memoria. Almacena objetos `Repuesto` en un array estático. Proporciona métodos `connect()`, `addRepuesto()`, `getRepuestoById()`, `getAllRepuestos()` y `clear()`.
*   **`Main.php` (anteriormente `Mostrar.php`)**:
    *   Incluye `Repuesto.php`, `RepuestoMoto.php` y `bd.php`.
    *   Instancia `InMemoryDatabase`.
    *   Crea un objeto `RepuestoMoto` (con `null` para el ID inicial) y lo añade a la `InMemoryDatabase`.
    *   La función `mostrarRepuesto()` muestra las propiedades del repuesto (`ID`, `Nombre`, `Descripcion`, `Precio`, `Cantidad`, `Categoria`, `Marca`, `Modelo`) línea por línea.
    *   Itera sobre todos los repuestos en la `InMemoryDatabase` y los muestra usando `mostrarRepuesto()`.
*   **`Menu.php`**: Nueva clase `Menu` implementada para gestionar la interacción del usuario en la CLI. Incluye métodos para `__construct`, `mostrar`, `obtenerSeleccion`, `ejecutarOpcion` e `iniciar` el menú.

**Próximos Pasos (según la conversación):**

*   El usuario puede querer añadir más tipos de repuestos (Camion, Camioneta) a la `InMemoryDatabase` en `Main.php`.
*   El usuario puede querer implementar más operaciones CRUD en `InMemoryDatabase`.
*   El usuario puede querer refinar la salida o añadir más funcionalidades.
*   El usuario prefiere explicaciones y código que eviten conceptos avanzados, ya que está en una etapa de aprendizaje inicial de POO en PHP.
*   El usuario desea discutir y consultar el código, y Gemini no debe escribir código a menos que se le solicite expresamente.
*   Se ha creado un archivo `docs/Menu_Explicacion.html` con la explicación detallada de la clase `Menu`.
*   Se ha creado un archivo `docs/Repuesto_Objects_Explanation.html` con la explicación detallada de la jerarquía de clases `Repuesto` y el avance del proyecto.