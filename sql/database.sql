CREATE DATABASE rotisdb;
USE rotisdb;


CREATE TABLE IF NOT EXISTS tb_funcoes(
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS tb_usuarios(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    fk_funcao_id INT NOT NULL,
    FOREIGN KEY fk_funcao_id REFERENCES tb_funcoes(id)

);