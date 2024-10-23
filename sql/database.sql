CREATE DATABASE rotisdb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE rotisdb;


CREATE TABLE IF NOT EXISTS tb_funcoes(
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS tb_usuarios(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    fk_funcao_id INT NOT NULL,
    FOREIGN KEY (fk_funcao_id) REFERENCES tb_funcoes(id)
);


CREATE TABLE IF NOT EXISTS tb_permissoes(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao VARCHAR(255) NOT NULL
);


CREATE TABLE IF NOT EXISTS tb_permissoes_funcoes(
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    fk_id_permissao INT NOT NULL,
    fk_id_funcao INT NOT NULL,
    FOREIGN KEY (fk_id_permissao) REFERENCES tb_permissoes(fk_id_permissao),
    FOREIGN KEY (fk_id_funcao) REFERENCES tb_funcoes(fk_id_funcao)
);


-- CREATE TABLE IF NOT EXISTS tb_clientes_telefone(
--     id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
--     fk_id_cliente INT NOT NULL,
--     telefone VARCHAR(255) NOT NULL,
--     FOREIGN KEY (fk_id_cliente) REFERENCES tb_clientes(id)
-- );


CREATE TABLE IF NOT EXISTS tb_endereco(
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    rua VARCHAR(255) NOT NULL,
    numero VARCHAR(10) NOT NULL,
    bairro VARCHAR(100) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    estado VARCHAR(2) NOT NULL,
    cep VARCHAR(10) NOT NULL
    fk_id_cliente INT NOT NULL,
    FOREIGN KEY (fk_id_cliente) REFERENCES tb_clientes(id)
);

CREATE TABLE IF NOT EXISTS_clientes(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    telefone VARCHAR(255) NOT NULL,--estudar possiblidade de ter multiplos telefones
    FOREIGN KEY (fk_endereco_id) REFERENCES tb_endereco(id)
);



CREATE TABLE IF NOT EXISTS tb_agendamentos(
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    data_agendamento DATETIME NOT NULL,
    produto_final_id INT NOT NULL,
    cliente_id INT NOT NULL,
    status_id INT NOT NULL,
    FOREIGN KEY (status_id) REFERENCES tb_satus(id),
    FOREIGN KEY (cliente_id) REFERENCES tb_usuarios(id),
    FOREIGN KEY (produto_final_id) REFERENCES tb_usuarios(id)   
);



CREATE TABLE IF NOT EXISTS tb_satus(
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(50),
);

-- INSERT DE DADOS NO BANCO INICIAL
INSERT INTO tb_funcoes (descricao) VALUES ("Adminsitrador");
INSERT INTO tb_funcoes (descricao) VALUES ("Funcionário");
INSERT INTO tb_usuarios (nome, senha, fk_funcao_id) VALUES ('gabriel', 'gabriel2022', 1);