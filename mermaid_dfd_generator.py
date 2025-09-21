def generate_mermaid_dfd(dfd_data, filename="dfd_output.mmd"):
    """
    Generates a Mermaid DFD (using flowchart syntax) from a dictionary of DFD data.

    Args:
        dfd_data (dict): A dictionary containing DFD elements.
                         Expected keys: 'external_entities', 'processes', 'data_stores', 'flows'.
                         - 'external_entities': list of (id, name) tuples
                         - 'processes': list of (id, name) tuples
                         - 'data_stores': list of (id, name) tuples
                         - 'flows': list of (source_type, source_id, label, dest_type, dest_id) tuples
                                    source_type/dest_type can be 'external', 'process', 'data_store'.
        filename (str): The name of the .mmd file to create.
    """
    mermaid_code = []
    mermaid_code.append("---")
    mermaid_code.append(f"title: {dfd_data.get('title', 'Generated DFD')}")
    mermaid_code.append("---")
    mermaid_code.append("flowchart TD")

    # Define nodes
    for entity_id, name in dfd_data.get('external_entities', []):
        mermaid_code.append(f"    external{entity_id}[{name}]")
    for process_id, name in dfd_data.get('processes', []):
        mermaid_code.append(f"    process{process_id}({name})")
    for ds_id, name in dfd_data.get('data_stores', []):
        mermaid_code.append(f"    dataStore{ds_id}[({name})]") # Cylindrical shape for data stores

    # Define flows
    for source_type, source_id, label, dest_type, dest_id in dfd_data.get('flows', []):
        source_prefix = ""
        if source_type == 'external':
            source_prefix = "external"
        elif source_type == 'process':
            source_prefix = "process"
        elif source_type == 'data_store':
            source_prefix = "dataStore"
        
        dest_prefix = ""
        if dest_type == 'external':
            dest_prefix = "external"
        elif dest_type == 'process':
            dest_prefix = "process"
        elif dest_type == 'data_store':
            dest_prefix = "dataStore"
        
        mermaid_code.append(f"    {source_prefix}{source_id} --> |{label}| {dest_prefix}{dest_id}")

    with open(filename, "w") as f:
        f.write("\n".join(mermaid_code))

# Example Usage (using the DFD from dfd_overview.mmd)
if __name__ == "__main__":
    dfd_example_data = {
        "title": "DFD del Proyecto TP-Inventario",
        "external_entities": [
            ("User", "Usuario")
        ],
        "processes": [
            ("P1", "Interacción del Menú Principal"),
            ("P2", "Añadir Repuesto"),
            ("P3", "Listar Repuestos"),
            ("P4", "Editar Repuesto"),
            ("P5", "Eliminar Repuesto")
        ],
        "data_stores": [
            ("DS1", "Base de Datos de Inventario"),
            ("DS2", "Fábrica de Repuestos")
        ],
        "flows": [
            ("external", "User", "Selección de Opción", "process", "P1"),
            ("process", "P1", "Mostrar Menú, Resultado de Acción", "external", "User"),

            ("process", "P1", "Solicitud de Añadir", "process", "P2"),
            ("process", "P2", "Solicitar Detalles del Repuesto, Confirmación", "external", "User"),
            ("external", "User", "Entrada de Detalles del Repuesto", "process", "P2"),
            ("process", "P2", "Solicitud de Creación", "data_store", "DS2"),
            ("data_store", "DS2", "Objeto Repuesto Creado", "process", "P2"),
            ("process", "P2", "Añadir Repuesto Objeto", "data_store", "DS1"),
            ("data_store", "DS1", "Nuevo ID de Repuesto", "process", "P2"),

            ("process", "P1", "Solicitud de Listar", "process", "P3"),
            ("process", "P3", "Obtener Todos los Repuestos", "data_store", "DS1"),
            ("data_store", "DS1", "Datos de Todos los Repuestos", "process", "P3"),
            ("process", "P3", "Mostrar Lista de Repuestos", "external", "User"),

            ("process", "P1", "Solicitud de Editar", "process", "P4"),
            ("process", "P4", "Solicitar ID, Solicitar Nuevos Detalles", "external", "User"),
            ("external", "User", "ID del Repuesto, Nuevos Detalles", "process", "P4"),
            ("process", "P4", "Obtener Repuesto por ID", "data_store", "DS1"),
            ("data_store", "DS1", "Datos del Repuesto Existente", "process", "P4"),
            ("process", "P4", "Actualizar Repuesto Objeto", "data_store", "DS1"),
            ("process", "P4", "Confirmación de Edición", "external", "User"),

            ("process", "P1", "Solicitud de Eliminar", "process", "P5"),
            ("process", "P5", "Solicitar ID", "external", "User"),
            ("external", "User", "ID del Repuesto", "process", "P5"),
            ("process", "P5", "Eliminar Repuesto ID", "data_store", "DS1"),
            ("data_store", "DS1", "Estado de Eliminación", "process", "P5"),
            ("process", "P5", "Confirmación de Eliminación", "external", "User")
        ]
    }
    generate_mermaid_dfd(dfd_example_data, "docs/dfd_generated_from_python.mmd")
    print("Generated docs/dfd_generated_from_python.mmd")
