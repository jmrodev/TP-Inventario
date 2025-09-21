<?php

    class Ciudad {
        static $ultimoId = 0;

        private $id;
        private $nombre;

        function __construct($nombre)
        {
            Ciudad::$ultimoId++;
            $this->id = Ciudad::$ultimoId;
            $this->nombre = $nombre;
        }

        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Get the value of nombre
         */ 
        public function getNombre()
        {
                return $this->nombre;
        }

        /**
         * Set the value of nombre
         *
         * @return  self
         */ 
        public function setNombre($nombre)
        {
                $this->nombre = $nombre;

                return $this;
        }

        public function __toString() {
            $salida = "Id: ".$this->getId()." Nombre: ".$this->getNombre();
            return $salida;
        }
    }