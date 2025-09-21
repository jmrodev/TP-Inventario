<?php

    function seno() {

        mostrar("calcular seno");
    }
    function coseno() {
        mostrar("calcular coseno");
    }
    function tangente() {
        mostrar("calcular tangente");
    }

    function sumar() {
        mostrar("Primer operando:");
        $x = trim(fgets(STDIN));
        mostrar("Segundo operando:");
        $y = trim(fgets(STDIN));
        
        mostrar ($x + $y);
    }

    function multiplicar() {
        mostrar("Primer operando:");
        $x = trim(fgets(STDIN));
        mostrar("Segundo operando:");
        $y = trim(fgets(STDIN));

        mostrar ($x * $y);
    }

    function potencia() {
        mostrar("Primer operando:");
        $base = trim(fgets(STDIN));
        mostrar("Segundo operando:");
        $exponente = trim(fgets(STDIN));

        mostrar( pow($base, $exponente));
    }