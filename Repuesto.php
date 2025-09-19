<?php

abstract class Repuesto {

    protected $id;
    protected $nombre;
    protected $descripcion;
    protected $precio;
    protected $cantidad;
    protected $categoria;
    protected $marca;
    protected $modelo;

    public function __construct($id, $nombre, $descripcion, $precio, $cantidad, $categoria, $marca, $modelo) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->cantidad = $cantidad;
        $this->categoria = $categoria;
        $this->marca = $marca;
        $this->modelo = $modelo;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function getMarca() {
        return $this->marca;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    public function setMarca($marca) {
        $this->marca = $marca;
    }

    public function setModelo($modelo) {
        $this->modelo = $modelo;
    }
}
