# Documentação de Banco de Dados

O Banco de dados utilizado no sistema deste projeto é  10.4.24-MariaDB, uma espécie de mysql gratuito.

### Nomenclatura
A nomenclatura para tabelas buscou seguir a ideia de tb_nome, visando padronizar e facilitar uso do banco de dados.

### Procedures
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

--### Triggers

-- Chama procedure para inserir preco na tb_precos_compra
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

-- Chama procedure para inserir preco na tb_precos_compra
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
```