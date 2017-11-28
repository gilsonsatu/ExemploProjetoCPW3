<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Livro
 *
 * @author gilson
 */
class Livro extends Produto {
    private $isbn;
    
    function calculaImposto(){
        return $this->getPreco() * 0.06;
    }
    
    function getIsbn() {
        return $this->isbn;
    }

    function setIsbn($isbn) {
        $this->isbn = $isbn;
    }


}
