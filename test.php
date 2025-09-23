<?php

require_once 'src/Controllers/RepuestoController.php';
require_once 'src/Models/Repuesto.php'; // Ensure Repuesto is loaded
require_once 'src/Database/bd.php'; // Ensure InMemoryDatabase is loaded

echo "--- Probando RepuestoController ---\n\n";

$controller = new RepuestoController();

echo "1. Agregando repuestos:\n";
$repuesto1 = $controller->agregarRepuesto("Filtro de Aire", 15.50, 10);
echo "Agregado: " . $repuesto1->getNombre() . " (ID: " . $repuesto1->getId() . ")\n";

$repuesto2 = $controller->agregarRepuesto("Bujía", 5.00, 50);
echo "Agregado: " . $repuesto2->getNombre() . " (ID: " . $repuesto2->getId() . ")\n";

echo "\n2. Listando todos los repuestos:\n";
$repuestos = $controller->listarRepuestos();
foreach ($repuestos as $repuesto) {
    echo "ID: " . $repuesto->getId() . ", Nombre: " . $repuesto->getNombre() . ", Precio: " . $repuesto->getPrecio() . ", Cantidad: " . $repuesto->getCantidad() . "\n";
}

echo "\n3. Actualizando un repuesto (ID: " . $repuesto1->getId() . "):\n";
$controller->actualizarRepuesto($repuesto1->getId(), "Filtro de Aire Premium", 25.00, 8);
$repuestos = $controller->listarRepuestos();
foreach ($repuestos as $repuesto) {
    echo "ID: " . $repuesto->getId() . ", Nombre: " . $repuesto->getNombre() . ", Precio: " . $repuesto->getPrecio() . ", Cantidad: " . $repuesto->getCantidad() . "\n";
}

echo "\n4. Eliminando un repuesto (ID: " . $repuesto2->getId() . "):\n";
$controller->eliminarRepuesto($repuesto2->getId());
echo "Repuesto con ID " . $repuesto2->getId() . " eliminado.\n";

echo "\n5. Listando repuestos después de eliminar:\n";
$repuestos = $controller->listarRepuestos();
if (empty($repuestos)) {
    echo "No hay repuestos en el inventario.\n";
} else {
    foreach ($repuestos as $repuesto) {
        echo "ID: " . $repuesto->getId() . ", Nombre: " . $repuesto->getNombre() . ", Precio: " . $repuesto->getPrecio() . ", Cantidad: " . $repuesto->getCantidad() . "\n";
    }
}

echo "\n--- Fin de la prueba ---\n";

echo "\n\n--- Probando ClienteController ---\n\n";

require_once 'src/Controllers/ClienteController.php';
require_once 'src/Models/Cliente.php'; // Ensure Cliente is loaded

$clienteController = new ClienteController();

echo "1. Agregando clientes:\n";
$cliente1 = $clienteController->agregarCliente("Juan Perez", "12345678A");
echo "Agregado: " . $cliente1->getNombre() . " (ID: " . $cliente1->getId() . ", DNI: " . $cliente1->getDni() . ")\n";

$cliente2 = $clienteController->agregarCliente("Maria Garcia", "87654321B");
echo "Agregado: " . $cliente2->getNombre() . " (ID: " . $cliente2->getId() . ", DNI: " . $cliente2->getDni() . ")\n";

echo "\n2. Listando todos los clientes:\n";
$clientes = $clienteController->listarClientes();
foreach ($clientes as $cliente) {
    echo "ID: " . $cliente->getId() . ", Nombre: " . $cliente->getNombre() . ", DNI: " . $cliente->getDni() . "\n";
}

echo "\n3. Actualizando un cliente (ID: " . $cliente1->getId() . "):\n";
$clienteController->actualizarCliente($cliente1->getId(), "Juan Perez Actualizado", "11111111C");
$clientes = $clienteController->listarClientes();
foreach ($clientes as $cliente) {
    echo "ID: " . $cliente->getId() . ", Nombre: " . $cliente->getNombre() . ", DNI: " . $cliente->getDni() . "\n";
}

echo "\n4. Eliminando un cliente (ID: " . $cliente2->getId() . "):\n";
$clienteController->eliminarCliente($cliente2->getId());
echo "Cliente con ID " . $cliente2->getId() . " eliminado.\n";

echo "\n5. Listando clientes después de eliminar:\n";
$clientes = $clienteController->listarClientes();
if (empty($clientes)) {
    echo "No hay clientes en el inventario.\n";
} else {
    foreach ($clientes as $cliente) {
        echo "ID: " . $cliente->getId() . ", Nombre: " . $cliente->getNombre() . ", DNI: " . $cliente->getDni() . "\n";
    }
}

echo "\n--- Fin de la prueba de ClienteController ---\n";


?>