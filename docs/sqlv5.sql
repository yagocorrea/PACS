-- Geração de Modelo físico
-- Sql ANSI 2003 - brModelo.

CREATE TABLE endereco (
idendereco int AUTO_INCREMENT PRIMARY KEY,
cep varchar(15),
logradouro varchar(200),
bairro varchar(50),
municipio varchar(50),
estado varchar(15),
numerocasa int,
complemento varchar(50),
idclientes int
);

CREATE TABLE login (
idlogin int AUTO_INCREMENT PRIMARY KEY,
login varchar(200),
senha varchar(200),
status enum ('ativo','desativado'),
idfuncionarios int,
idclientes int,
idadm int
);

CREATE TABLE servicos (
idservicos int AUTO_INCREMENT PRIMARY KEY,
nome varchar(200),
valor varchar(50)
);

CREATE TABLE produtos (
idprodutos int AUTO_INCREMENT PRIMARY KEY,
nome varchar(200),
marca varchar(200),
valorbase varchar(50),
validade date,
tempodeusocliente time
);

CREATE TABLE clientes (
idclientes int AUTO_INCREMENT PRIMARY KEY,
nomecompleto varchar(200),
cpf varchar(15),
telefone varchar(15),
email varchar(50)
);

CREATE TABLE administrador (
idadm int AUTO_INCREMENT PRIMARY KEY,
nomecompleto varchar(200),
cpf varchar(15),
telefone varchar(10),
email varchar(50)
);

CREATE TABLE funcaofuncionario (
idfuncaofuncionario int AUTO_INCREMENT PRIMARY KEY,
nomefuncao enum ('recepcao','todos'),
idfuncionarios int
);

CREATE TABLE funcionarios (
idfuncionarios int AUTO_INCREMENT PRIMARY KEY,
nomecompleto varchar(200),
cpf varchar(15),
telefone varchar(15),
email varchar(50)
);

ALTER TABLE endereco ADD FOREIGN KEY(idclientes) REFERENCES clientes (idclientes);
ALTER TABLE login ADD FOREIGN KEY(idfuncionarios) REFERENCES funcionarios (idfuncionarios);
ALTER TABLE login ADD FOREIGN KEY(idclientes) REFERENCES clientes (idclientes);
ALTER TABLE login ADD FOREIGN KEY(idadm) REFERENCES administrador (idadm);
ALTER TABLE funcaofuncionario ADD FOREIGN KEY(idfuncionarios) REFERENCES funcionarios (idfuncionarios);

INSERT INTO administrador values(default,'yago','17326529701','1111111','teste@teste.com');
INSERT INTO login values(default,'admin','admin','ativo',default,default,'1');
select * from administrador;
select * from login;
