use BD1_20210775_2223

/*Guilherme Luis Ferreira Isca Nº20210775*/
/*João Pedro Dias Nº20211714*/

CREATE TABLE Categoria (
	idCategoria INT PRIMARY KEY not null,
	nome VARCHAR(50) not null, check (nome like '%[a-zA-Z]%') 
);

CREATE TABLE Funcionario (
    idFuncionario INT PRIMARY KEY not null,
    nome VARCHAR(100) not null, check (nome like '%[a-zA-Z]%'), 
	cat_Principal INT not null, FOREIGN KEY (cat_Principal) REFERENCES Categoria(idCategoria),
	cat_Secundaria INT, FOREIGN KEY (cat_Secundaria) REFERENCES Categoria(idCategoria),
	data_Nascimento DATE not null
);

CREATE TABLE Supervisao (
	idSupervisao INT PRIMARY KEY not null,
	idSupervisor INT not null, FOREIGN KEY (IdSupervisor) REFERENCES Funcionario(IdFuncionario),
	Data_inicio DATE not null,
	Data_fim DATE not null, check(Data_fim > Data_inicio)
);

CREATE TABLE Funcionario_Categoria (
	 idFuncionario INT not null, FOREIGN KEY(idFuncionario) REFERENCES Funcionario(idFuncionario),
	 idCategoria INT not null, FOREIGN KEY(idCategoria) REFERENCES Categoria(idCategoria),
	 Data_obtencao DATE not null
);

CREATE TABLE Produto(
	idProduto INT PRIMARY KEY not null,
	nome VARCHAR(50) not null, check (nome like '%[a-zA-Z]%') 
);

CREATE TABLE Producao(
	idProducao INT PRIMARY KEY not null,
	encarregado INT not null, FOREIGN KEY(encarregado) REFERENCES Funcionario(idFuncionario),
	idProduto INT not null, FOREIGN KEY(idProduto) REFERENCES Produto(idProduto),
	momento_inicio DATETIME not null,
	duracao TIME not null,
	quantidade INT not null, check(quantidade > 0)
);

CREATE TABLE Ingredientes(
	idIngrediente INT PRIMARY KEY not null,
	nome VARCHAR(50) not null, check (nome like '%[a-zA-Z]%')
);

CREATE TABLE Produto_Ingredientes(
	idIngrediente INT not null, FOREIGN KEY(idIngrediente) REFERENCES Ingredientes(idIngrediente),
	idProduto INT not null, FOREIGN KEY(idProduto) REFERENCES Produto(idProduto),
	quantidade INT not null, check(quantidade > 0)
);

CREATE TABLE Partipacao(
	idProducao INT not null, FOREIGN KEY(idProducao) REFERENCES Producao(idProducao),
	idFuncionario INT not null, FOREIGN KEY(idFuncionario) REFERENCES Funcionario(idFuncionario),
	tempo_gasto TIME not null
);

CREATE TABLE Viatura(
	idViatura INT PRIMARY KEY not null, 
	matricula VARCHAR(6) not null, check(matricula like '%[A-Z0-9]%'),
	Capacidade_Carga INT not null, check(Capacidade_Carga > 0)
);

CREATE TABLE Cliente(
	idCliente INT PRIMARY KEY not null,
	nome VARCHAR(50) not null, check (nome like '%[a-zA-Z]%'),
	morada VARCHAR(200) not null
);

CREATE TABLE Entrega(
	idEntrega INT PRIMARY KEY not null,
	idProducao INT not null, FOREIGN KEY(idProducao) REFERENCES Producao(idProducao),
	idCliente INT not null, FOREIGN KEY(idCliente) REFERENCES Cliente(idCliente),
	idViatura INT not null, FOREIGN KEY(idViatura) REFERENCES Viatura(idViatura),
	idFuncionario INT not null, FOREIGN KEY(idFuncionario) REFERENCES Funcionario(idFuncionario),
	quantidade INT not null, check (quantidade > 0), 
	Data_entrega DATE not null, 
);

insert into Categoria values(10, 'Gerente');
insert into Categoria values(20, 'Amassador');
insert into Categoria values(30, 'Forneiro');
insert into Categoria values(40, 'Motorista');
insert into Categoria values(50, 'Limpeza');
insert into Categoria values(60, 'Caixa');
insert into Categoria values(70, 'Chefe de Cozinha');

insert into Funcionario values(10, 'Edson Nascimento', 10, NULL, '1980-10-07');
insert into Funcionario values(20, 'Paulo Freitas', 20, 30, '2001-05-15');
insert into Funcionario values(30, 'Ricardo Pereira', 70, 30, '1998-01-24');
insert into Funcionario values(40, 'Pedro Emanuel', 30, NULL, '2002-04-12');
insert into Funcionario values(50, 'Candice Barroso', 60, 50, '2000-06-29');
insert into Funcionario values(60, 'Tatiana Nascente', 50, NULL, '1993-09-27');
insert into Funcionario values(70, 'Joaquim Encarnado', 40, NULL, '1999-12-30');
insert into Funcionario values(80, 'Alexandre Ferreira', 60, 50, '1989-02-17');
insert into Funcionario values(90, 'João Miguel', 70, 60, '2003-07-18');
insert into Funcionario values(100, 'Fernando Portugal', 10, 70, '1985-11-25');
insert into Funcionario values(300, 'Maria Luz', 70, 20, '1997-10-13');
insert into Funcionario values(500, 'Gonçalo Costa', 40, 50, '2001-08-22');
insert into Funcionario values(700, 'Tiago Lourenço', 20, NULL, '2000-12-05');
insert into Funcionario values(900, 'Jorge Antunes', 30, NULL, '1999-01-29');
insert into Funcionario values(1000, 'Leonor Paiva', 40, NULL, '1995-07-14');
insert into Funcionario values(2000, 'Carlos Rui', 70, 50, '1984-08-11');

select cat_Principal from Funcionario where cat_Principal = 70
select cat_Secundaria from Funcionario where cat_Secundaria = 70


insert into Supervisao values(1, 10, '2023-05-03', '2023-11-06')
insert into Supervisao values(2, 100, '2023-05-12', '2023-12-18')
insert into Supervisao values(3, 300, '2023-02-01', '2023-08-05')
insert into Supervisao values(4, 500, '2023-05-30', '2024-01-20')
insert into Supervisao values(5, 10, '2023-12-03', '2024-08-06')

insert into Funcionario_Categoria values(10, 10, '2023-01-06')
insert into Funcionario_Categoria values(20, 20, '2023-04-16')
insert into Funcionario_Categoria values(30, 70, '2023-06-19')
insert into Funcionario_Categoria values(40, 30, '2023-02-11')
insert into Funcionario_Categoria values(50, 60, '2023-05-31')
insert into Funcionario_Categoria values(60, 50, '2023-01-24')
insert into Funcionario_Categoria values(70, 40, '2023-03-21')
insert into Funcionario_Categoria values(80, 60, '2023-03-20')
insert into Funcionario_Categoria values(90, 70, '2023-05-15')
insert into Funcionario_Categoria values(100, 10, '2023-07-28')
insert into Funcionario_Categoria values(300, 70, '2022-12-30')
insert into Funcionario_Categoria values(500, 40, '2023-08-04')
insert into Funcionario_Categoria values(700, 20, '2023-02-14')
insert into Funcionario_Categoria values(900, 30, '2023-04-23')
insert into Funcionario_Categoria values(1000, 40, '2023-01-30')

insert into Produto values(1, 'Pão Francês')
insert into Produto values(2, 'Torta de Morango')
insert into Produto values(3, 'Pastel de Nata')
insert into Produto values(4, 'Croissant')
insert into Produto values(5, 'Brigadeiro')
insert into Produto values(6, 'Pão Doce')
insert into Produto values(7, 'Pudim')

insert into Producao values(35, 90, 1, '2023-05-22 7:30:00', '06:00:00', 60)
insert into Producao values(90, 10, 2, '2023-03-12 14:00:00', '03:00:00', 3)
insert into Producao values(160, 90, 3, '2023-06-21 15:30:00', '04:30:00', 30)
insert into Producao values(450, 30, 4, '2023-11-02 09:30:00', '05:00:00', 50)
insert into Producao values(600, 300, 5, '2023-09-10 17:00:00', '07:45:00', 25)
insert into Producao values(3500, 30, 6, '2023-04-17 10:30:00', '06:20:00', 40)
insert into Producao values(5600, 300, 7, '2023-10-29 11:45:00', '02:30:00', 5)
insert into Producao values(6000, 2000, 4, '2022-01-29 13:45:00', '08:00:00', 5)
insert into Producao values(7000, 90, 5, '2022-02-10 15:0:00', '04:00:00', 10)

insert into Ingredientes values(1, 'Açúcar')
insert into Ingredientes values(2, 'Morango')
insert into Ingredientes values(3, 'Leite')
insert into Ingredientes values(4, 'Manteiga')
insert into Ingredientes values(5, 'Farinha')

insert into Produto_Ingredientes values(1, 3, 160)
insert into Produto_Ingredientes values(2, 2, 250)
insert into Produto_Ingredientes values(4, 4, 30)
insert into Produto_Ingredientes values(5, 1, 170)
insert into Produto_Ingredientes values(1, 5, 200)

insert into Partipacao values(35, 60, '02:00:00')
insert into Partipacao values(35, 90, '04:00:00')
insert into Partipacao values(600, 40, '04:20:00')
insert into Partipacao values(600, 300, '03:25:00')
insert into Partipacao values(3500, 70, '02:50:00')
insert into Partipacao values(3500, 30, '03:30:00')

insert into Viatura values(5, 'MX34ER', 5000)
insert into Viatura values(10, 'RT23WQ', 12000)
insert into Viatura values(15, 'KL97TR', 3000)
insert into Viatura values(20, 'NV21PL', 50000)
insert into Viatura values(25, 'XC09MK', 8500)

insert into Cliente values(1000, 'Fernando Barbosa', 'Rua São Francisco Lote B12 3ºEsquerdo')
insert into Cliente values(2000, 'Pedro Felix', 'Rua Sossegado Nascente Lote A140 1ºDireito')
insert into Cliente values(3000, 'Mario Bernardo', 'Rua Encarnada Lote A60 5ºEsquerdo')
insert into Cliente values(4000, 'Carlos Emanuel', 'Rua de Espanha Lote A200 2ºDireito')

insert into Entrega values(100, 450, 1000, 20, 500, 25, '2023-11-04')
insert into Entrega values(200, 3500, 2000, 5, 70, 30, '2023-04-18')
insert into Entrega values(300, 5600, 3000, 15, 500, 1, '2023-11-01')
insert into Entrega values(400, 35, 4000, 10, 70, 20, '2023-04-18')



