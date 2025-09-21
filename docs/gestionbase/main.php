<?php

    require_once('./librerias/Menu.php');
    require_once('./librerias/Util.php');
    require_once('./db/LoadDatos.php');
    
    
    function listarCiudades() {
        global $db;

        $ciudades = $db->getCiudades();
        foreach ($ciudades as $ciudad) {
            echo $ciudad; echo ("\n");
        }

        mostrar("Cantidad de ciudades:".count($db->getCiudades()));
        leer("\nPresione ENTER para continuar ...");
    }

    function agregarCiudades() {
        global $db;

        mostrar("Agregar ciudad");

        $nombre = leer("Nombre:");
        $nombre = ucwords($nombre);

        $ciudad = new Ciudad($nombre);
        $db->agregarCiudad($ciudad);

        mostrar("Se agrego una ciudad");
        leer("\nPresione ENTER para continuar ...");
    }

    function borrarCiudades() {
        global $db;

        mostrar("Borrar ciudad");

        $nombre = leer("Nombre:");
        $nombre = ucwords($nombre);

        $resultado = $db->borrarCiudadPorNombre($nombre);
        if ($resultado) {
            mostrar("Se borro una ciudad");
        } else {
            mostrar("No se encontro la ciudad");
        }
        
        leer("\nPresione ENTER para continuar ...");
    }


    function ciudades() {
        $menu = Menu::getMenuCiudades();
        $opcion = $menu->elegir();
        while ($opcion->getNombre() != 'Salir') {

            $funcion = $opcion->getFuncion();
            call_user_func($funcion);
    
            $opcion = $menu->elegir();    
    
        }
    }

    function personas() {
        mostrar('Gestionar personas');
        die;
    }

    // Personas
    // Ciudades
    // Personas tienen una ciudad de nacimiento

    mostrar("Sistema de Gestión de Personas");
    mostrar("==============================");
    mostrar("(C) 2025");


    $menu = Menu::getMenuPrincipal();
    $opcion = $menu->elegir();

    while ($opcion->getNombre() != 'Salir') {

        $funcion = $opcion->getFuncion();
        call_user_func($funcion);

        $opcion = $menu->elegir();    

    }
    
