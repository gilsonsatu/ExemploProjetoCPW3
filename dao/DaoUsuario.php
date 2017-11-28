<?php   

class DaoUsuario {

    private $conexao;
    private $totalRegistrosDaLista=0;    
    
    function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function insere(Usuario $usuario){
        $sql = "insert into usuario(email, senha) values (?,?)";   //sql
        $sqlprep = $this->conexao->prepare($sql);                                       //prepara sql
        $sqlprep->bind_param("ss",
                                $usuario->getEmail(), 
                                $usuario->getSenha()
                            );                                                          //atribui valores parametros sql
        $sqlprep->execute();                                                            //executa sql
    }
    
    public function altera(Usuario $usuario) {
        $sql = "update usuario set email=?,senha=? where id=?";       //string sql 
        $sqlprep = $this->conexao->prepare($sql);                                       //preparação do sql
        $sqlprep->bind_param("ssi",
                                $usuario->getEmail(), 
                                $usuario->getSenha(),
                                $usuario->getId()
                            );                                                          //atribui valores parametros sql
        $sqlprep->execute();                                                            //executa a instrução SQL
    }
    
    public function remove($id) {
        $sql = "delete from usuario where id=?";
        $sqlpreparado = $this->conexao->prepare($sql);                                  //preparação do sql
        $sqlpreparado->bind_param('i', $id);                                            //atribuindo valores para os parâmetros do SQL
        $sqlpreparado->execute();                                                       //executa a instrução SQL        
    }
    
    public function getLista() {
        $vetorLista = array();                                                          //cria o vetor
        $sql = "select * from usuario";                              
        $registros = mysqli_query($this->conexao, $sql);                                //executa sql e salva resultado
        $registro = mysqli_fetch_assoc($registros);                                     //pegar o primeiro registro
        while ($registro != null) {                                                     //repete se variavel diferente de nula
            $usuario = new Usuario(     $registro["id"], 
                                        $registro["email"], 
                                        $registro["senha"]);
            array_push($vetorLista, $usuario);                                          // adiciona objeto no vetor
            $registro = mysqli_fetch_assoc($registros);                                 //pegar o próximo registro
        }
        return $vetorLista;                                                             //retorna lista
    }
    
    public function getListaComPaginacao($pagina, $maxRegPag) {
        $vetorLista = array(); 
        $inicioLimit = ($pagina*$maxRegPag)-$maxRegPag;

        $sql = "select * from usuario";                
        $this->calculaTotalRegistros($sql);
        $sql = $sql." limit {$inicioLimit}, {$maxRegPag}"; 
        
        $registros = mysqli_query($this->conexao, $sql);                                //executa sql e salva resultado
        $registro = mysqli_fetch_assoc($registros);                                     //pegar o primeiro registro
        while ($registro != null) {                                                     //repete se variavel diferente de nula
            $usuario = new Usuario(     $registro["id"], 
                                        $registro["email"], 
                                        $registro["senha"]);
            array_push($vetorLista, $usuario);                                          // adiciona objeto no vetor
            $registro = mysqli_fetch_assoc($registros);                                 //pegar o próximo registro
        }
        return $vetorLista;                                                             //retorna lista
    } 
    
    private function calculaTotalRegistros($sql){
        $registros = mysqli_query($this->conexao, $sql);
        $this->setTotalRegistrosDaLista(mysqli_num_rows($registros));
    }    
    
    
    
    public function getPorId($id) {
        $sql = "select * from usuario where id=?";                              
        $sqlprep = $this->conexao->prepare($sql);                                       //preparação do sql
        $sqlprep->bind_param('i', $id);                                                 //atribuindo valores para os parâmetros do SQL
        $sqlprep->execute();                                                            // executa sql e guarda o resultado do select
        $registro = $sqlprep->get_result()->fetch_assoc();
        $usuario = new Usuario(     $registro["id"], 
                                    $registro["email"], 
                                    $registro["senha"]);
        return $usuario;                                                                //retorna objeto
    }
    
    public function existe(Usuario $usuario) {
        $sql = "select * from usuario where email=? and senha=?";                              
        $sqlprep = $this->conexao->prepare($sql);                                       //preparação do sql
        $sqlprep->bind_param('ss', $usuario->getEmail(), $usuario->getSenha());                                                 //atribuindo valores para os parâmetros do SQL
        $sqlprep->execute();                                                            // executa sql e guarda o resultado do select
        $registro = $sqlprep->get_result()->fetch_assoc();
        if($registro==null) {
            return false;
        } else {
            return true;
        }
    }

    function getTotalRegistrosDaLista() {
        return $this->totalRegistrosDaLista;
    }

    function setTotalRegistrosDaLista($totalRegistrosDaLista) {
        $this->totalRegistrosDaLista = $totalRegistrosDaLista;
    }

   
    
}    

