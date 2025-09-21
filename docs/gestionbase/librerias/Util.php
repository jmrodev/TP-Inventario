<?php

    function mostrar($texto) {
        echo $texto."\n";
    }

    function leer($mensaje = "") {
        echo($mensaje);
        $x = trim(fgets(STDIN));
        return $x;
    }