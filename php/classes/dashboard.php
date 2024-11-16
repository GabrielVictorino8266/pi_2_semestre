<?php
require_once __DIR__ . '/conexao.php';

class Dashboard{
    private $conexao;


    public function __construct(){
        $conexao = new Conexao();
        $this->conexao = $conexao->getConexao();
    }

    public function pesquisarDashboard($inicioDaSemana, $fimDaSemana, $inicio, $limite, $nome_cliente, $status_id){
        /*
        Método usado para consultar agendamentos por meio da pesquisa.
        */
        try{
            $query = "SELECT ag.data_retirada, es.descricao as 'produto', cl.nome as 'nome_cliente', st.descricao as 'status' FROM tb_agendamentos ag
                INNER JOIN tb_clientes cl ON ag.cliente_id = cl.id
                INNER JOIN tb_receitas re ON ag.receita_id = re.id 
                INNER JOIN tb_estoque es on re.produto_final_id = es.id
                INNER JOIN tb_status st on ag.status_id = st.id
                WHERE data_retirada BETWEEN :inicioDaSemana AND :fimDaSemana AND cl.nome LIKE :nome_cliente";
                if(isset($status_id) && $status_id != ""){
                    $query .= " AND status_id = :status_id";
                }
                $query .=" ORDER BY data_retirada ASC LIMIT :inicio, :limite";
                
            $nome_cliente = "%".$nome_cliente."%";

            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(":inicioDaSemana", $inicioDaSemana, PDO::PARAM_STR);
            $stmt->bindParam(":fimDaSemana", $fimDaSemana, PDO::PARAM_STR);
            $stmt->bindParam(":nome_cliente", $nome_cliente, PDO::PARAM_STR);
            $stmt->bindParam(":inicio", $inicio, PDO::PARAM_INT);
            $stmt->bindParam(":limite", $limite, PDO::PARAM_INT);
            if(isset($status_id) && $status_id != ""){
                $stmt->bindParam(":status_id", $status_id, PDO::PARAM_INT);
            }
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


    public function getTotalPesquisarDashboard($inicioDaSemana, $fimDaSemana, $nome_cliente, $status_id){
        /*
        Método usado para consultar agendamentos por meio da pesquisa.
        */
        try{
            $query = "SELECT COUNT(*) as total FROM tb_agendamentos ag
                LEFT JOIN tb_clientes cl ON ag.cliente_id = cl.id
                LEFT JOIN tb_receitas re ON ag.receita_id = re.id 
                LEFT JOIN tb_estoque es ON re.produto_final_id = es.id
                LEFT JOIN tb_status st ON ag.status_id = st.id
                WHERE data_retirada BETWEEN :inicioDaSemana AND :fimDaSemana AND cl.nome LIKE :nome_cliente";
                if(isset($status_id) && $status_id != ""){
                    $query .= " AND status_id = :status_id";
                }
                $query .=" ORDER BY data_retirada ASC";

            $nome_cliente = "%".$nome_cliente."%";
            // var_dump($query);
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(":inicioDaSemana", $inicioDaSemana, PDO::PARAM_STR);
            $stmt->bindParam(":fimDaSemana", $fimDaSemana, PDO::PARAM_STR);
            $stmt->bindParam(":nome_cliente", $nome_cliente, PDO::PARAM_STR);
             if(isset($status_id) && $status_id != ""){
                $stmt->bindParam(":status_id", $status_id, PDO::PARAM_INT);
            }
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

    public function getTodosStatus(){
        /*
        Método usado para retornar todos os status de agendamento.
        */
        try{
            $query = "SELECT * FROM tb_status";
            $stmt = $this->conexao->prepare($query);
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

}