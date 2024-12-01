<?php
require_once __DIR__ . '/conexao.php';

class Estoque{
    private $conexao;


    public function __construct()
    {
        $conexao = new Conexao();
        $this->conexao = $conexao->getConexao();
    }

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
    

    public function deletarEstoque($id){
        try {
            // Atualiza o campo 'ativado' para 0 (desativado) no estoque
            $query = "UPDATE tb_estoque SET ativado = 0 WHERE id = :id_item";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(":id_item", $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                // Sucesso na atualização
                $response = [
                    "success" => true,
                    "message" => "Deletado com sucesso. O item foi desativado."
                ];
            } else {
                // Caso a execução da query falhe, mas a operacao funcionou
                $response = [
                    "success" => false,
                    "message" => "Erro ao desativar o item. Tente novamente."
                ];
            }
        } catch (PDOException $e) {
            // Verifica se o erro é relacionado à trigger de banco
            if ($e->getCode() == '45000') { // Código de erro da trigger
                $cleanedMessage = preg_replace('/SQLSTATE\[\d+\]: <<Unknown error>>: \d+ /', '', $e->getMessage()); // Remove o que nao e texto para exibicao
                $response = [
                    "success" => false,
                    "message" => $cleanedMessage  // Mensagem personalizada da trigger
                ];
            } else {
                // Outros erros
                $response = [
                    "success" => false,
                    "message" => "Erro inesperado: " . $e->getMessage()
                ];
            }
        }
        return $response;
    }

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

    public function getPesquisarEstoque($inicio, $limite, $tipo_pesquisa, $nome_pesquisa, $categoria_pesquisa){
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