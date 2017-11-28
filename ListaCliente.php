<?php
require_once 'cabecalho.php';
?>	

<div class="row">
    <h1 class="col-md-11">Cliente</h1>
    <div class="col-md-1">
        <a href="CtlCliente.php?op=formInsere" class="btn btn-primary">Novo</a>
    </div>
</div>

<table class="table table-striped table-bordered">
    <?php
    foreach ($clientes as $cliente) :
        ?>
        <tr>
            <td>
            <?php if($cliente->getFoto()!=''): ?>
                <img src="<?=$cliente->getFoto(); ?>">
            <?php endif ?>
            </td>
            <td class="col-md-4"><?= $cliente->getNome() ?></td>
            <td class="col-md-2"><?= $cliente->getCpf() ?></td>
            <td class="col-md-2"><?= $cliente->getEmail() ?></td>
            <td class="col-md-1">
                <a class="btn btn-primary" href="CtlCliente.php?op=formAltera&id=<?= $cliente->getId() ?>">
                    alterar
                </a>
            </td> 
            <td class="col-md-1">
                <form action="CtlCliente.php?op=remove" method="post">
                    <input type="hidden" name="id" value="<?= $cliente->getId() ?>">
                    <button class="btn btn-danger">remover</button>
                </form>
            </td>
        </tr>
        <?php
    endforeach
    ?>	
</table>

<?php for($pagina=1;$pagina<=$qtdPaginas;$pagina++): ?>
<a href="CtlCliente.php?op=listaComPaginacao&pagina=<?=$pagina?>&maxReg=2">
        <?=$pagina?>|
</a>
<?php endfor; ?>

<?php require_once("./rodape.php"); ?>
