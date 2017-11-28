<?php
    require_once 'Usuario.php';
    require_once 'Conexao.php';
    require_once 'DaoUsuario.php';
    
    $daoUsuario = new TestaClasses($conexao);
    $daoUsuario->testaInsere();
    $daoUsuario->testaGetPorId();
    $daoUsuario->testaGetLista();
    $daoUsuario->testaAltera();
    $daoUsuario->testaRemove();
   
    
    
    
    class TestaClasses {
    
        public $daoUsuario;
        public $conexao;
        
        function __construct($conexao) {
            $this->daoUsuario = new DaoUsuario($conexao);
            $this->conexao = $conexao;
        }

        function testaInsere(){
            echo("<br><b>Testa Insere</b><br>");
            $usuario = new Usuario(0, "x", "x");
            $this->daoUsuario->insere($usuario);
            echo("Registro inserido<br>");
        }
        
        function testaAltera(){
            echo("<br><b>Testa Altera</b><br>");
            $usuario = new Usuario($this->ultimoId(), "y", "y");
            $this->daoUsuario->altera($usuario);
            echo("Registro alterado<br>");
        }

        
        function testaRemove(){
            echo("<br><b>Testa Remove</b><br>");
            $this->daoUsuario->remove($this->ultimoId());
            echo("Registro removido<br>");
        }
        
        function testaGetPorId() {
            echo("<br><b>Testa GetPorId</b><br>");
            $usuario = $this->daoUsuario->getPorId(1);
            echo $usuario->getEmail()."<br>";
            echo $usuario->getSenha()."<br>";
        }
        
        function testaGetLista() {
            echo("<br><b>Testa GetLista</b><br>");
            $usuarios = $this->daoUsuario->getLista();
            foreach($usuarios as $usuario) {
                echo $usuario->getEmail()."<br>";
                echo $usuario->getSenha()."<br>";
            }
        }
        
        function ultimoId(){
            $sql = "select max(id) from usuario";                              
            $registros = mysqli_query($this->conexao, $sql);                                
            $registro = mysqli_fetch_assoc($registros);                                     
            return $registro["max(id)"];
        }
    
    }
    
    
    
    
    
    
    
