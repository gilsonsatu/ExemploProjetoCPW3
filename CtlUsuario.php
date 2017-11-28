<?php
require_once './conexao.php';
require_once './autoload.php';


$ctlUsuario = new CtlUsuario($conexao);
if (isset($_GET) && (substr(basename($_SERVER['REQUEST_URI']), 0, 14) == "CtlUsuario.php")) {
    $op = $_GET["op"];
    switch ($op) {
        case "salvar" : $ctlUsuario->salvar($_POST);
            break;
        case "formAltera" : $ctlUsuario->formAltera($_GET["id"]);
            break;
        case "formInsere" : $ctlUsuario->formInsere();
            break;
        case "lista" : $ctlUsuario->lista();
            break;
        case "relatorioLista" : $ctlUsuario->relatorioLista();
            break;
        case "listaComPaginacao" : $ctlUsuario->listaComPaginacao($_GET);
            break;
        case "remove" : $ctlUsuario->remove($_POST["id"]);
            break;
        case "autenticar" : $ctlUsuario->autenticar($_POST);
            break;
        case "sair" : $ctlUsuario->sair();
            break;
    }
}

class CtlUsuario {

    public $daoUsuario;
    public $conexao;

    function __construct($conexao) {
        $this->daoUsuario = new DaoUsuario($conexao);
        $this->conexao = $conexao;
    }

    function salvar($params) {
        $usuario = new Usuario($params["id"], $params["email"], $params["senha"]);
        if ($usuario->getId() == 0) {
            $this->daoUsuario->insere($usuario);
        } else {
            $this->daoUsuario->altera($usuario);
        }
        $this->listaComPaginacao();
    }

    function remove($id) {
        $this->daoUsuario->remove($id);
        header("Location: listaUsuario.php");
    }

    function formAltera($id) {
        header("Location: FormUsuario.php?id=" . $id);
    }

    function formInsere() {
        header("Location: FormUsuario.php");
    }

    function lista() {
        header("Location: listaUsuario.php");
    }
    
    function relatorioLista() {
        $ctlUsuario = new CtlUsuario($this->conexao);
        $ctlUsuario->protegeAcesso();
        $daoUsuario = new DaoUsuario($this->conexao);
        $usuarios = $daoUsuario->getLista();
        $relUsuario = new RelUsuario();
        $relUsuario->imprimir($usuarios);
    }    
    
    function listaComPaginacao($params='') {
        $ctlUsuario = new CtlUsuario($this->conexao);
        $ctlUsuario->protegeAcesso();
        $daoUsuario = new DaoUsuario($this->conexao);
        $pagina = isset($params["pagina"])?$params["pagina"]:1;
        $maxRegPag = isset($params["maxRegPag"])?$params["maxRegPag"]:2;
        $usuarios = $daoUsuario->getListaComPaginacao($pagina, $maxRegPag);
        $qtdPaginas = ceil($daoUsuario->getTotalRegistrosDaLista()/$maxRegPag);
        require_once './ListaUsuario.php';        
    }
    

    function autenticar($params) {
        $usuario = new Usuario(0, $params["email"], $params["senha"]);
        if ($this->daoUsuario->existe($usuario)) {
            session_start();
            $_SESSION["usuario"] = $usuario->getEmail();
            header("Location: CtlCliente.php?op=listaComPaginacao");
        } else {
            session_start();
            $_SESSION["msgFalhaLogin"] = "Falha na autenticação.";
            header("Location: FormLogin.php");
        }
    }

    function existeErroDeAutenticacao() {
        session_start();
        if(isset($_SESSION["msgFalhaLogin"])) {
            return true;
        } else {
            return false;
        }
    }
    
    function getMsgErroDeAutenticacao(){
        session_start();
        if(isset($_SESSION["msgFalhaLogin"])) {
            $msg = $_SESSION["msgFalhaLogin"];
            unset($_SESSION["msgFalhaLogin"]);
            return $msg;
        } else {
            return '';
        }
    }
    
    

    function getUsuarioLogado(){
        session_start();
        if(isset($_SESSION["usuario"])){
            return $_SESSION["usuario"];
        } else {
            return '';
        }  
    }
    
    
    function sair() {
        session_start();
        unset($_SESSION["usuario"]);
        header("Location: FormLogin.php");
    }

    function protegeAcesso() {
        session_start();
        if ($_SESSION["usuario"] == '') {
            header('Location: FormLogin.php');
        }
    }

}
