<?php

// Incluir las clases necesarias
include_once 'bd.php';
include_once 'Repuesto.php';
include_once 'RepuestoMoto.php'; // Opcional, si queremos añadir un repuesto de ejemplo al inicio
include_once 'Menu.php';

// Instanciar la base de datos en memoria
$db = new InMemoryDatabase();

// Opcional: Añadir algunos repuestos de ejemplo al inicio
$repuestoMoto = new RepuestoMoto(null, "Filtro de aire", "Filtro de aire para moto", 25.99, 10, "Yamaha", "YZF-R3");
$db->addRepuesto($repuestoMoto);

// Definir las opciones del menú principal
$opcionesMenuPrincipal = [
    1 => 'Añadir Repuesto',
    2 => 'Listar Repuestos',
    3 => 'Salir'
];

// Crear una instancia del menú
$menuPrincipal = new Menu("Menú Principal de Inventario", $opcionesMenuPrincipal);

// Iniciar el menú
$menuPrincipal->iniciar();

echo "¡Aplicación finalizada!\n";

?>