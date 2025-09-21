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

## Documentación Detallada

Para una comprensión más profunda del diseño, la arquitectura y el funcionamiento interno del proyecto, consulta la documentación HTML completa:

*   **Visión General del Proyecto:** [docs/aboutProject/project_overview.html](docs/aboutProject/project_overview.html)
*   **Explicación del Patrón MVC:** [docs/aboutProject/mvc_explanation.html](docs/aboutProject/mvc_explanation.html)
*   **Detalles de los Objetos Repuesto:** [docs/aboutProject/Repuesto_Objects_Explanation.html](docs/aboutProject/Repuesto_Objects_Explanation.html)
*   **Comparación de Menús:** [docs/aboutProject/comparacion_menus.html](docs/aboutProject/comparacion_menus.html)
*   **Explicación del Menú:** [docs/aboutProject/Menu_Explicacion.html](docs/aboutProject/Menu_Explicacion.html)
*   **Gestión de Menús:** [docs/aboutProject/Menu_Management_Explanation.html](docs/aboutProject/Menu_Management_Explanation.html)
*   **Detalles de Refactorización MVC:** [docs/aboutProject/mvc_refactoring_details.html](docs/aboutProject/mvc_refactoring_details.html)
*   **Refactorización del Menú de Inventario:** [docs/aboutProject/refactorizacion_menu_inventario.html](docs/aboutProject/refactorizacion_menu_inventario.html)
*   **Patrón Singleton Manual:** [docs/aboutProject/Singleton_Pattern_Manual.html](docs/aboutProject/Singleton_Pattern_Manual.html)
*   **Reestructuración de Carpetas:** [docs/aboutProject/folder_restructuring.html](docs/aboutProject/folder_restructuring.html)
*   **DFD Overview:** [docs/aboutProject/dfd_overview.html](docs/aboutProject/dfd_overview.html)
*   **Explicación de BASE_PATH:** [docs/aboutProject/base_path_explanation.html](docs/aboutProject/base_path_explanation.html)

## Créditos

Desarrollado por [www.github.com/jmrodev]

---
