# Documentación de Reestructuración de Carpetas del Proyecto TP-Inventario

Este documento detalla los cambios realizados en la estructura de directorios del proyecto TP-Inventario, con el objetivo de mejorar la organización, la modularidad y la adherencia a los principios de la Programación Orientada a Objetos (POO).

## Estructura Anterior (Asumida)
Antes de la reestructuración, se asume que los archivos del proyecto estaban distribuidos de una manera menos organizada, posiblemente con muchos archivos PHP en el directorio raíz o en subdirectorios menos específicos. Esto dificultaba la escalabilidad y el mantenimiento del código.
```
/TP-Inventario/
├───bd.php
├───Repuesto.php
├───RepuestoCamion.php
├───RepuestoCamioneta.php
├───RepuestoMoto.php
├───Mostrar.php
└───... (otros archivos)
```

## Nueva Estructura de Carpetas
La nueva estructura se ha diseñado siguiendo un enfoque más modular y basado en responsabilidades, facilitando la identificación de los componentes del sistema y su mantenimiento.
```
/TP-Inventario/
├───.gemini/
├───.git/
├───docs/
│   ├───... (archivos de documentación)
│   └───folder_restructuring.html (este archivo)
└───src/
    ├───Core/
    │   ├───ConsoleMenuRenderer.php
    │   ├───InventoryManager.php
    │   ├───Main.php
    │   ├───Menu.php
    │   └───MenuRendererInterface.php
    ├───Database/
    │   └───bd.php
    ├───Factories/
    │   └───RepuestoFactory.php
    └───Models/
        ├───Repuesto.php
        ├───RepuestoCamion.php
        ├───RepuestoCamioneta.php
        └───RepuestoMoto.php
```

## Justificación de los Cambios
La reestructuración se llevó a cabo por las siguientes razones principales:
*   **Separación de Responsabilidades (SRP):** Cada directorio ahora agrupa archivos con responsabilidades similares, lo que mejora la claridad y reduce el acoplamiento.
*   **Modularidad:** El código está organizado en módulos lógicos (Core, Database, Factories, Models), lo que facilita la comprensión, el desarrollo y la prueba de componentes individuales.
*   **Escalabilidad:** La nueva estructura permite añadir nuevas funcionalidades o tipos de repuestos de manera más sencilla y sin afectar otras partes del sistema.
*   **Mantenimiento:** Al tener una estructura clara, es más fácil localizar y modificar archivos específicos, reduciendo el riesgo de introducir errores.
*   **Adherencia a Estándares:** Se busca adoptar una estructura más cercana a las convenciones comunes en proyectos PHP modernos, lo que facilita la colaboración y la incorporación de nuevas herramientas.

### Detalle de los Nuevos Directorios:
*   `src/`: Contiene todo el código fuente de la aplicación.
*   `src/Core/`: Aloja las clases fundamentales del sistema, como la lógica del menú, el gestor de inventario y las interfaces.
*   `src/Database/`: Contiene la lógica relacionada con la persistencia de datos, como la clase `InMemoryDatabase` (anteriormente `bd.php`).
*   `src/Factories/`: Contendrá las clases encargadas de la creación de objetos, siguiendo el patrón Factory para la creación de repuestos.
*   `src/Models/`: Contiene las definiciones de las clases de los modelos de datos, como `Repuesto` y sus subclases (`RepuestoCamion`, `RepuestoCamioneta`, `RepuestoMoto`).
*   `docs/`: Contiene toda la documentación del proyecto, incluyendo este archivo.

Esta nueva organización sienta las bases para un desarrollo más robusto y mantenible del proyecto TP-Inventario.
