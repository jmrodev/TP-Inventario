<?php
    require_once('DB.php');
    require_once('Ciudad.php');
    require_once('Persona.php');

    $db = new DB();

    $db->agregarCiudad(new Ciudad('Tandil'));
    $db->agregarCiudad(new Ciudad('Necochea'));
    $db->agregarCiudad(new Ciudad('Olavarria'));

    $db->agregarPersona(new Persona("Pepe", 1));
    $db->agregarPersona(new Persona("Luis", 1));
    $db->agregarPersona(new Persona("Maria", 2));
    $db->agregarPersona(new Persona("Manuel", 3));
    
    