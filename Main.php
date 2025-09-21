<?php

require_once 'bd.php';
require_once 'Repuesto.php';
require_once 'RepuestoMoto.php';
require_once 'RepuestoCamion.php';
require_once 'RepuestoCamioneta.php';
require_once 'RepuestoFactory.php';
require_once 'Menu.php';
require_once 'InventoryManager.php';

// Inicialización de dependencias
$db = InMemoryDatabase::getInstance();
$repuestoFactory = new RepuestoFactory();

// Instanciar el manejador de inventario
$inventoryManager = new InventoryManager($db, $repuestoFactory);

// Crear el menú principal usando el método estático de fábrica
$menuPrincipal = Menu::createMainMenu($inventoryManager);

// Iniciar el menú
$menuPrincipal->iniciar();

echo "¡Aplicación finalizada!\n";

?>
