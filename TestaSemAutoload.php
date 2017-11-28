<?php
require_once 'autoload.php';

$usuario = new Usuario(0, "hygor@gmail.com", "123");
$endereco = new Endereco(0, "Virginia Ferreira", "Flavio Garcia", "Coxim", "MS", "79400000");
$cliente = new Cliente(0, "Antonio Ribeiro", $endereco, "antonio.ribeiro@gmail.com");
$produto = new Produto(0, "Livro de PHP", "Livro de PHP OO", 60.00);

