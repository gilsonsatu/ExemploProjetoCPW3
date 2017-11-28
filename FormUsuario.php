<?php require_once("./cabecalho.php"); ?>

<?php
$daoUsuario = new DaoUsuario($conexao);
if (isset($_GET) && (isset($_GET["id"]))) {
    $id = $_GET["id"];
    $usuario = $daoUsuario->getPorId($id);
} else {
    $usuario = new Usuario(0, "", "");
}
?>	




<h1>Usuario</h1>
<form action="CtlUsuario.php?op=salvar" method="post">
    <div class="form-group">
        <input type="hidden" name="id" value="<?= $usuario->getId() ?>">
        <label>E-mail</label>
        <input class="form-control" type="email" name="email" value="<?= $usuario->getEmail() ?>">
    </div>
    <div class="form-group">
        <label>Senha</label>
        <input class="form-control" type="password" name="senha" value="<?= $usuario->getSenha() ?>">
    </div>
    <div class="form-group">
        <button class="btn btn-primary" type="submit">Salvar</button>
    </div>
</form>
<?php require_once("./rodape.php"); ?>
