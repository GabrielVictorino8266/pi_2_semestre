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

### Triggers