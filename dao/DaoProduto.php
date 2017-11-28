<?php   

class DaoProduto {

    private $conexao;
    
    function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function insere(Produto $produto){
        $sql = "insert into produto(nome, descricao, preco) values (?,?,?)";   //sql
        $sqlprep = $this->conexao->prepare($sql);                                       //prepara sql
        $sqlprep->bind_param("ssd",
                                $produto->getNome(), 
                                $produto->getDescricao(),
                                $produto->getPreco()
                            );                                                          //atribui valores parametros sql
        $sqlprep->execute();                                                            //executa sql
    }
    
    public function altera(Produto $produto) {
        $sql = "update produto set nome=?,descricao=?,preco=? where id=?";       //string sql 
        $sqlprep = $this->conexao->prepare($sql);                                       //preparação do sql
        $sqlprep->bind_param("ssdi",
                                $produto->getNome(), 
                                $produto->getDescricao(),
                                $produto->getPreco(),
                                $produto->getId()
                            );                                                          //atribui valores parametros sql
        $sqlprep->execute();                                                            //executa a instrução SQL
    }
    
    public function remove($id) {
        $sql = "delete from produto where id=?";
        $sqlpreparado = $this->conexao->prepare($sql);                                  //preparação do sql
        $sqlpreparado->bind_param('i', $id);                                            //atribuindo valores para os parâmetros do SQL
        $sqlpreparado->execute();                                                       //executa a instrução SQL        
    }
    
    public function getLista() {
        $vetorLista = array();                                                          //cria o vetor
        $sql = "select * from produto";                              
        $registros = mysqli_query($this->conexao, $sql);                                //executa sql e salva resultado
        $registro = mysqli_fetch_assoc($registros);                                     //pegar o primeiro registro
        while ($registro != null) {                                                     //repete se variavel diferente de nula
            $produto = new Produto(     $registro["id"], 
                                        $registro["nome"], 
                                        $registro["descricao"],
                                        $registro["preco"]);
            array_push($vetorLista, $produto);                                          // adiciona objeto no vetor
            $registro = mysqli_fetch_assoc($registros);                                 //pegar o próximo registro
        }
        return $vetorLista;                                                             //retorna lista
    }
    
    public function getPorId($id) {
        $sql = "select * from produto where id=?";                              
        $sqlprep = $this->conexao->prepare($sql);                                       //preparação do sql
        $sqlprep->bind_param('i', $id);                                                 //atribuindo valores para os parâmetros do SQL
        $sqlprep->execute();                                                            // executa sql e guarda o resultado do select
        $registro = $sqlprep->get_result()->fetch_assoc();
        $produto = new Produto(     $registro["id"], 
                                        $registro["nome"], 
                                        $registro["descricao"],
                                        $registro["preco"]);
        return $produto;                                                                //retorna objeto
    }

   
    
}    

