<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pedido
 *
 * @author gilson
 */
class Pedido {
    private $id;
    private $cliente;
    private $data;
    private $total;
    private $formaPgto;
    
    function __construct($id, Cliente $cliente, $data, $total, $formaPgto) {
        $this->id = $id;
        $this->cliente = $cliente;
        $this->data = $data;
        $this->total = $total;
        $this->formaPgto = $formaPgto;
    }
    
    function getId() {
        return $this->id;
    }

    function getCliente() {
        return $this->cliente;
    }

    function getData() {
        return $this->data;
    }

    function getTotal() {
        return $this->total;
    }

    function getFormaPgto() {
        return $this->formaPgto;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setTotal($total) {
        $this->total = $total;
    }

    function setFormaPgto($formaPgto) {
        $this->formaPgto = $formaPgto;
    }



}
