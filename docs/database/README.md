# Documentação do Banco de Dados

### Estrutura de Pasta
```
database/
┣ exports/
┃ ┗ old/
┗ READE.md
```

O Banco de dados utilizado no sistema deste projeto é 10.4.24-MariaDB, uma espécie de mysql gratuito.

### Nomenclatura
A nomenclatura para tabelas buscou seguir a ideia de tb_nome, visando padronizar e facilitar uso do banco de dados.

### Procedures, Triggers e Transactions
Dentre as procedures criadas, temos:

```sql
-- Procedure para registrar tempo de acesso de usuario.
DELIMITER $$
CREATE PROCEDURE SP_Registra_Acesso(IN email VARCHAR(255))
BEGIN
	INSERT INTO tb_logs_login (email, data_horario_acesso)
    VALUES (email, NOW());
END $$
DELIMITER ;
```

```sql
-- Procedure para registrar atualizacao de estoque no atributo de preco_unitario.
DELIMITER $$
CREATE PROCEDURE SP_Registra_Alteracao_Preco_Custo(IN id_estoque INT,IN preco_antigo DECIMAL(10,2))
BEGIN
    INSERT INTO tb_precos_compra (estoque_id, preco_unitario, data_atualizacao) 
    VALUES (id_estoque, preco_antigo, NOW());
END $$
DELIMITER ;


-- Procedure para registrar preco de venda ao atualizar de estoque.
delimiter $$
CREATE PROCEDURE SP_Registra_Preco_Venda(IN id_estoque INT, IN preco_venda DECIMAL(10,2))
BEGIN
	INSERT INTO tb_preco_venda (id_estoque, preco_venda, data_atualizacao)
    VALUES (id_estoque, preco_venda, NOW());
END $$
DELIMITER ;

```

```sql
--### Triggers

-- Chama trigger para registrar preco de compra na tb_compras
DELIMITER $$
CREATE TRIGGER TRG_Registra_Preco_Unitario BEFORE UPDATE 
ON tb_estoque
FOR EACH ROW
BEGIN
	IF OLD.preco_unitario <> NEW.preco_unitario THEN
    	CALL SP_Registra_Alteracao_Preco_Custo(OLD.id, OLD.preco_unitario);
    END IF;
END $$
DELIMITER ;

-- Chama trigger para registrar preco_venda na tabela precos_venda
DELIMITER $$
CREATE trigger TRG_Registra_Preco_Venda BEFORE UPDATE
ON tb_estoque
FOR EACH ROW
BEGIN
	IF OLD.preco_venda <> NEW.preco_venda THEN
    	CALL SP_Registra_Preco_Venda(OLD.id, OLD.preco_venda);
    END IF;
END $$
DELIMITER ;


-- Trigger acionada para verificar se ira deletar estoque
DROP TRIGGER IF EXISTS before_update_estoque;
DELIMITER $$

CREATE TRIGGER before_update_estoque
BEFORE UPDATE ON tb_estoque
FOR EACH ROW
BEGIN
    -- Evitar alteração do campo 'ativado' quando outros campos estão sendo atualizados
    IF OLD.preco_unitario = NEW.preco_unitario AND OLD.preco_venda = NEW.preco_venda THEN
        -- Verificar se o item de estoque está relacionado a agendamentos ativos
        IF EXISTS (
            SELECT 1
            FROM tb_agendamentos AS a
            JOIN tb_receitas AS r ON a.receita_id = r.id
            WHERE (r.produto_final_id = OLD.id OR r.ingrediente_id = OLD.id)
              AND a.status_id IN (SELECT id FROM tb_status WHERE descricao IN ('Em Andamento', 'Finalizado'))
        ) THEN
            -- Atualizar o atributo ativado para 0 (desativado) em vez de excluir
            SET NEW.ativado = 0;

            -- Definir uma mensagem de erro para o controle da aplicação
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Nao foi possivel desativar. Possivelmente existem agendamentos com este item de estoque.';
        END IF;
    END IF;
END$$

DELIMITER ;

```

```php
--### Transactions
    public function adicionarCliente($dados) {

    try{
        // Definindo a query de inserção
        $this->conexao->beginTransaction();

        $query = "INSERT INTO tb_clientes (nome, email, telefone) VALUES (:nome, :email, :telefone);";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(":nome", $dados['nome'], PDO::PARAM_STR);
        $stmt->bindParam(":email", $dados['email'], PDO::PARAM_STR);
        $stmt->bindParam(":telefone", $dados['telefone'], PDO::PARAM_STR);
        $stmt->execute();
        
        
        $cliente_id = $this->conexao->lastInsertId();
        $queryEndereco = "INSERT INTO tb_endereco (cep, rua, numero, cidade, estado, bairro, cliente_id) VALUES (:cep, :rua, :numero, :cidade, :estado, :bairro, :cliente_id);";
        $stmt = $this->conexao->prepare($queryEndereco);
                
        // Associando os parâmetros
        $stmt->bindParam(":cep", $dados['cep'], PDO::PARAM_STR);
        $stmt->bindParam(":rua", $dados['rua'], PDO::PARAM_STR);
        $stmt->bindParam(":numero", $dados['numero'], PDO::PARAM_STR);
        $stmt->bindParam(":cidade", $dados['cidade'], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $dados['estado'], PDO::PARAM_STR);
        $stmt->bindParam(":bairro", $dados['bairro'], PDO::PARAM_STR);
        $stmt->bindParam(":cliente_id", $cliente_id, PDO::PARAM_INT);
        
        // Executando a consulta
        if($stmt->execute()){
            $this->conexao->commit();
            return true;
        }
    }catch (Exception $e) {
            // Em caso de erro, reverte a transação
            $this->conexao->rollBack();
            throw new Exception("Erro ao cadastrar cliente e endereço: " . $e->getMessage());
        }
    }


     public function atualizarCliente($dados){
        // Iniciar transação
        $this->conexao->beginTransaction();
        try{
            $query = "UPDATE tb_clientes SET nome = :nome, email = :email, telefone = :telefone WHERE id = :id_cliente;";
            $stmt_cliente = $this->conexao->prepare($query);
            $stmt_cliente->bindParam(":nome", $dados['nome'], PDO::PARAM_STR);
            $stmt_cliente->bindParam(":email", $dados['email'], PDO::PARAM_STR);
            $stmt_cliente->bindParam(":telefone", $dados['telefone'], PDO::PARAM_STR);
            $stmt_cliente->bindParam(":id_cliente", $dados['id_cliente'], PDO::PARAM_INT);
            $stmt_cliente->execute();
            
            // Atualizar a tabela tb_endereco
            $queryendereco = " UPDATE tb_endereco SET cep = :cep, rua = :rua, numero = :numero, cidade = :cidade, estado = :estado, bairro = :bairro WHERE cliente_id = :id_cliente";
            $stmtendereco = $this->conexao->prepare($queryendereco);
            $stmtendereco->bindParam(":cep", $dados['cep'], PDO::PARAM_STR);
            $stmtendereco->bindParam(":rua", $dados['rua'], PDO::PARAM_STR);
            $stmtendereco->bindParam(":numero", $dados['numero'], PDO::PARAM_STR);
            $stmtendereco->bindParam(":cidade", $dados['cidade'], PDO::PARAM_STR);
            $stmtendereco->bindParam(":estado", $dados['estado'], PDO::PARAM_STR);
            $stmtendereco->bindParam(":bairro", $dados['bairro'], PDO::PARAM_STR);
            $stmtendereco->bindParam(":id_cliente", $dados['id_cliente'], PDO::PARAM_INT);
            $stmtendereco->execute();

            // Commit da transação
            $this->conexao->commit();

            // Retorna true se as duas instruções executaram corretamente
            return true;
        }catch (Exception $e) {
            // Em caso de erro, realiza o rollback
            $this->conexao->rollBack();
            // Exibe a mensagem de erro para depuração (pode remover ou registrar em produção)
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }
```
