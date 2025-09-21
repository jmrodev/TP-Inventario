<?php

    class Persona {
        static $ultimoId = 0;

        private $id;
        private $nombre;
        private $ciudad_id;

        function __construct($nombre, $ciudad_id)
        {
            Persona::$ultimoId++;

            $this->id = Persona::$ultimoId; 
            $this->nombre = $nombre;
            $this->ciudad_id = $ciudad_id; 
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

        /**
         * Get the value of ciudad_id
         */ 
        public function getCiudad_id()
        {
                return $this->ciudad_id;
        }

        /**
         * Set the value of ciudad_id
         *
         * @return  self
         */ 
        public function setCiudad_id($ciudad_id)
        {
                $this->ciudad_id = $ciudad_id;

                return $this;
        }
    }