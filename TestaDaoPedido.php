<?php

require_once 'Endereco.php';
require_once 'Cliente.php';
require_once 'Pedido.php';
require_once 'Conexao.php';
require_once 'DaoPedido.php';

$daoUsuario = new TestaClasses($conexao);
$daoUsuario->testaGetPorId();
$daoUsuario->testaGetLista();
$daoUsuario->testaInsere();
$daoUsuario->testaRemove();
$daoUsuario->testaAltera();

class TestaClasses {

    public $daoUsuario;
    public $conexao;

    function __construct($conexao) {
        $this->daoPedido = new DaoPedido($conexao);
        $this->conexao = $conexao;
    }

    function testaInsere() {
        echo("<br><b>Testa Insere</b><br>");
        $endereco = new Endereco(1, "x", "x", "x", "x", "x");
        $cliente = new Cliente(0, "x", $endereco, "x");
        $pedido = new Pedido(0, $cliente, "01/01/2017", 100, "A Vista");
        $this->daoPedido->insere($pedido);
        echo("Registro inserido<br>");
    }

    function testaAltera() {
        echo("<br><b>Testa Altera</b><br>");
        $endereco = new Endereco(1, "x", "x", "x", "x", "x");
        $cliente = new Cliente($this->ultimoId(), "y", $endereco, "y");
        $pedido = new Pedido(0, $cliente, "01/01/2017", 200, "A Vista");
        $this->daoPedido->altera($pedido);
        echo("Registro alterado<br>");
    }

    function testaRemove() {
        echo("<br><b>Testa Remove</b><br>");
        $this->daoPedido->remove($this->ultimoId());
        echo("Registro removido<br>");
    }

    function testaGetPorId() {
        echo("<br><b>Testa GetPorId</b><br>");
        $pedido = $this->daoPedido->getPorId(1);
        echo $pedido->getId() . "<br>";
        echo $pedido->getData() . "<br>";
        echo $pedido->getCliente()->getNome() . "<br>";
        echo $pedido->getTotal() . "<br>";
    }

    function testaGetLista() {
        echo("<br><b>Testa GetLista</b><br>");
        $pedidos = $this->daoPedido->getLista();
        foreach ($pedidos as $pedido) {
            echo $pedido->getId() . "<br>";
            echo $pedido->getData() . "<br>";
            echo $pedido->getCliente()->getNome() . "<br>";
            echo $pedido->getTotal() . "<br>";
        }
    }

    function ultimoId() {
        $sql = "select max(id) from pedido";
        $registros = mysqli_query($this->conexao, $sql);
        $registro = mysqli_fetch_assoc($registros);
        return $registro["max(id)"];
    }

}
