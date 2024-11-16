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
        $query = "SELECT * FROM tb_agendamentos
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
        // Adiciona LIMIT e OFFSET diretamente na query
        $query .= " ORDER BY tb_agendamentos.data_retirada ASC";
        $query .= " LIMIT " . (int)$inicio . ", " . (int)$limite_pagina;

        // Prepara e executa a consulta
        $stmt = $this->conexao->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, PDO::PARAM_STR);
        }

        $stmt->execute();

        if($stmt->rowCount() > 0){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return false;
        }

    }
}