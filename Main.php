<?php

include_once 'bd.php';
include_once 'Repuesto.php';
include_once 'Menu.php';

$db = new InMemoryDatabase();
$opcionesMenuPrincipal = [
    1 => 'Añadir Repuesto',
    2 => 'Listar Repuestos',
    3 => 'Buscar Repuesto por Nombre',
    4 => 'Salir'
];
$menuPrincipal = new Menu("Menú Principal de Inventario", $opcionesMenuPrincipal);
$menuPrincipal->iniciar();
echo "¡Aplicación finalizada!\n";

?>
