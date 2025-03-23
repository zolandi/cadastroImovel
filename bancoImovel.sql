create database imoveisLog;

use imoveislog;

create table Imoveis(
id INT NOT NULL AUTO_INCREMENT,
primary key (id),
img blob,
nome varchar(40) not null,
cep varchar(10) not null,
loc varchar(50) not null,
estado varchar(40),
TempoDeCompra varchar(30)
);