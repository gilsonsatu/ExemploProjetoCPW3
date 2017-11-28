<?php

class DaoPedido {

    private $conexao;

    function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function insere(Pedido $pedido) {
        $sql = "insert into pedido(idcliente, data, total, formaPgto) values (?,?,?,?)";
        $sqlprep = $this->conexao->prepare($sql);
        $sqlprep->bind_param("isss", 
                $pedido->getCliente()->getId(), 
                $pedido->getData(), 
                $pedido->getTotal(), 
                $pedido->getFormaPgto()
        );
        $sqlprep->execute();
    }

    public function altera(Pedido $pedido) {
        $sql = "update pedido set idcliente=?,data=?,total=?,formaPgto=? where id=?";       //string sql 
        $sqlprep = $this->conexao->prepare($sql);                                       //preparação do sql
        $sqlprep->bind_param("isdsi", 
                $pedido->getCliente()->getId(), 
                $pedido->getData(), 
                $pedido->getTotal(), 
                $pedido->getFormaPgto(), 
                $pedido->getId()
        );                                                          //atribui valores parametros sql
        $sqlprep->execute();                                                            //executa a instrução SQL
    }

    public function remove($id) {
        $sql = "delete from pedido where id=?";
        $sqlpreparado = $this->conexao->prepare($sql);                                  //preparação do sql
        $sqlpreparado->bind_param('i', $id);                                            //atribuindo valores para os parâmetros do SQL
        $sqlpreparado->execute();                                                       //executa a instrução SQL        
    }

    public function getLista() {
        $vetorLista = array();                                                          //cria o vetor
        $sql = "select p.*, c.nome, c.cpf, c.endereco_id, c.email, e.rua, e.bairro, e.cidade, e.estado, e.cep from pedido p
                join cliente c on c.id = p.idcliente
                join endereco e on c.endereco_id=e.id";
        $registros = mysqli_query($this->conexao, $sql);                                //executa sql e salva resultado
        $registro = mysqli_fetch_assoc($registros);                                     //pegar o primeiro registro
        while ($registro != null) {                                                     //repete se variavel diferente de nula
            $endereco = new Endereco($registro["endereco_id"], $registro["rua"], $registro["bairro"], $registro["cidade"], $registro["estado"], $registro["cep"]);

            $cliente = new Cliente($registro["id"], $registro["nome"], $endereco, $registro["email"]);
            
            $pedido = new Pedido($registro["id"], $cliente, $registro["data"], $registro["total"], $registro["formaPgto"]);

            array_push($vetorLista, $pedido);                                          // adiciona objeto no vetor
            $registro = mysqli_fetch_assoc($registros);                                 //pegar o próximo registro
        }
        return $vetorLista;                                                             //retorna lista
    }

    public function getPorId($id) {
        $sql = "select p.*, c.nome, c.cpf, c.endereco_id, c.email, e.rua, e.bairro, e.cidade, e.estado, e.cep from pedido p
                join cliente c on c.id = p.idcliente
                join endereco e on c.endereco_id=e.id where p.id=?";
        $sqlprep = $this->conexao->prepare($sql);                                       //preparação do sql
        $sqlprep->bind_param('i', $id);                                                 //atribuindo valores para os parâmetros do SQL
        $sqlprep->execute();                                                            // executa sql e guarda o resultado do select
        $registro = $sqlprep->get_result()->fetch_assoc();
        $endereco = new Endereco($registro["endereco_id"], $registro["rua"], $registro["bairro"], $registro["cidade"], $registro["estado"], $registro["cep"]);

        $cliente = new Cliente($registro["id"], $registro["nome"], $endereco, $registro["email"]);
        
        $pedido = new Pedido($registro["id"], $cliente, $registro["data"], $registro["total"], $registro["formaPgto"]);
        
        return $pedido;                                                                //retorna objeto
    }

}
