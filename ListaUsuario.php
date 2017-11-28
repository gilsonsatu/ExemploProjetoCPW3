<?php require_once("./cabecalho.php"); ?>


<div class="row">
    <h1 class="col-md-10">Usuario</h1>
    <div class="col-md-1">
        <a href="CtlUsuario.php?op=relatorioLista"  target="_blank" class="btn btn-primary">Relatório</a>
    </div>
    <div class="col-md-1">
        <a href="CtlUsuario.php?op=formInsere" class="btn btn-primary">Novo</a>
    </div>
</div>
<table class="table table-striped table-bordered">
    <tr>
        <th>E-Mail</th>
        <th>Alterar</th>
        <th>Remover</th>
    </tr>
    <?php
    foreach ($usuarios as $usuario) :
        ?>
        <tr>
            <td class="col-md-1"><?= $usuario->getEmail() ?></td>
            <td class="col-md-1">
                <a class="btn btn-primary" href="CtlUsuario.php?op=formAltera&id=<?= $usuario->getId() ?>">
                    alterar
                </a>
            </td> 
            <td class="col-md-1">
                <form action="CtlUsuario.php?op=remove" method="post">
                    <input type="hidden" name="id" value="<?= $usuario->getId() ?>">
                    <button class="btn btn-danger">remover</button>
                </form>
            </td>
        </tr>
        <?php
    endforeach
    ?>	
</table>        
<?php for($pagina=1;$pagina<=$qtdPaginas;$pagina++): ?>
<a href="CtlUsuario.php?op=listaComPaginacao&pagina=<?=$pagina?>&maxReg=2">
        <?=$pagina?>|
</a>
<?php endfor; ?>

<?php require_once("./rodape.php"); ?>