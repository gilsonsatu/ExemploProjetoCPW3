<?php 

require_once 'autoload.php';
require_once 'Conexao.php';

$ctlUsuario = new CtlUsuario($conexao);
$usuarioLogado = $ctlUsuario->getUsuarioLogado();

?>
<html>
    <head>
        <title>Cliente</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">Sistema de Vendas</a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item ">
                            <a class="nav-link" href="#"> Início</a>
                        </li>
                        <?php if($usuarioLogado!='') { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="CtlProduto.php?op=lista">Produtos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="CtlCliente.php?op=listaComPaginacao">Clientes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="CtlPedido.php?op=lista">Pedidos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="CtlUsuario.php?op=listaComPaginacao">Usuários</a>
                        </li>
                        <?php } ?>
                        
                    </ul>
                    <div>
                        <?php if($usuarioLogado!='') { ?>
                        Usuário: <?=$usuarioLogado ?>
                        <a href="CtlUsuario.php?op=sair">
                            (Sair)
                        </a>
                        <?php } else { ?>
                        <a href="FormLogin.php">
                            Login
                        </a>
                        <?php } ?>
                    </div>
                </div>
            </nav> 