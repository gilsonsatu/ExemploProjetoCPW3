<?php   

class DaoCliente {

    private $conexao;
    private $totalRegistrosDaLista=0;
    
    function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function insere(Cliente $cliente){
        $sql = "insert into cliente(nome, email, cpf, endereco_id) values (?,?,?,?)";   //sql
        $sqlprep = $this->conexao->prepare($sql);                                       //prepara sql
        $sqlprep->bind_param("sssi",
                                $cliente->getNome(), 
                                $cliente->getEmail(), 
                                $cliente->getCpf(),
                                $cliente->getEndereco()->getId()
                            );                                                          //atribui valores parametros sql
        $sqlprep->execute();                                                            //executa sql
    }
    
    public function altera(Cliente $cliente) {
        $sql = "update cliente set nome=?,email=?,cpf=?,endereco_id=? where id=?";       //string sql 
        $sqlprep = $this->conexao->prepare($sql);                                       //preparação do sql
        $sqlprep->bind_param("sssii",
                                $cliente->getNome(), 
                                $cliente->getEmail(), 
                                $cliente->getCpf(),
                                $cliente->getEndereco()->getId(),
                                $cliente->getId()
                            );                                                          //atribui valores parametros sql
        $sqlprep->execute();                                                            //executa a instrução SQL
    }
    
    public function remove($id) {
        $sql = "delete from cliente where id=?";
        $sqlpreparado = $this->conexao->prepare($sql);                                  //preparação do sql
        $sqlpreparado->bind_param('i', $id);                                            //atribuindo valores para os parâmetros do SQL
        $sqlpreparado->execute();                                                       //executa a instrução SQL        
    }
    
    public function getLista() {
        $vetorLista = array();                                                          //cria o vetor
        $sql = "select c.*, e.rua, e.bairro, e.cidade, e.estado, e.cep from cliente c
                join endereco e on e.id = c.endereco_id";                              
        $registros = mysqli_query($this->conexao, $sql);                                //executa sql e salva resultado
        $registro = mysqli_fetch_assoc($registros);                                     //pegar o primeiro registro
        while ($registro != null) {                                                     //repete se variavel diferente de nula
            $endereco = new Endereco(   $registro["endereco_id"], 
                                        $registro["rua"], 
                                        $registro["bairro"], 
                                        $registro["cidade"],
                                        $registro["estado"],
                                        $registro["cep"]);
            
            $cliente = new Cliente(     $registro["id"], 
                                        $registro["nome"], 
                                        $endereco, 
                                        $registro["email"]);
            
            $cliente->setCpf($registro["cpf"]);
            array_push($vetorLista, $cliente);                                          // adiciona objeto no vetor
            $registro = mysqli_fetch_assoc($registros);                                 //pegar o próximo registro
        }
        return $vetorLista;                                                             //retorna lista
    }
    
    public function getListaComPaginacao($pagina, $maxRegPag) {
        $vetorLista = array();                                                          //cria o vetor
        $inicioLimit = ($pagina*$maxRegPag)-$maxRegPag;
        $sql = "select c.*, e.rua, e.bairro, e.cidade, e.estado, e.cep from cliente c
                join endereco e on e.id = c.endereco_id";
        $this->calculaTotalRegistros($sql);
        $sql = $sql." limit {$inicioLimit}, {$maxRegPag}";                              
        $registros = mysqli_query($this->conexao, $sql);                                //executa sql e salva resultado
        $registro = mysqli_fetch_assoc($registros);                                     //pegar o primeiro registro
        while ($registro != null) {                                                     //repete se variavel diferente de nula
            $endereco = new Endereco(   $registro["endereco_id"], 
                                        $registro["rua"], 
                                        $registro["bairro"], 
                                        $registro["cidade"],
                                        $registro["estado"],
                                        $registro["cep"]);
            
            $cliente = new Cliente(     $registro["id"], 
                                        $registro["nome"], 
                                        $endereco, 
                                        $registro["email"]);
            
            $cliente->setCpf($registro["cpf"]);
            array_push($vetorLista, $cliente);                                          // adiciona objeto no vetor
            $registro = mysqli_fetch_assoc($registros);                                 //pegar o próximo registro
        }
        return $vetorLista;                                                             //retorna lista
    }    
    
    private function calculaTotalRegistros($sql){
        $registros = mysqli_query($this->conexao, $sql);
        $this->setTotalRegistrosDaLista(mysqli_num_rows($registros));
    }
    
    public function getPorId($id) {
        $sql = "select c.*, e.rua, e.bairro, e.cidade, e.estado, e.cep from cliente c
                join endereco e on e.id = c.endereco_id where c.id=?";                              
        $sqlprep = $this->conexao->prepare($sql);                                       //preparação do sql
        $sqlprep->bind_param('i', $id);                                                 //atribuindo valores para os parâmetros do SQL
        $sqlprep->execute();                                                            // executa sql e guarda o resultado do select
        $registro = $sqlprep->get_result()->fetch_assoc();
        $endereco = new Endereco(   $registro["endereco_id"], 
                                    $registro["rua"], 
                                    $registro["bairro"], 
                                    $registro["cidade"],
                                    $registro["estado"],
                                    $registro["cep"]);
            
        $cliente = new Cliente(     $registro["id"], 
                                    $registro["nome"], 
                                    $endereco, 
                                    $registro["email"]);
        $cliente->setCpf($registro["cpf"]);        
        return $cliente;                                                                //retorna objeto
    }

    function getTotalRegistrosDaLista() {
        return $this->totalRegistrosDaLista;
    }

    function setTotalRegistrosDaLista($totalRegistrosDoLista) {
        $this->totalRegistrosDaLista = $totalRegistrosDoLista;
    }


    
}    

