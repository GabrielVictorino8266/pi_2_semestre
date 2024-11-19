<?php
require_once __DIR__ . '/conexao.php';

class Query{
    private $conexao;

    public function __construct(Conexao $conexao){
        $this->conexao = $conexao->getConexao();
    }

    // public function verificaEmailUsuario($email){
    //     /*
    //     Método usado para consultar apenas o email do usuario
    //     buscando retornar se este existe.
    //     */
    //     $query = "SELECT * FROM tb_usuarios WHERE email = :email";
    //     $stmt = $this->conexao->prepare($query);

    //     $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    //     $stmt->execute();

    //     #Verificacao se o usuario foi encontrado
    //     if($stmt->rowCount() > 0){
    //         return $stmt->fetch(PDO::FETCH_ASSOC);
    //     }else{
    //         return false;
    //     }
    // }

    // public function registarUsuario($nome, $email, $senha, $funcao_id){
    //     /*  
    //     Método usadao para registrar o usuario.
    //     */
    //     $query = "INSERT INTO tb_usuarios (nome, email, senha, funcao_id) VALUES (:nome, :email, :senha, :funcao_id)";

    //     try{
    //         $stmt = $this->conexao->prepare($query);

    //         $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
    //         $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    //         $stmt->bindParam(":senha", $senha, PDO::PARAM_STR);
    //         $stmt->bindParam(":funcao_id", $funcao_id, PDO::PARAM_INT);

    //         $stmt->execute();
    //         return true;

    //     }catch(PDOException $e){
    //         echo $e->getMessage();
    //         return false;
    //     }
    // }


    // public function getFuncao($funcao){
    //     /*
    //     Método usado para retornar o id da função do usuário,
    //     buscando pela descricao da funcao.
    //     */
    //     try{
    //         $query = "SELECT * FROM tb_funcoes WHERE descricao = :funcao";
    //         $stmt = $this->conexao->prepare($query);
    
    //         $stmt->bindParam(":funcao", $funcao, PDO::PARAM_STR);
    //         $stmt->execute();
    //         return $stmt->fetch(PDO::FETCH_ASSOC);
    //     }catch(PDOException $e){
    //         echo $e->getMessage();
    //         return false;
    //     }

    // }

    // public function getFuncaoUsuarioId($id){
    //     /*
    //     Método usado para retornar o id da função do usuário,
    //     buscando pelo id do usuário.
    //     */
    //     try{
    //         $query = "SELECT * FROM tb_usuarios INNER JOIN tb_funcoes ON tb_usuarios.funcao_id = tb_funcoes.id WHERE tb_usuarios.id = :id";
    //         $stmt = $this->conexao->prepare($query);
    
    //         $stmt->bindParam(":id", $id, PDO::PARAM_STR);
    //         $stmt->execute();
    //         return $stmt->fetch(PDO::FETCH_ASSOC);
    //     }catch(PDOException $e){
    //         echo $e->getMessage();
    //         return false;
    //     }

    // }

    // public function pesquisarDashboard($inicioDaSemana, $fimDaSemana, $inicio, $limite, $nome_cliente, $status_id){
    //     /*
    //     Método usado para consultar agendamentos por meio da pesquisa.
    //     */
    //     try{
    //         $query = "SELECT ag.data_retirada, es.descricao as 'produto', cl.nome as 'nome_cliente', st.descricao as 'status' FROM tb_agendamentos ag
    //             INNER JOIN tb_clientes cl ON ag.cliente_id = cl.id
    //             INNER JOIN tb_receitas re ON ag.receita_id = re.id 
    //             INNER JOIN tb_estoque es on re.produto_final_id = es.id
    //             INNER JOIN tb_status st on ag.status_id = st.id
    //             WHERE data_retirada BETWEEN :inicioDaSemana AND :fimDaSemana AND cl.nome LIKE :nome_cliente";
    //             if(isset($status_id) && $status_id != ""){
    //                 $query .= " AND status_id = :status_id";
    //             }
    //             $query .=" ORDER BY data_retirada ASC LIMIT :inicio, :limite";
                
    //         $nome_cliente = "%".$nome_cliente."%";
    //         // var_dump($query);
    //         $stmt = $this->conexao->prepare($query);
    //         $stmt->bindParam(":inicioDaSemana", $inicioDaSemana, PDO::PARAM_STR);
    //         $stmt->bindParam(":fimDaSemana", $fimDaSemana, PDO::PARAM_STR);
    //         $stmt->bindParam(":nome_cliente", $nome_cliente, PDO::PARAM_STR);
    //         $stmt->bindParam(":inicio", $inicio, PDO::PARAM_INT);
    //         $stmt->bindParam(":limite", $limite, PDO::PARAM_INT);
    //         if(isset($status_id) && $status_id != ""){
    //             $stmt->bindParam(":status_id", $status_id, PDO::PARAM_INT);
    //         }
    //         $stmt->execute();
    //         if($stmt->rowCount() > 0){
    //             return $stmt->fetchAll(PDO::FETCH_ASSOC);
    //         }else{
    //             return false;
    //         }
    //     }catch(PDOException $e){
    //         echo $e->getMessage();
    //         return false;
    //     }
    // }


    // public function getTotalPesquisarDashboard($inicioDaSemana, $fimDaSemana, $nome_cliente, $status_id){
    //     /*
    //     Método usado para consultar agendamentos por meio da pesquisa.
    //     */
    //     try{
    //         $query = "SELECT COUNT(*) as total FROM tb_agendamentos ag
    //             LEFT JOIN tb_clientes cl ON ag.cliente_id = cl.id
    //             LEFT JOIN tb_receitas re ON ag.receita_id = re.id 
    //             LEFT JOIN tb_estoque es ON re.produto_final_id = es.id
    //             LEFT JOIN tb_status st ON ag.status_id = st.id
    //             WHERE data_retirada BETWEEN :inicioDaSemana AND :fimDaSemana AND cl.nome LIKE :nome_cliente";
    //             if(isset($status_id) && $status_id != ""){
    //                 $query .= " AND status_id = :status_id";
    //             }
    //             $query .=" ORDER BY data_retirada ASC";

    //         $nome_cliente = "%".$nome_cliente."%";
    //         // var_dump($query);
    //         $stmt = $this->conexao->prepare($query);
    //         $stmt->bindParam(":inicioDaSemana", $inicioDaSemana, PDO::PARAM_STR);
    //         $stmt->bindParam(":fimDaSemana", $fimDaSemana, PDO::PARAM_STR);
    //         $stmt->bindParam(":nome_cliente", $nome_cliente, PDO::PARAM_STR);
    //          if(isset($status_id) && $status_id != ""){
    //             $stmt->bindParam(":status_id", $status_id, PDO::PARAM_INT);
    //         }
    //         $stmt->execute();
    //         if($stmt->rowCount() > 0){
    //             return $stmt->fetch(PDO::FETCH_ASSOC);
    //         }else{
    //             return false;
    //         }
    //     }catch(PDOException $e){
    //         echo $e->getMessage();
    //         return false;
    //     }
    // }

    // public function getTodosStatus(){
    //     /*
    //     Método usado para retornar todos os status de agendamento.
    //     */
    //     try{
    //         $query = "SELECT * FROM tb_status";
    //         $stmt = $this->conexao->prepare($query);
    //         $stmt->execute();
    //         if($stmt->rowCount() > 0){
    //             return $stmt->fetchAll(PDO::FETCH_ASSOC);
    //         }else{
    //             return false;
    //         }
    //     }catch(PDOException $e){
    //         echo $e->getMessage();
    //         return false;
    //     }
    // }

/***********ESTOQUE*********/

    public function listarEstoque($inicio, $limite){
        /*
        Query de listagem de todo o estoque.
        */
        $query = "SELECT * FROM tb_estoque
        LIMIT :inicio, :limite";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(":inicio", $inicio, PDO::PARAM_INT);
        $stmt->bindParam(":limite", $limite, PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return false;
       }
    }

    public function listarContagemEstoque(){
        /*
        Query de contagem de quantidade de registros do estoque.
        */
        $query = "SELECT COUNT(1) as total FROM tb_estoque";
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }else{
            return false;
       }
    }

    public function listarTipoItem(){
        /*
        Lista categorias para filtro de item.
        */
        $query = "SELECT * FROM tb_tipoitem";
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }
    public function listarCategoria(){
        /*
        Lista categorias para filtro de categoria.
        */
        $query = "SELECT * FROM tb_categorias";
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }

    public function carregarInformacoesItem($id){
        $query = "SELECT * FROM tb_estoque WHERE id = :id_item";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(":id_item", $id, PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }

    public function atualizarItem($id, $dados){
        $query = "UPDATE tb_estoque AS estoque 
        SET estoque.descricao = :descricao, estoque.quantidade = :quantidade,
        estoque.preco_unitario = :preco_unitario, estoque.preco_venda = :preco_venda,
        estoque.tipo_id = :tipo_id, estoque.categoria_id = :categoria_id, estoque.ativado = :ativado
        WHERE id = :id_item";

        // Converte os valores para float
        $preco_unitario = (float)$dados['preco_unitario'];
        $preco_venda = (float)$dados['preco_venda'];

        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(":id_item", $id, PDO::PARAM_INT);
        $stmt->bindParam(":descricao", $dados['descricao'], PDO::PARAM_STR);
        $stmt->bindParam(":quantidade", $dados['quantidade'], PDO::PARAM_INT);
        $stmt->bindParam(":preco_unitario", $preco_unitario, PDO::PARAM_STR);
        $stmt->bindParam(":preco_venda", $preco_venda, PDO::PARAM_STR);
        $stmt->bindParam(":tipo_id", $dados['tipo_id'], PDO::PARAM_INT);
        $stmt->bindParam(":categoria_id", $dados['categoria_id'], PDO::PARAM_INT);
        $stmt->bindParam(":ativado", $dados['ativado'], PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    // public function deletarProduto($id){
    //     $query = "DELETE FROM tb_estoque WHERE id = :id_item";
    //     $stmt = $this->conexao->prepare($query);
    //     $stmt->bindParam(":id_item", $id, PDO::PARAM_INT);
    //     $stmt->execute();
    //     if($stmt->rowCount() > 0){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }

    public function cadastrarProduto($dados){
        $query = "INSERT INTO tb_estoque (descricao, quantidade, preco_unitario, preco_venda, tipo_id, categoria_id, ativado) VALUES
        (:descricao, :quantidade, :preco_unitario, :preco_venda, :tipo_id,
        :categoria_id, :ativado)";

        // Converte os valores para float
        $preco_unitario = (float)$dados['preco_unitario'];
        $preco_venda = (float)$dados['preco_venda'];
        

        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':descricao', $dados['descricao'], PDO::PARAM_STR);
        $stmt->bindParam(':quantidade', $dados['quantidade'], PDO::PARAM_INT);
        $stmt->bindParam(':preco_unitario',  $preco_unitario);
        $stmt->bindParam(':preco_venda',  $preco_venda);
        $stmt->bindParam(':tipo_id', $dados['tipo_id'], PDO::PARAM_INT);
        $stmt->bindParam(':categoria_id', $dados['categoria_id'], PDO::PARAM_INT);
        $stmt->bindParam(':ativado', $dados['ativado'], PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    // public function getTotalEstoque($categoriaId) {
    //     $query = "SELECT COUNT(*) as total FROM produtos WHERE categoria_id = :categoria_id";
    //     $stmt = $this->conexao->prepare($query);
    //     $stmt->bindValue(':categoria_id', $categoriaId, PDO::PARAM_INT);
    //     $stmt->execute();
    //     if($stmt->rowCount() > 0){
    //         $stmt->fetch(PDO::FETCH_ASSOC);
    //     }else{
    //         return false;
    //     }
    // }


    public function getTotalEstoque($tipo_pesquisa, $nome_pesquisa, $categoria_pesquisa){
        /*
        */
        try{
            $query = "SELECT COUNT(*) as total FROM tb_estoque as et 
                INNER JOIN tb_tipoitem as ti ON et.tipo_id = ti.id
                INNER JOIN tb_categorias as ct ON  et.categoria_id = ct.id
                ";
            // Armazena condições e parâmetros para o SQL dinamicamente
            $conditions = [];
            $params = [];

            // Condicionalmente adiciona filtros
            if (!empty($tipo_pesquisa)) {
                $conditions[] = "et.tipo_id = :tipo_pesquisa";
                $params[':tipo_pesquisa'] = $tipo_pesquisa;
            }
            if (!empty($categoria_pesquisa)) {
                $conditions[] = "et.categoria_id = :categoria_pesquisa";
                $params[':categoria_pesquisa'] = $categoria_pesquisa;
            }
            if (!empty($nome_pesquisa)) {
                $conditions[] = "et.descricao LIKE :nome_pesquisa";
                $params[':nome_pesquisa'] = "%" . $nome_pesquisa . "%";
            }

            
            $conditions[] = "et.ativado = 1";
            // Concatena condições no SQL se houver alguma
            if (count($conditions) > 0) {
                $query .= " WHERE " . implode(" AND ", $conditions);
            }


            // Prepara a consulta SQL
            $stmt = $this->conexao->prepare($query);


            // Associa somente os parâmetros necessários
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            // Executa e retorna os resultados
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }
    
    public function getPesquisarEstoque($inicio, $limite, $tipo_pesquisa, $nome_pesquisa, $categoria_pesquisa) {
        try{
            $query = "SELECT et.* FROM tb_estoque as et 
                INNER JOIN tb_tipoitem as ti ON et.tipo_id = ti.id
                INNER JOIN tb_categorias as ct ON  et.categoria_id = ct.id
                ";
            // Armazena condições e parâmetros para o SQL dinamicamente
            $conditions = [];
            $params = [];

            // Condicionalmente adiciona filtros
            if (!empty($tipo_pesquisa)) {
                $conditions[] = "et.tipo_id = :tipo_pesquisa";
                $params[':tipo_pesquisa'] = $tipo_pesquisa;
            }
            if (!empty($categoria_pesquisa)) {
                $conditions[] = "et.categoria_id = :categoria_pesquisa";
                $params[':categoria_pesquisa'] = $categoria_pesquisa;
            }
            if (!empty($nome_pesquisa)) {
                $conditions[] = "et.descricao LIKE :nome_pesquisa";
                $params[':nome_pesquisa'] = "%" . $nome_pesquisa . "%";
            }

            $conditions[] = "et.ativado = 1";


            // Concatena condições no SQL se houver alguma
            if (count($conditions) > 0) {
                $query .= " WHERE " . implode(" AND ", $conditions);
            }
            
        // Adiciona LIMIT e OFFSET diretamente na query
        $query .= " ORDER BY et.id";
        $query .= " LIMIT " . (int)$limite . " OFFSET " . (int)$inicio;

        // Prepara a consulta SQL
        $stmt = $this->conexao->prepare($query);
        
        // Associa os parâmetros
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }

        // Executa e retorna os resultados
        $stmt->execute();
        // var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }    
}
?>