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
    FOREIGN KEY (fk_id_funcao) REFERENCES tb_funcoes(fk_id_funcao),
);



-- INSERT DE DADOS NO BANCO INICIAL
INSERT INTO tb_funcoes (descricao) VALUES ("Adminsitrador");
INSERT INTO tb_funcoes (descricao) VALUES ("Funcionário");
INSERT INTO tb_usuarios (nome, senha, fk_funcao_id) VALUES ('gabriel', 'gabriel2022', 1);