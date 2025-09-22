# DFD: Visión General del Flujo de Datos del Proyecto TP-Inventario

Este Diagrama de Flujo de Datos (DFD) de Nivel 0 representa la interacción principal y el flujo de información dentro de la aplicación de gestión de inventario de repuestos.

```mermaid
---
title: DFD del Proyecto TP-Inventario
---
flowchart TD
    externalUser[Usuario]
    processP1(Interacción del Menú Principal)
    processP2(Añadir Repuesto)
    processP3(Listar Repuestos)
    processP4(Editar Repuesto)
    processP5(Eliminar Repuesto)
    dataStoreDS1[(Base de Datos de Inventario)]
    dataStoreDS2[(Fábrica de Repuestos)]

    externalUser --> |Selección de Opción| processP1
    processP1 --> |Mostrar Menú, Resultado de Acción| externalUser

    processP1 --> |Solicitud de Añadir| processP2
    processP2 --> |Solicitar Detalles del Repuesto, Confirmación| externalUser
    externalUser --> |Entrada de Detalles del Repuesto| processP2
    processP2 --> |Solicitud de Creación| dataStoreDS2
    dataStoreDS2 --> |Objeto Repuesto Creado| processP2
    processP2 --> |Añadir Repuesto Objeto| dataStoreDS1
    dataStoreDS1 --> |Nuevo ID de Repuesto| processP2

    processP1 --> |Solicitud de Listar| processP3
    processP3 --> |Obtener Todos los Repuestos| dataStoreDS1
    dataStoreDS1 --> |Datos de Todos los Repuestos| processP3
    processP3 --> |Mostrar Lista de Repuestos| externalUser

    processP1 --> |Solicitud de Editar| processP4
    processP4 --> |Solicitar ID, Solicitar Nuevos Detalles| externalUser
    externalUser --> |ID del Repuesto, Nuevos Detalles| processP4
    processP4 --> |Obtener Repuesto por ID| dataStoreDS1
    dataStoreDS1 --> |Datos del Repuesto Existente| processP4
    processP4 --> |Actualizar Repuesto Objeto| dataStoreDS1
    processP4 --> |Confirmación de Edición| externalUser

    processP1 --> |Solicitud de Eliminar| processP5
    processP5 --> |Solicitar ID| externalUser
    externalUser --> |ID del Repuesto| processP5
    processP5 --> |Eliminar Repuesto ID| dataStoreDS1
    dataStoreDS1 --> |Estado de Eliminación| processP5
    processP5 --> |Confirmación de Eliminación| externalUser
```

## Leyenda
*   **A:** Entidad Externa (Usuario)
*   **P1, P2, P3, P4, P5:** Procesos
*   **DS1, DS2:** Almacenes de Datos