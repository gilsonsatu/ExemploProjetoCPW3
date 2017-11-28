<?php require_once("./cabecalho.php"); ?>
<?php

if($ctlUsuario->existeErroDeAutenticacao()){
?>
    <div class="alert alert-danger">
        <?=$ctlUsuario->getMsgErroDeAutenticacao()?>
    </div>
<?php 
}
?>


<h1>Acesso ao Sistema</h1>
<form action="CtlUsuario.php?op=autenticar" method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">E-mail</label>
    <input type="email" class="form-control"  name="email"  id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Entre com seu e-mail">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Senha</label>
    <input type="password" class="form-control" name="senha" id="exampleInputPassword1" placeholder="Senha">
  </div>
  <button type="submit" class="btn btn-primary">Acessar</button>
</form>


<?php require_once("./rodape.php"); ?>
