<?php

require_once './conexao.php';
require_once './autoload.php';

$ctlCliente = new CtlCliente($conexao);

if (isset($_GET)) {
    $op = $_GET["op"];
    switch ($op) {
        case "salvar" : $ctlCliente->salvar($_POST);
            break;
        case "formAltera" : $ctlCliente->formAltera($_GET["id"]);
            break;
        case "formInsere" : $ctlCliente->formInsere();
            break;
        case "lista" : $ctlCliente->lista();
            break;
        case "listaComPaginacao" : $ctlCliente->listaComPaginacao($_GET);
            break;
        case "remove" : $ctlCliente->remove($_POST["id"]);
            break;
    }
}

class CtlCliente {

    public $daoCliente;
    public $conexao;

    function __construct($conexao) {
        $this->daoCliente = new DaoCliente($conexao);
        $this->conexao = $conexao;
    }

    function salvar($params) {
        $endereco = new Endereco(1, "x", "x", "x", "x", "x");
        $cliente = new Cliente($params["id"], $params["nome"], $endereco, $params["email"]);
        $cliente->setCpf($params["cpf"]);
        if(!isset($params["foto_img"])) {
            $cliente->setFoto($this->upload($_FILES));
        } else {
            $cliente->setFoto($params["foto_img"]);
        }
        if ($cliente->getId() == 0) {
            $this->daoCliente->insere($cliente);
        } else {
            $this->daoCliente->altera($cliente);
        }
        $this->listaComPaginacao();
    }
    
    private function upload($params) {
        $nome_arquivo = $params["foto"]["name"];
        $nome_arquivo_tmp = $params["foto"]["tmp_name"];
        if(move_uploaded_file($nome_arquivo_tmp, "./img/clientes/".$nome_arquivo)){
            return "./img/clientes/".$nome_arquivo;
        }else{
            return "";
        }
    }

    function remove($id) {
        $this->daoCliente->remove($id);
        header("Location: listaCliente.php");
    }

    function formAltera($id) {
        header("Location: FormCliente.php?id=" . $id);
    }

    function formInsere() {
        header("Location: FormCliente.php");
    }

    function lista() {
        $ctlUsuario = new CtlUsuario($this->conexao);
        $ctlUsuario->protegeAcesso();
        $daoCliente = new DaoCliente($this->conexao);
        $clientes = $daoCliente->getLista();
        require_once './ListaCliente.php';
    }

    function listaComPaginacao($params='') {
        $ctlUsuario = new CtlUsuario($this->conexao);
        $ctlUsuario->protegeAcesso();
        $daoCliente = new DaoCliente($this->conexao);
        $pagina = isset($params["pagina"])?$params["pagina"]:1;
        $maxRegPag = isset($params["maxRegPag"])?$params["maxRegPag"]:2;
        $clientes = $daoCliente->getListaComPaginacao($pagina, $maxRegPag);
        $qtdPaginas = ceil($daoCliente->getTotalRegistrosDaLista()/$maxRegPag);
        require_once './ListaCliente.php';
    }

}
