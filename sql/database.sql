CREATE DATABASE rotisdb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE rotisdb;


CREATE TABLE IF NOT EXISTS tb_funcoes(
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS tb_usuarios(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    funcao_id INT NOT NULL,
    FOREIGN KEY (funcao_id) REFERENCES tb_funcoes(id)
);


-- CREATE TABLE IF NOT EXISTS tb_permissoes(
--     id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
--     nome VARCHAR(255) NOT NULL,
--     descricao VARCHAR(255) NOT NULL
-- );


-- CREATE TABLE IF NOT EXISTS tb_permissoes_funcoes(
--     id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
--     fk_id_permissao INT NOT NULL,
--     fk_id_funcao INT NOT NULL,
--     FOREIGN KEY (fk_id_permissao) REFERENCES tb_permissoes(fk_id_permissao),
--     FOREIGN KEY (fk_id_funcao) REFERENCES tb_funcoes(fk_id_funcao)
-- );


CREATE TABLE IF NOT EXISTS tb_endereco(
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    rua VARCHAR(255) NOT NULL,
    numero VARCHAR(10) NOT NULL,
    bairro VARCHAR(100) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    estado VARCHAR(2) NOT NULL,
    cep VARCHAR(10) NOT NULL,
    cliente_id INT NOT NULL,
    FOREIGN KEY (cliente_id) REFERENCES tb_clientes(id)
);

CREATE TABLE IF NOT EXISTS tb_clientes(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    telefone VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS tb_status(
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(50),
    status_activated BOOLEAN NOT NULL
);

CREATE TABLE IF NOT EXISTS tb_agendamentos(
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    data_agendamento DATETIME NOT NULL,
    produto_final_id INT NOT NULL,
    cliente_id INT NOT NULL,
    status_id INT NOT NULL,
    data_retirada DATETIME,
    observacoes TEXT,
    FOREIGN KEY (status_id) REFERENCES tb_satus(id),
    FOREIGN KEY (cliente_id) REFERENCES tb_usuarios(id),
);


-- Especifica a Categoria: Massa, doce, etc...
CREATE TABLE IF NOT EXISTS tb_categorias(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(255) NOT NULL
);

-- Especifica o tipo de Item: Ingrediente, Produto Final, etc...
CREATE TABLE IF NOT EXISTS tb_tipoItem(
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS tb_estoque(
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(255) NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    preco_venda DECIMAL(10,2) NOT NULL,
    tipo_id INT NOT NULL,
    categoria_id INT NOT NULL,
    FOREIGN KEY (categoria_id) REFERENCES tb_categorias(id),
    FOREIGN KEY (tipo_id) REFERENCES tb_tipoItem(id)
);


-- Uso de trigger para quando update em preco de compra
CREATE TABLE IF NOT EXISTS tb_precos_compra(
    id INT AUTO_INCREMENT PRIMARY KEY,
    estoque_id INT NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    data_atualizacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (estoque_id) REFERENCES tb_estoque(id)
);


CREATE TABLE tb_receitas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_final_id INT NOT NULL,
    ingrediente_id INT NOT NULL,
    quantidade_necessaria DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (produto_final_id) REFERENCES tb_estoque(id),
    FOREIGN KEY (ingrediente_id) REFERENCES tb_estoque(id)
);



-- INSERT DE DADOS NO BANCO INICIAL
INSERT INTO tb_funcoes (descricao) VALUES ("Adminsitrador");
INSERT INTO tb_funcoes (descricao) VALUES ("Funcionário");
INSERT INTO tb_usuarios (nome, senha, fk_funcao_id) VALUES ('gabriel', 'gabriel2022', 1);

--INSERT DE TESTE NO BANCO DE DADOS PARA AGENDAMENTOS   

-- INSERINDO DADOS NA TABELA tb_funcoes
INSERT INTO tb_funcoes (descricao) VALUES ('Administrador');
INSERT INTO tb_funcoes (descricao) VALUES ('Funcionário');

-- INSERINDO DADOS NA TABELA tb_usuarios
INSERT INTO tb_usuarios (nome, email, senha, funcao_id) VALUES ('Gabriel Silva', 'gabriel.silva@email.com', 'gabriel', 1);
INSERT INTO tb_usuarios (nome, email, senha, funcao_id) VALUES ('Gustavo', 'gustavo@email.com', 'gustavo', 2);

-- INSERINDO DADOS NA TABELA tb_clientes
INSERT INTO tb_clientes (nome, email, telefone) VALUES ('João Pereira', 'joao.pereira@email.com', '11912345678');
INSERT INTO tb_clientes (nome, telefone) VALUES ('Ana Lima', '11987654321');

-- INSERINDO DADOS NA TABELA tb_endereco
INSERT INTO tb_endereco (rua, numero, bairro, cidade, estado, cep, cliente_id) VALUES ('Rua das Flores', '123', 'Centro', 'São Paulo', 'SP', '01001000', 1);
INSERT INTO tb_endereco (rua, numero, bairro, cidade, estado, cep, cliente_id) VALUES ('Avenida Brasil', '456', 'Jardim América', 'Rio de Janeiro', 'RJ', '21001000', 2);

-- INSERINDO DADOS NA TABELA tb_status
INSERT INTO tb_status (descricao, status_activated) VALUES ('Confirmado', TRUE);
INSERT INTO tb_status (descricao, status_activated) VALUES ('Em Andamento', TRUE);
INSERT INTO tb_status (descricao, status_activated) VALUES ('Cancelado', FALSE);

-- INSERINDO DADOS NA TABELA tb_agendamentos
INSERT INTO tb_agendamentos (data_agendamento, produto_final_id, cliente_id, status_id) VALUES ('2024-11-01 10:00:00', 1, 1, 1);
INSERT INTO tb_agendamentos (data_agendamento, produto_final_id, cliente_id, status_id) VALUES ('2024-11-02 15:30:00', 2, 2, 2);

-- INSERINDO DADOS NA TABELA tb_tipoItem
INSERT INTO tb_tipoItem(tipo) VALUES('Ingrediente');
INSERT INTO tb_tipoItem(tipo) VALUES('Produto Final');
INSERT INTO tb_tipoItem(tipo) VALUES('Outros');