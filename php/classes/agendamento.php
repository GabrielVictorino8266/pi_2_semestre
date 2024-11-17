<?php
require_once __DIR__ . '/conexao.php';

class Agendamento{
    private $conexao;

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

    public function carregarInformacoesItem($id){
        $query = "SELECT ag.id as id_agendamento, DATE(ag.data_agendamento) as data_agendamento, ag.receita_id, ag.cliente_id, ag.status_id, ag.observacoes, DATE(ag.data_retirada) as data_retirada, ag.quantidade_receita, rec.id as id_receita, rec.quantidade_necessaria, rec.ingrediente_id, est.id as estoque_id, est.descricao as estoque_descricao, est.preco_venda, sta.id as id_status, sta.descricao as status_descricao, sta.status_activated, cli.id as id_cliente, cli.nome as nome_cliente, cli.email as email_cliente, cli.telefone as telefone_cliente
        FROM tb_agendamentos as ag inner join tb_receitas as rec on ag.receita_id = rec.id inner join tb_estoque as est on rec.produto_final_id = est.id inner join tb_status as sta on ag.status_id = sta.id 
        inner join tb_clientes as cli on ag.cliente_id = cli.id
        WHERE ag.id = :id_item";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(":id_item", $id, PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }
}