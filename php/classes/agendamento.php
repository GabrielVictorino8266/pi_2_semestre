<?php
require_once __DIR__ . '/conexao.php';

class Agendamento{
    private $conexao;
    // private $data_agendamento;
    // private $receita_id;
    // private $cliente_id;
    // private $data_retirada;
    // private $status_id;

    public function __construct(){
        $conexao = new Conexao();
        $this->conexao = $conexao->getConexao();
    }

    public function getTotalAgendamentos($nome_cliente, $data_retirada_inicial){
        /*
        Método utilizado para contar o total de agendamentos COM BASE NOS FILTROS (SE APLICADOS).
        */
        $query = "SELECT count(*) as total FROM tb_agendamentos
        INNER JOIN tb_clientes ON tb_agendamentos.cliente_id = tb_clientes.id
        INNER JOIN tb_status on tb_agendamentos.status_id = tb_status.id";

        $conditions = []; // Armazena as condições do WHERE
        $params = [];     // Armazena os parâmetros para bind

        // Condição de filtro por data de retirada
        if (!empty($data_retirada_inicial)) {
            $conditions[] = "DATE(tb_agendamentos.data_retirada) = :data_retirada_inicial";
            $params[':data_retirada_inicial'] = $data_retirada_inicial;
        }

        // Condição de filtro por nome do cliente
        if (!empty($nome_cliente)) {
            $conditions[] = "tb_clientes.nome LIKE :nome_cliente";
            $params[':nome_cliente'] = "%" . $nome_cliente . "%";
        }

        // Adiciona condições ao SQL
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        // Prepara e executa a consulta
        $stmt = $this->conexao->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, PDO::PARAM_STR);
        }

        $stmt->execute();

        if($stmt->rowCount() > 0){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }else{
            return false;
        }

    }

    public function pesquisarAgendamentos($inicio,  $limite_pagina, $nome_cliente, $data_retirada_inicial){
        /*
        Método utilizado para contar o total de agendamentos COM BASE NOS FILTROS (SE APLICADOS).
        */
        $query = "SELECT ag.id as id_agendamento, ag.data_agendamento as data_agendamento, ag.receita_id, ag.cliente_id, ag.status_id, ag.observacoes, ag.data_retirada as data_retirada, ag.quantidade_receita, cli.id as id_cliente, cli.nome, cli.email, cli.telefone, sta.id, sta.descricao, sta.status_activated FROM tb_agendamentos as ag
        INNER JOIN tb_clientes as cli ON ag.cliente_id = cli.id
        INNER JOIN tb_status as sta on ag.status_id = sta.id";

        $conditions = []; // Armazena as condições do WHERE
        $params = [];     // Armazena os parâmetros para bind

        // Condição de filtro por data de retirada
        if (!empty($data_retirada_inicial)) {
            $conditions[] = "DATE(ag.data_retirada) = :data_retirada_inicial";
            $params[':data_retirada_inicial'] = $data_retirada_inicial;
        }

        // Condição de filtro por nome do cliente
        if (!empty($nome_cliente)) {
            $conditions[] = "cli.nome LIKE :nome_cliente";
            $params[':nome_cliente'] = "%" . $nome_cliente . "%";
        }

        
        // Adiciona condições ao SQL
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
        // Adiciona LIMIT e OFFSET diretamente na query
        $query .= " ORDER BY ag.data_retirada ASC";
        $query .= " LIMIT " . (int)$inicio . ", " . (int)$limite_pagina;

        // Prepara e executa a consulta
        $stmt = $this->conexao->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, PDO::PARAM_STR);
        }

        $stmt->execute();
        // var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));

        if($stmt->rowCount() > 0){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return false;
        }

    }

    public function getTodosStatus(){
        /*
        Lista status para camps de status.
        */
        $query = "SELECT * FROM tb_status";
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }
    public function getTodosProdutosFinais(){
        /*
        Lista receitas para campos de receitas.
        */
        $query = "SELECT estoque.id, estoque.descricao FROM tb_estoque AS estoque
        INNER JOIN tb_tipoitem AS tipo_item ON estoque.tipo_id = tipo_item.id
        WHERE tipo_item.tipo = 'Produto Final'
        ORDER BY estoque.descricao ASC;"; 
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }

    public function carregarInformacoesItem($id){
        $query = "SELECT ag.id as id_agendamento, ag.data_agendamento, ag.receita_id, ag.cliente_id, ag.status_id, ag.observacoes, ag.data_retirada as data_retirada, ag.quantidade_receita, cli.id as id_cliente, cli.nome as nome_cliente, cli.email as email_cliente, cli.telefone as telefone_cliente, sta.id as id_status, sta.descricao as status_descricao, sta.status_activated, est.id as estoque_id, est.descricao as estoque_descricao, est.preco_venda from tb_agendamentos as ag
        inner join tb_estoque as est on ag.receita_id = est.id
        inner join tb_clientes as cli on ag.cliente_id = cli.id
        inner join tb_status as sta on ag.status_id = sta.id
        where ag.id = :id_item";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(":id_item", $id, PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }

    public function cadastrarAgendamento($dados){
        $query = "INSERT INTO tb_agendamentos (data_agendamento, receita_id, cliente_id, status_id, observacoes, data_retirada, quantidade_receita) VALUES (:data_agendamento, :receita_id, :cliente_id, :status_id, :observacoes, :data_retirada, :quantidade_receita)";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(":data_agendamento", $dados['data_agendamento'], PDO::PARAM_STR);
        $stmt->bindParam(":receita_id", $dados['receita_id'], PDO::PARAM_INT);
        $stmt->bindParam(":cliente_id", $dados['cliente_id'], PDO::PARAM_INT);
        $stmt->bindParam(":status_id", $dados['status'], PDO::PARAM_INT);
        $stmt->bindParam(":observacoes", $dados['observacoes'], PDO::PARAM_STR);
        $stmt->bindParam(":data_retirada", $dados['data_retirada'], PDO::PARAM_STR);
        $stmt->bindParam(":quantidade_receita", $dados['quantidade_receita'], PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function atualizarAgendamento($dados){
        $query = "UPDATE tb_agendamentos SET data_agendamento = :data_agendamento, receita_id = :produto_final_id,status_id = :status_id, observacoes = :observacoes, data_retirada = :data_retirada, quantidade_receita = :quantidade_receita WHERE id = :id_agendamento";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(":data_agendamento", $dados['data_agendamento'], PDO::PARAM_STR);
        $stmt->bindParam(":produto_final_id", $dados['produto_final_id'], PDO::PARAM_INT);
        $stmt->bindParam(":status_id", $dados['status_id'], PDO::PARAM_INT);
        $stmt->bindParam(":observacoes", $dados['observacoes'], PDO::PARAM_STR);
        $stmt->bindParam(":data_retirada", $dados['data_retirada'], PDO::PARAM_STR);
        $stmt->bindParam(":quantidade_receita", $dados['quantidade_receita'], PDO::PARAM_INT);
        $stmt->bindParam(":id_agendamento", $dados['id_agendamento'], PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function consultaClientes($termo){
        /*
            Retorna uma lista de clientes para cadastro de agendamento,
            referente a cliente.
        */
        $query = "SELECT id, nome as nome_cliente FROM tb_clientes WHERE nome LIKE :termo LIMIT 10";
        $stmt = $this->conexao->prepare($query);
        if($termo){
            $termo = "%".$termo."%";
        }
        $stmt->bindParam(":termo", $termo, PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }
}