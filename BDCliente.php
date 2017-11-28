<?php
    function insereClienteComObjeto($conexao, Cliente $cliente) {
        $sql = "insert into cliente(nome, cpf, email) values(?,?,?)";
        $sqlprep = $conexao->prepare($sql);
        $nome = $cliente->getNome(); $cpf = $cliente->getCpf(); $email = $cliente->getEmail();        
        $sqlprep->bind_param("sss", $nome, $cpf, $email);
        $sqlprep->execute();
    }


