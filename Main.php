<?php

require_once 'bd.php';
require_once 'Repuesto.php';
require_once 'RepuestoMoto.php';
require_once 'RepuestoCamion.php';
require_once 'RepuestoCamioneta.php';
require_once 'Menu.php';
require_once 'RepuestoFactory.php';


$db = InMemoryDatabase::getInstance();

$opcionesMenuPrincipal = [
    1 => ['descripcion' => 'Añadir Repuesto', 'accion' => function() use ($db) {
        echo "--- Añadir Nuevo Repuesto ---\n";
        echo "Seleccione el tipo de repuesto:\n";
        echo "1. Moto\n";
        echo "2. Camion\n";
        echo "3. Camioneta\n";
        echo "Ingrese su opción: ";
        $tipoOpcion = trim(fgets(STDIN));

        $tipoRepuesto = '';
        switch ($tipoOpcion) {
            case '1': $tipoRepuesto = 'Moto'; break;
            case '2': $tipoRepuesto = 'Camion'; break;
            case '3': $tipoRepuesto = 'Camioneta'; break;
            default:
                echo "Opción de tipo de repuesto inválida.\n";
                return;
        }

        echo "Nombre: ";
        $nombre = trim(fgets(STDIN));
        echo "Descripción: ";
        $descripcion = trim(fgets(STDIN));
        echo "Precio: ";
        $precio = (float)trim(fgets(STDIN));
        echo "Cantidad: ";
        $cantidad = (int)trim(fgets(STDIN));
        echo "Marca: ";
        $marca = trim(fgets(STDIN));
        echo "Modelo: ";
        $modelo = trim(fgets(STDIN));

        $datosRepuesto = [
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'cantidad' => $cantidad,
            'marca' => $marca,
            'modelo' => $modelo,
        ];

        if ($tipoRepuesto === 'Camioneta') {
            echo "Tracción (ej: 4x2, 4x4): ";
            $datosRepuesto['traccion'] = trim(fgets(STDIN));
        }

        $repuesto = RepuestoFactory::crearRepuesto($tipoRepuesto, $datosRepuesto);

        if ($repuesto) {
            $db->addRepuesto($repuesto);
            echo "Repuesto de " . $tipoRepuesto . " añadido con éxito (ID: " . $repuesto->getId() . ").\n";
        } else {
            echo "No se pudo crear el repuesto.\n";
        }
    }],
    2 => ['descripcion' => 'Listar Repuestos (funcionalidad no disponible)', 'accion' => function() { echo "Funcionalidad de listar repuestos no implementada.\n"; }],
    3 => ['descripcion' => 'Editar Repuesto (funcionalidad no disponible)', 'accion' => function() { echo "Funcionalidad de editar repuesto no implementada.\n"; }],
    4 => ['descripcion' => 'Eliminar Repuesto (funcionalidad no disponible)', 'accion' => function() { echo "Funcionalidad de eliminar repuesto no implementada.\n"; }],
    5 => ['descripcion' => 'Salir', 'accion' => function() { echo "Saliendo de la aplicación...\n"; }]
];

$menuPrincipal = new Menu("Menú Principal de Inventario", $opcionesMenuPrincipal);

$menuPrincipal->iniciar();

echo "¡Aplicación finalizada!\n";

?>
