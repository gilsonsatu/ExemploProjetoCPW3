<?php
    require_once 'Endereco.php';
    require_once 'Cliente.php';
    require_once 'Pedido.php';
    require_once 'Conexao.php';
    require_once 'DaoCliente.php';
    
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
            $this->daoCliente = new DaoCliente($conexao);
            $this->conexao = $conexao;
        }

        function testaInsere(){
            echo("<br><b>Testa Insere</b><br>");
            $endereco = new Endereco(1, "x", "x", "x", "x", "x");
            $cliente = new Cliente(0, "x", $endereco, "x");
            $this->daoCliente->insere($cliente);
            echo("Registro inserido<br>");
        }
        
        function testaAltera(){
            echo("<br><b>Testa Altera</b><br>");
            $endereco = new Endereco(1, "x", "x", "x", "x", "x");
            $cliente = new Cliente($this->ultimoId(), "y", $endereco, "y");
            $this->daoCliente->altera($cliente);
            echo("Registro alterado<br>");
        }

        
        function testaRemove(){
            echo("<br><b>Testa Remove</b><br>");
            $this->daoCliente->remove($this->ultimoId());
            echo("Registro removido<br>");
        }
        
        function testaGetPorId() {
            echo("<br><b>Testa GetPorId</b><br>");
            $cliente = $this->daoCliente->getPorId(1);
            echo $cliente->getNome()."<br>";
            echo $cliente->getendereco()->getRua()."<br>";
        }
        
        function testaGetLista() {
            echo("<br><b>Testa GetLista</b><br>");
            $clientes = $this->daoCliente->getLista();
            foreach($clientes as $cliente) {
                echo $cliente->getNome()."<br>";
                echo $cliente->getendereco()->getRua()."<br>";
            }
        }
        
        function ultimoId(){
            $sql = "select max(id) from cliente";                              
            $registros = mysqli_query($this->conexao, $sql);                                
            $registro = mysqli_fetch_assoc($registros);                                     
            return $registro["max(id)"];
        }
    
    }
    
    
    
    
    
    
    
