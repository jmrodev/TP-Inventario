<?php

define('BASE_PATH', __DIR__ . '/../../');

require_once BASE_PATH . 'src/Database/bd.php';
require_once BASE_PATH . 'src/Models/Repuesto.php';
require_once BASE_PATH . 'src/Models/RepuestoMoto.php';
require_once BASE_PATH . 'src/Models/RepuestoCamion.php';
require_once BASE_PATH . 'src/Models/RepuestoCamioneta.php';
require_once BASE_PATH . 'src/Factories/RepuestoFactory.php';
require_once BASE_PATH . 'src/Core/MenuRendererInterface.php';
require_once BASE_PATH . 'src/Core/ConsoleMenuRenderer.php';
require_once BASE_PATH . 'src/Core/Menu.php';
require_once BASE_PATH . 'src/Core/InventoryManager.php';

use App\Core\Menu;
use App\Core\InventoryManager;
use App\Core\ConsoleMenuRenderer;
use App\Database\InMemoryDatabase;
use App\Factories\RepuestoFactory;

$db = InMemoryDatabase::getInstance();
$repuestoFactory = new RepuestoFactory();

$inventoryManager = new InventoryManager($db, $repuestoFactory);

$consoleRenderer = new ConsoleMenuRenderer();

$menuPrincipal = Menu::createMainMenu($inventoryManager, $consoleRenderer);

$menuPrincipal->iniciar();

echo "¡Aplicación finalizada!\n";

?>
