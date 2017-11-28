<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cliente
 *
 * @author gilson
 */
class Usuario {
    private $id;
    private $email;
    private $senha;
        
    function __construct($id, $email, $senha) {
        $this->id = $id;
        $this->email = $email;
        $this->senha = $senha;
    }
    
    function getId() {
        return $this->id;
    }

    function getEmail() {
        return $this->email;
    }

    function getSenha() {
        return $this->senha;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }




}
