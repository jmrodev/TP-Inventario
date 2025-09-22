# Visión General del Proyecto TP-Inventario (Estado Actual)

Este documento proporciona una visión general de la arquitectura y los componentes clave del proyecto "TP-Inventario" en su estado actual, destacando el propósito, los métodos principales y las particularidades de cada elemento.

## Componentes Clave del Proyecto

### 1. Clase `Repuesto` (y sus subclases)
*   **Propósito:** Sirve como la clase base abstracta para todos los tipos de repuestos en el inventario. Encapsula las propiedades comunes a cualquier repuesto (ID, nombre, descripción, precio, cantidad, categoría, marca, modelo).
*   **Subclases:**
    *   `RepuestoMoto`: Hereda de `Repuesto`, con categoría fija "Moto".
    *   `RepuestoCamion`: Hereda de `Repuesto`, con categoría fija "Camion".
    *   `RepuestoCamioneta`: Hereda de `Repuesto`, con categoría fija "Camioneta" y añade una propiedad específica: `traccion`.
*   **Particularidades:**
    *   Utiliza herencia para modelar diferentes tipos de repuestos, promoviendo la reutilización de código y la especialización.
    *   Cada subclase define su categoría de forma implícita en su constructor.
    *   Incluye métodos "getter" y "setter" para todas sus propiedades, siguiendo el principio de encapsulamiento.

### 2. Clase `RepuestoFactory`
*   **Propósito:** Implementa el patrón Factory Method para la creación de objetos `Repuesto`. Su función es centralizar la lógica de instanciación de los diferentes tipos de repuestos.
*   **Métodos Principales:**
    *   `public static function crearRepuesto(string $tipo, array $datos): ?Repuesto`: Recibe el tipo de repuesto deseado (ej. "Moto", "Camioneta") y un array de datos, y devuelve una instancia del repuesto correspondiente.
*   **Particularidades:**
    *   Desacopla el código cliente de la lógica de creación de objetos, haciendo que sea más fácil añadir nuevos tipos de repuestos en el futuro sin modificar el código que los utiliza.
    *   Maneja la asignación de propiedades comunes y específicas (como la tracción para camionetas) durante la creación.

### 3. Clase `InMemoryDatabase`
*   **Propósito:** Simula una base de datos en memoria para el almacenamiento persistente (durante la ejecución de la aplicación) de los objetos `Repuesto`.
*   **Métodos Principales:**
    *   `public static function getInstance(): InMemoryDatabase`: Implementa el patrón Singleton para asegurar que solo exista una instancia de la base de datos en toda la aplicación.
    *   `public function addRepuesto($repuesto)`: Añade un repuesto al almacenamiento.
    *   `public function getRepuestoById($id)`: Recupera un repuesto por su ID.
    *   `public function getAllRepuestos()`: Devuelve todos los repuestos almacenados.
    *   `public function removeRepuesto($id): bool`: Elimina un repuesto por su ID.
*   **Particularidades:**
    *   Utiliza un array estático (`self::$repuestos`) para almacenar los objetos, simulando una tabla de base de datos.
    *   Asigna automáticamente un ID único a cada repuesto añadido.
    *   Implementa el patrón Singleton para proporcionar un punto de acceso global y controlado a la base de datos.

### 4. Clase `InventoryManager`
*   **Propósito:** Actúa como el "cerebro" de la aplicación, encapsulando toda la lógica de negocio del inventario. Es el punto de conexión entre la interfaz de usuario (menú) y los componentes de datos (base de datos, fábrica de repuestos).
*   **Métodos Principales:**
    *   `public function __construct(InMemoryDatabase $db, RepuestoFactory $repuestoFactory)`: Recibe las dependencias necesarias (base de datos y fábrica) a través de inyección de dependencias.
    *   `public function addSparePart()`: Guía al usuario para introducir los datos de un nuevo repuesto y lo añade a la base de datos.
    *   `public function listSpareParts()`: Muestra un listado formateado de todos los repuestos.
    *   `public function editSparePart()`: Permite al usuario buscar y modificar los detalles de un repuesto existente.
    *   `public function deleteSparePart()`: Permite al usuario eliminar un repuesto por su ID.
    *   `public function exitApplication()`: Maneja la acción de salida de la aplicación.
*   **Particularidades:**
    *   Centraliza la lógica de interacción con el usuario y la manipulación de datos, manteniendo `Main.php` limpio.
    *   Promueve la separación de responsabilidades (SRP): `InventoryManager` se encarga de la lógica de negocio, `Menu` de la interfaz, `InMemoryDatabase` del almacenamiento.

### 5. Clase `Menu`
*   **Propósito:** Proporciona una interfaz de usuario interactiva basada en texto para aplicaciones de línea de comandos (CLI).
*   **Métodos Principales:**
    *   `public function __construct($titulo, array $opciones)`: Inicializa el menú con un título y un array de opciones.
    *   `public function mostrar()`: Imprime el menú en la consola.
    *   `public function obtenerSeleccion()`: Captura la entrada del usuario.
    *   `public function ejecutarOpcion($seleccion)`: Valida la selección del usuario y ejecuta la acción asociada (un "callable").
    *   `public function iniciar()`: Ejecuta el ciclo principal del menú (mostrar, obtener selección, ejecutar) hasta que el usuario decide salir.
    *   `public static function createMainMenu(InventoryManager $manager): self`: **Método estático de fábrica** que crea y configura el menú principal específico para la aplicación de inventario, utilizando los métodos de `InventoryManager` como acciones.
*   **Particularidades:**
    *   Diseño genérico y reutilizable para cualquier menú CLI.
    *   Utiliza "callables" (funciones anónimas o arrays `[$objeto, 'metodo']`) para asociar acciones a las opciones del menú, lo que proporciona gran flexibilidad.
    *   El método de fábrica `createMainMenu` centraliza la configuración del menú principal, desacoplando su definición de `Main.php`.

### 6. Archivo `Main.php`
*   **Propósito:** Es el punto de entrada principal de la aplicación. Su rol es orquestar la inicialización de los componentes y el inicio del flujo de la aplicación.
*   **Particularidades:**
    *   Incluye todos los archivos de clases necesarios.
    *   Inicializa las dependencias clave: `InMemoryDatabase` (usando su Singleton) y `RepuestoFactory`.n    *   Crea una instancia de `InventoryManager`, inyectándole las dependencias.
    *   Utiliza el método estático de fábrica `Menu::createMainMenu()` para construir el menú principal, pasándole la instancia de `InventoryManager`.
    *   Inicia el ciclo de interacción del menú llamando a `$menuPrincipal->iniciar()`.
    *   Su lógica es mínima y se enfoca en la configuración y el arranque, delegando las responsabilidades a las clases correspondientes.

## Principios de POO y Patrones de Diseño Aplicados
*   **Encapsulamiento:** Todas las clases utilizan propiedades privadas y métodos públicos (getters/setters) para controlar el acceso a sus datos internos.
*   **Herencia:** Demostrada por la jerarquía de clases `Repuesto` y sus subclases, permitiendo la reutilización de código y la especialización.
*   **Polimorfismo:** El sistema puede manejar diferentes tipos de objetos `Repuesto` de manera uniforme a través de la clase base `Repuesto`, por ejemplo, al listarlos o almacenarlos.
*   **Abstracción:** Clases como `Menu` y `InventoryManager` abstraen la complejidad de la interacción con el usuario y la lógica de negocio, respectivamente, proporcionando interfaces sencillas.
*   **Patrón Singleton:** Implementado en `InMemoryDatabase` para asegurar una única instancia global de la base de datos.
*   **Patrón Factory Method:** Implementado en `RepuestoFactory` para la creación desacoplada de objetos `Repuesto`.n*   **Inyección de Dependencias:** Utilizado en el constructor de `InventoryManager` y en el método de fábrica `Menu::createMainMenu` para pasar las dependencias necesarias, mejorando la flexibilidad y testabilidad.
*   **Separación de Responsabilidades (SRP):** Cada clase tiene una única razón para cambiar, lo que hace el código más fácil de entender y mantener.