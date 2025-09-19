**Avances del Proyecto - TP-Inventario (POO PHP)**

**Estado Actual:**

*   **`Repuesto.php`**: Clase abstracta base con propiedades `id`, `nombre`, `descripcion`, `precio`, `cantidad`, `categoria`, `marca`, `modelo`. Incluye getters y setters para todas las propiedades, y un `setId()` para la base de datos en memoria.
*   **`RepuestoCamion.php`**: Hereda de `Repuesto`. Constructor actualizado para pasar `id`, `nombre`, `descripcion`, `precio`, `cantidad`, `marca`, `modelo` al constructor padre, con categoría fija "Camion".
*   **`RepuestoCamioneta.php`**: Hereda de `Repuesto`. Propiedad `traccion` específica. Constructor actualizado para pasar `id`, `nombre`, `descripcion`, `precio`, `cantidad`, `traccion`, `marca`, `modelo` al constructor padre, con categoría fija "Camioneta". Incluye getter y setter para `traccion`.
*   **`RepuestoMoto.php`**: Hereda de `Repuesto`. Constructor actualizado para pasar `id`, `nombre`, `descripcion`, `precio`, `cantidad`, `marca`, `modelo` al constructor padre, con categoría fija "Moto".
*   **`bd.php`**: Contiene la clase `InMemoryDatabase` que simula una base de datos en memoria. Almacena objetos `Repuesto` en un array estático. Proporciona métodos `connect()`, `addRepuesto()`, `getRepuestoById()`, `getAllRepuestos()` y `clear()`.
*   **`Mostrar.php`**:
    *   Incluye `Repuesto.php`, `RepuestoMoto.php` y `bd.php`.
    *   Instancia `InMemoryDatabase`.
    *   Crea un objeto `RepuestoMoto` (con `null` para el ID inicial) y lo añade a la `InMemoryDatabase`.
    *   La función `mostrarRepuesto()` muestra las propiedades del repuesto (`ID`, `Nombre`, `Descripcion`, `Precio`, `Cantidad`, `Categoria`, `Marca`, `Modelo`) línea por línea.
    *   Itera sobre todos los repuestos en la `InMemoryDatabase` y los muestra usando `mostrarRepuesto()`.

**Próximos Pasos (según la conversación):**

*   El usuario puede querer añadir más tipos de repuestos (Camion, Camioneta) a la `InMemoryDatabase` en `Mostrar.php`.
*   El usuario puede querer implementar más operaciones CRUD en `InMemoryDatabase`.
*   El usuario puede querer refinar la salida o añadir más funcionalidades.