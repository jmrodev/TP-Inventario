<?php

define('BASE_PATH', __DIR__ . '/../../');

require_once BASE_PATH . 'src/Database/bd.php';
require_once BASE_PATH . 'src/Models/Repuesto.php';
require_once BASE_PATH . 'src/Models/RepuestoMoto.php';
require_once BASE_PATH . 'src/Models/RepuestoCamion.php';
require_once BASE_PATH . 'src/Models/RepuestoCamioneta.php';
require_once BASE_PATH . 'src/Core/Menu.php';
require_once BASE_PATH . 'src/Core/MenuRendererInterface.php';
require_once BASE_PATH . 'src/Core/ConsoleMenuRenderer.php';
require_once BASE_PATH . 'src/Views/ConsoleView.php';
require_once BASE_PATH . 'src/Controllers/InventoryController.php';

use App\Core\Menu;
use App\Core\ConsoleMenuRenderer;
use App\Controllers\InventoryController;
use App\Views\ConsoleView;
use App\Database\InMemoryDatabase;

$db = InMemoryDatabase::getInstance();

$consoleRenderer = new ConsoleMenuRenderer();
$consoleView = new ConsoleView();

$menuOptions = [
    1 => ['descripcion' => 'Añadir Repuesto'],
    2 => ['descripcion' => 'Listar Repuestos'],
    3 => ['descripcion' => 'Editar Repuesto'],
    4 => ['descripcion' => 'Eliminar Repuesto'],
    5 => ['descripcion' => 'Salir']
];
$mainMenu = new Menu("Menú Principal de Inventario", $menuOptions, $consoleRenderer);

$controller = new InventoryController($db, $consoleView, $mainMenu);
$controller->run();

?>
