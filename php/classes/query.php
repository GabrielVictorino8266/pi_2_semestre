<?php
require_once __DIR__ . './conexao.php';

class Query{
    private $conexao;

    public function __construct(Conexao $conexao){
        $this->conexao = $conexao->getConexao();
    }

    public function verificaEmailUsuario($email){
        /*
        Método usado para consultar apenas o email do usuario
        buscando retornar se este existe.
        */
        $query = "SELECT * FROM tb_usuarios WHERE email = :email";
        $stmt = $this->conexao->prepare($query);

        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();

        #Verificacao se o usuario foi encontrado
        if($stmt->rowCount() > 0){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }

    public function registarUsuario($nome, $email, $senha, $funcao_id){
        /*  
        Método usadao para registrar o usuario.
        */
        $query = "INSERT INTO tb_usuarios (nome, email, senha, funcao_id) VALUES (:nome, :email, :senha, :funcao_id)";

        try{
            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":senha", $senha, PDO::PARAM_STR);
            $stmt->bindParam(":funcao_id", $funcao_id, PDO::PARAM_INT);

            $stmt->execute();
            return true;

        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }

    }


    public function getFuncao($funcao){
        /*
        Método usado para retornar o id da função do usuário,
        buscando pela descricao da funcao.
        */
        try{
            $query = "SELECT * FROM tb_funcoes WHERE descricao = :funcao";
            $stmt = $this->conexao->prepare($query);
    
            $stmt->bindParam(":funcao", $funcao, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }

    }

    public function getFuncaoUsuarioId($id){
        /*
        Método usado para retornar o id da função do usuário,
        buscando pelo id do usuário.
        */
        try{
            $query = "SELECT * FROM tb_usuarios INNER JOIN tb_funcoes ON tb_usuarios.funcao_id = tb_funcoes.id WHERE tb_usuarios.id = :id";
            $stmt = $this->conexao->prepare($query);
    
            $stmt->bindParam(":id", $id, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }

    }

    public function getAgendamentosDashboard($inicioDaSemana, $fimDaSemana, $inicio, $limite){
        /*
        Método usado para consultar agendamentos 
        e retornar um array dos agendamentos da semana.
        */
        try{
            $query = "SELECT ag.data_retirada, es.descricao as 'produto', cl.nome as 'nome_cliente', st.descricao as 'status' FROM tb_agendamentos ag
                INNER JOIN tb_clientes cl ON ag.cliente_id = cl.id
                INNER JOIN tb_receitas re ON ag.receita_id = re.id 
                INNER JOIN tb_estoque es on re.produto_final_id = es.id
                INNER JOIN tb_status st on ag.status_id = st.id
                WHERE data_retirada BETWEEN :inicioDaSemana AND :fimDaSemana AND status_id = 2
                ORDER BY data_retirada ASC LIMIT :inicio, :limite";    # Status 2, indica EM ANDAMENTO

            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(":inicioDaSemana", $inicioDaSemana, PDO::PARAM_STR);
            $stmt->bindParam(":fimDaSemana", $fimDaSemana, PDO::PARAM_STR);
            $stmt->bindParam(":inicio", $inicio, PDO::PARAM_INT);
            $stmt->bindParam(":limite", $limite, PDO::PARAM_INT);
            // var_dump($stmt);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return false;
            }
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    public function getTotalAgendamentosDashboard($inicioDaSemana, $fimDaSemana){
        /*
        Método usado para consultar agendamentos 
        e retornar um array dos agendamentos da semana.
        */
        try{
            $query = "SELECT COUNT(*) as 'total' FROM tb_agendamentos ag
                INNER JOIN tb_clientes cl ON ag.cliente_id = cl.id
                INNER JOIN tb_receitas re ON ag.receita_id = re.id 
                INNER JOIN tb_estoque es on re.produto_final_id = es.id
                INNER JOIN tb_status st on ag.status_id = st.id
                WHERE data_retirada BETWEEN :inicioDaSemana AND :fimDaSemana AND status_id = 2
                ORDER BY data_retirada ASC";    # Status 2, indica EM ANDAMENTO

            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(":inicioDaSemana", $inicioDaSemana, PDO::PARAM_STR);
            $stmt->bindParam(":fimDaSemana", $fimDaSemana, PDO::PARAM_STR);
            // var_dump($stmt);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }else{
                return false;
            }
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }
}
?>