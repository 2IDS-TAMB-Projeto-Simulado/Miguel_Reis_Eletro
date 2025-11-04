CREATE DATABASE IF NOT EXISTS ELETRODOMESTICO_SAEP_DB;
USE ELETRODOMESTICO_SAEP_DB;

CREATE TABLE USUARIO (
    USU_ID INTEGER AUTO_INCREMENT PRIMARY KEY,
    USU_NOME VARCHAR(255),
    USU_EMAIL VARCHAR(255),
    USU_SENHA VARCHAR(255)
);

CREATE TABLE PRODUTO (
    PROD_ID INTEGER AUTO_INCREMENT PRIMARY KEY,
    PROD_NOME VARCHAR(255),
    PROD_DESCRICAO VARCHAR(255),
    PROD_CATEGORIA VARCHAR(255),
    FK_USU_ID INTEGER,
    PROD_CONSUMO_ENERGETICO VARCHAR(50),
    PROD_GARANTIA VARCHAR(100),
    PROD_PRIORIDADE_REPOSICAO VARCHAR(100),
    CONSTRAINT FK_PRODUTO_USUARIO FOREIGN KEY (FK_USU_ID)
        REFERENCES USUARIO (USU_ID)
);

CREATE TABLE ESTOQUE (
    EST_ID INTEGER AUTO_INCREMENT PRIMARY KEY,
    EST_QUANTIDADE INTEGER,
    EST_FORNECEDOR VARCHAR(255),
    EST_LIMITE_ALERTA INTEGER,
    FK_PROD_ID INTEGER,
    CONSTRAINT FK_ESTOQUE_PRODUTO FOREIGN KEY (FK_PROD_ID)
        REFERENCES PRODUTO (PROD_ID)
);

CREATE TABLE LOGS (
    LOG_ID INTEGER AUTO_INCREMENT PRIMARY KEY,
    LOG_DESCRICAO VARCHAR(255),
    LOG_DATA_HORA DATE
);

INSERT INTO USUARIO (USU_NOME, USU_EMAIL, USU_SENHA)
VALUES 
('Miguel Reis', 'miguel@saep.com', '12345678'),
('Julia Ramos', 'julia@saep.com', 'admin123'),
('Caua Reis', 'caua@saep.com', '12345678');

INSERT INTO PRODUTO (
    PROD_NOME, 
    PROD_DESCRICAO, 
    PROD_CATEGORIA, 
    FK_USU_ID, 
    PROD_CONSUMO_ENERGETICO, 
    PROD_GARANTIA, 
    PROD_PRIORIDADE_REPOSICAO
)
VALUES 
('Geladeira Frost Free 400L', 'Geladeira com tecnologia frost free, baixo consumo', 'Eletrodoméstico Grande', 1, 'A++', '12 meses', 'Alta'),
('Micro-ondas 30L', 'Micro-ondas digital com grill e descongelamento rápido', 'Eletrodoméstico Médio', 1, 'A+', '12 meses', 'Média'),
('Liquidificador Turbo 1200W', 'Liquidificador com 12 velocidades e copo reforçado', 'Pequeno Eletrodoméstico', 2, 'A', '6 meses', 'Baixa');


INSERT INTO ESTOQUE (
    EST_QUANTIDADE,
    EST_FORNECEDOR,
    EST_LIMITE_ALERTA,
    FK_PROD_ID
)
VALUES
(100, 'EletroBrasil Distribuidora', 50, 1),
(100, 'Comercial TechPlus', 50, 2),
(100, 'Lar & Cia Fornecimentos', 50, 3);


INSERT INTO LOGS (LOG_DESCRICAO, LOG_DATA_HORA)
VALUES
('Usuário Miguel Reis cadastrou Geladeira Frost Free 400L', '2025-11-04'),
('Usuário Julia Ramos atualizou estoque do Micro-ondas 30L', '2025-11-04'),
('Sistema gerou alerta de baixo estoque para Geladeira Frost Free 400L', '2025-11-04');
select * from logs;