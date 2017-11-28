<?php

require_once 'Produto.php';
require_once 'Livro.php';
require_once 'Conexao.php';
require_once 'DaoProduto.php';

$teste = new TestaClasses($conexao);
//    $teste->testaInsere();
//    $teste->testaGetPorId();
//    $teste->testaGetLista();
//    $teste->testaAltera();
//    $teste->testaRemove();
//    $teste->testaToStringProduto();
$teste->testaToString();
$teste->testaHeranca();
$teste->testaCalculaImposto();

class TestaClasses {

    public $daoProduto;
    public $conexao;

    function __construct($conexao) {
        $this->daoProduto = new DaoProduto($conexao);
        $this->conexao = $conexao;
    }

    function testaInsere() {
        echo("<br><b>Testa Insere</b><br>");
        $produto = new Produto(0, "x", "x", 10);
        $this->daoProduto->insere($produto);
        echo("Registro inserido<br>");
    }

    function testaAltera() {
        echo("<br><b>Testa Altera</b><br>");
        $produto = new Produto($this->ultimoId(), "y", "y", 10);
        $this->daoProduto->altera($produto);
        echo("Registro alterado<br>");
    }

    function testaRemove() {
        echo("<br><b>Testa Remove</b><br>");
        $this->daoProduto->remove($this->ultimoId());
        echo("Registro removido<br>");
    }

    function testaGetPorId() {
        echo("<br><b>Testa GetPorId</b><br>");
        $produto = $this->daoProduto->getPorId(1);
        echo $produto->getNome() . "<br>";
        echo $produto->getPreco() . "<br>";
    }

    function testaGetLista() {
        echo("<br><b>Testa GetLista</b><br>");
        $produtos = $this->daoProduto->getLista();
        foreach ($produtos as $produto) {
            echo $produto->getNome() . "<br>";
            echo $produto->getPreco() . "<br>";
        }
    }

    function ultimoId() {
        $sql = "select max(id) from produto";
        $registros = mysqli_query($this->conexao, $sql);
        $registro = mysqli_fetch_assoc($registros);
        return $registro["max(id)"];
    }

    function testaToString() {
        echo("<br><b>Testa ToString</b><br>");
        $produto = new Produto(0, "Computador", "Computador i7", 2700);
        echo($produto);
    }

    function testaHeranca() {
        echo("<br><b>Testa Herança</b><br>");
        $produto = new Livro(0, "Livro de Engenharia de Software", "Livro Bom", 160);
        $produto->setIsbn("101010");
        echo($produto->getNome() . " " . $produto->getIsbn());
    }

    function testaCalculaImposto() {
        echo("<br><b>Testa CalculaImposto</b><br>");
        $produto = new Livro(0, "Livro de Engenharia de Software", "Livro Bom", 160);
        $produto->setIsbn("101010");
        echo("Livro: ".$produto->getNome() . " " . $produto->calculaImposto()."<br>");
        $produto = new Produto(0, "Bicleta", "Bicicleta 18 marchas", 500);
        echo("Produto: ".$produto->getNome() . " " . $produto->calculaImposto());
    }

}
