<?php 

include_once 'Repuesto.php';
include_once 'RepuestoMoto.php';
include_once 'bd.php';

$db = new InMemoryDatabase();

$repuestoMoto = new RepuestoMoto(null, "Filtro de aire", "Filtro de aire para moto", 25.99, 10, "Yamaha", "YZF-R3");
$db->addRepuesto($repuestoMoto);

    function mostrarRepuesto($repuesto) {
        echo "ID: " . $repuesto->getId() . "\n";
        echo "Nombre: " . $repuesto->getNombre() . "\n";
        echo "Descripcion: " . $repuesto->getDescripcion() . "\n";
        echo "Precio: $" . $repuesto->getPrecio() . "\n";
        echo "Cantidad: " . $repuesto->getCantidad() . "\n";
        echo "Categoria: " . $repuesto->getCategoria() . "\n";
        echo "Marca: " . $repuesto->getMarca() . "\n";
        echo "Modelo: " . $repuesto->getModelo() . "\n";
        echo "--------------------------\n";
    }


foreach ($db->getAllRepuestos() as $repuesto) {
    mostrarRepuesto($repuesto);
}




