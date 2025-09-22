# TP-Inventario: Sistema de Gestión de Inventario para Taller de Repuestos

## Descripción del Proyecto

Este proyecto es una aplicación de línea de comandos (CLI) desarrollada en PHP con un enfoque en Programación Orientada a Objetos (POO) para gestionar el inventario de repuestos en un taller. Permite registrar, consultar y administrar diferentes tipos de repuestos (camiones, camionetas, motos) de manera eficiente.

## Características Principales

*   **Gestión de Repuestos:** Añade, visualiza y administra repuestos específicos para camiones, camionetas y motos.
*   **Clases POO:** Implementación de herencia y polimorfismo para manejar la diversidad de repuestos.
*   **Base de Datos en Memoria:** Utiliza una simulación de base de datos para el almacenamiento temporal de los datos.
*   **Interfaz de Usuario CLI:** Interacción sencilla a través de la consola.

## Cómo Empezar

### Requisitos

*   PHP 7.4 o superior.

### Instalación

1.  Clona el repositorio:
    ```bash
    git clone https://github.com/tu-usuario/TP-Inventario.git
    cd TP-Inventario
    ```

### Ejecución

Para iniciar la aplicación, ejecuta el siguiente comando desde la raíz del proyecto:

```bash
php src/Core/Main.php
```

## Estructura del Proyecto

El proyecto sigue una estructura modular para facilitar la organización y el mantenimiento del código:

*   `src/Controllers/`: Contiene la lógica de control de la aplicación.
*   `src/Core/`: Clases principales para la ejecución y renderizado del menú.
*   `src/Database/`: Simulación de la base de datos en memoria.
*   `src/Models/`: Definición de las clases de los repuestos y su jerarquía.
*   `src/Views/`: Clases para la presentación de la información en la consola.
*   `docs/`: Documentación detallada del proyecto en formato HTML.

## Documentación

Para una comprensión más profunda del diseño, la arquitectura y el funcionamiento interno del proyecto, consulta los siguientes documentos:

*   [Explicación de la Ruta Base (`base_path_explanation.md`)](docs/markdown/base_path_explanation.md)
*   [Comparación de Menús (`comparacion_menus.md`)](docs/markdown/comparacion_menus.md)
*   [Vista General del DFD (`dfd_overview.md`)](docs/markdown/dfd_overview.md)
*   [Reestructuración de Carpetas (`folder_restructuring.md`)](docs/markdown/folder_restructuring.md)
*   [Explicación del Menú (`Menu_Explicacion.md`)](docs/markdown/Menu_Explicacion.md)
*   [Explicación de la Gestión de Menús (`Menu_Management_Explanation.md`)](docs/markdown/Menu_Management_Explanation.md)
*   [Explicación de MVC (`mvc_explanation.md`)](docs/markdown/mvc_explanation.md)
*   [Detalles de la Refactorización a MVC (`mvc_refactoring_details.md`)](docs/markdown/mvc_refactoring_details.md)
*   [Vista General del Proyecto (`project_overview.md`)](docs/markdown/project_overview.md)
*   [Refactorización del Menú de Inventario (`refactorizacion_menu_inventario.md`)](docs/markdown/refactorizacion_menu_inventario.md)
*   [Explicación de los Objetos Repuesto (`Repuesto_Objects_Explanation.md`)](docs/markdown/Repuesto_Objects_Explanation.md)
*   [Manual del Patrón Singleton (`Singleton_Pattern_Manual.md`)](docs/markdown/Singleton_Pattern_Manual.md)


## Créditos

Desarrollado por [www.github.com/jmrodev]

---
