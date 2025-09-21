<?php
    class DB {
        private $personas = [];
        private $ciudades = [];

        function agregarPersona($persona) {
            $this->personas[] = $persona;
        }

        function getPersonas() {
            return $this->personas;
        }

        function getCiudades() {
            return $this->ciudades;
        }

        function agregarCiudad($ciudad) {
            $this->ciudades[] = $ciudad;
        }

        function buscarCiudadPorNombre($nombre) {

            foreach ($this->ciudades as $ciudad) {
                if ($ciudad->getNombre() == $nombre) {
                    return $ciudad;
                }
            }
            return null;
        }

        function buscarIndiceCiudadPorNombre($nombre) {
            $indice = 0;
            foreach ($this->ciudades as $ciudad) {
                if ($ciudad->getNombre() == $nombre) {
                    return $indice;
                }
                $indice++;
            }
            return null;
        }

        function borrarCiudadPorNombre($nombre) {
            $indice = $this->buscarIndiceCiudadPorNombre($nombre);
            if ($indice) {
                array_splice($this->ciudades, $indice, 1);
                return true;
            } else {
                return false;
            }

        }

    }