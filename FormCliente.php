<?php
require_once './cabecalho.php';

$daoUsuario = new DaoCliente($conexao);
if (isset($_GET) && (isset($_GET["id"]))) {
    $id = $_GET["id"];
    $cliente = $daoUsuario->getPorId($id);
} else {
    $cliente = new Cliente(0, "", new Endereco(1, "", "", "", "", ""), "");
    $cliente->setFoto("");
}
?>	


<?php require_once("./cabecalho.php"); ?>

<h1>Cliente</h1>
<form action="CtlCliente.php?op=salvar" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <input type="hidden" name="id" value="<?= $cliente->getId() ?>">
        <label>Nome</label>
        <input class="form-control" type="text" name="nome" value="<?= $cliente->getNome() ?>">
    </div>
    <div class="form-group">
        <label>CPF</label>
        <input class="form-control" type="text" name="cpf" value="<?= $cliente->getCpf() ?>">
    </div>
    <div class="form-group">
        <label>E-mail</label>
        <input class="form-control" type="email" name="email" value="<?= $cliente->getEmail() ?>">
    </div>
    <div class="form-group">
        <label>Foto</label>
        <?php if($cliente->getFoto()!=''): ?>
        <img src="<?=$cliente->getFoto() ?>">
        <input type="hidden" name="foto_img" value="<?=$cliente->getFoto() ?>">
        <?php else : ?>
        <input class="form-control" type="file" name="foto" class="form-control">
        <?php endif ?>
    </div>
    <div class="form-group">
        <button class="btn btn-primary" type="submit">Salvar</button>
    </div>
</form>
<?php require_once("./rodape.php"); ?>