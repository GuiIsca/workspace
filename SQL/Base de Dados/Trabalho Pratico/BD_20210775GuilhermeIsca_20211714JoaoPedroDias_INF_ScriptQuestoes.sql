use BD1_20210775_2223

/*Guilherme Luis Ferreira Isca N�20210775*/
/*Jo�o Pedro Dias N�20211714*/

/*QUEST�ES 1*/

/*i. Fa�a a listagem geral de todas as tabelas*/
select * from Categoria
select * from Funcionario 
select * from Supervisao
select * from Funcionario_Categoria
select * from Produto
select * from Producao
select * from Ingredientes
select * from Produto_Ingredientes
select * from Partipacao
select * from Viatura
select * from Cliente
select * from Entrega


/*ii. Liste toda a informa��o sobre os funcion�rios, que tenham �Rui� no nome, e que
tenham participado em produ��es no primeiro trimestre de 2022. Apresente o
resultado ordenado por nome de Z para A*/
select * from Funcionario
join Producao on idFuncionario = encarregado
where nome like '%Rui%' 
and momento_inicio >= '2022-01-01'
and momento_inicio <= '2022-03-31'
order by nome desc


/*iii. Liste para cada nome de produto, o nome dos ingredientes e a respetiva
quantidade, na sua composi��o. Inclua no resultado apenas produtos que tenham
sido produzidos nos primeiros 15 dias do m�s de fevereiro de 2022. Ordene o
resultado pelo nome do produto de Z para A*/
select Produto.nome 'NomeDoProduto', Ingredientes.nome 'NomeDoIngrediente', 
Produto_Ingredientes.quantidade 'QuantidadeIngrediente(Em gramas)' from Produto
join Produto_Ingredientes on Produto.idProduto = Produto_Ingredientes.idProduto
join Ingredientes on Produto_Ingredientes.idIngrediente = Ingredientes.idIngrediente
join Producao on Produto.idProduto = Producao.idProduto
where momento_inicio >= '2022-02-01'
and momento_inicio <= '2022-02-15'
order by Produto.nome desc


/*iv. Liste para cada nome de funcion�rio, a quantidade total de vezes que este foi
respons�vel por jornadas. Tenha em considera��o que podem existir funcion�rios
que nunca foram respons�veis por qualquer jornada, mas tamb�m estes devem
constar do resultado. Ordene o resultado pela quantidade come�ando pela maior
quantidade at� � menor*/
select Funcionario.nome, COUNT(Supervisao.Data_inicio) 'TotalDeJornadas' from Funcionario
left join Supervisao on Funcionario.idFuncionario = Supervisao.idSupervisor
group by Funcionario.nome
order by 'TotalDeJornadas' desc


/*v. Para cada viatura indique a quantidade de entregas em que participou. Apresente
o resultado ordenado pela quantidade (da maior para a menor) e diferenciado por
semestre (independente do ano em causa)*/
select Viatura.idViatura,
(select COUNT(*) from Entrega where Viatura.idViatura = Entrega.idViatura and MONTH(Entrega.Data_entrega) <= 6) as QuantidadeEntregas_Semestre1,
(select COUNT(*) from Entrega where Viatura.idViatura = Entrega.idViatura and MONTH(Entrega.Data_entrega) > 6) as QuantidadeEntregas_Semestre2
from Viatura
order by QuantidadeEntregas_Semestre1 desc, QuantidadeEntregas_Semestre2 desc


/*vi. Liste toda a informa��o sobre funcion�rios nascidos antes de 2000 que tendo
realizado entregas, nunca tenham sido respons�veis por nenhuma jornada.
Apresente o resultado ordenado por nome de funcion�rio de Z para A*/
select * from Funcionario
where Funcionario.data_Nascimento <= '1999-12-31'
and Funcionario.idFuncionario in (select Entrega.idFuncionario from Entrega group by Entrega.idFuncionario)
and Funcionario.idFuncionario not in (select Supervisao.idSupervisor from Supervisao group by Supervisao.idSupervisor)
order by Funcionario.nome desc


/*vii. Liste o nome dos 3 produtos produzidos em maior quantidade. N�o devem constar
do resultado produtos produzidos nos meses pares, nem que o seu nome termine
pela letra �s�. Apresente o resultado ordenado por data de entrega, come�ando pela
mais recente*/
select top 3 Produto.nome, SUM(Producao.quantidade) 'TotalQuantidade' from Produto
join Producao on Produto.idProduto = Producao.idProduto
join Entrega on Producao.idProducao = Entrega.idProducao
where MONTH(Producao.momento_inicio)%2 = 0 and Produto.nome not like '%s'
group by Produto.nome, Entrega.Data_entrega
order by Entrega.Data_entrega desc


/*viii. Liste para cada nome de produto, a data em que este foi produzido pela primeira
vez. */
select Produto.nome, MIN(Producao.momento_inicio)'PrimeiraProducao' from Produto
join Producao on Produto.idProduto = Producao.idProduto
group by Produto.nome


/*ix. Liste o nome dos funcion�rios que tenham realizado pelo menos duas entregas no
mesmo dia. No resultado dever� constar o nome do funcion�rio, e a data. O
resultado apresentado deve ser ordenado por data, iniciando-se a listagem pela
mais recente*/
select Funcionario.nome, Entrega.Data_entrega from 
(select idFuncionario, Data_entrega from Entrega group by idFuncionario, Data_entrega
having count(*) >= 2) as EntregasNoMesmoDia 
join Entrega on EntregasNoMesmoDia.idFuncionario = Entrega.idFuncionario and EntregasNoMesmoDia.Data_entrega = Entrega.Data_entrega
join Funcionario on Funcionario.idFuncionario = Entrega.idFuncionario
order by Entrega.Data_entrega desc


/*x. Recorra ao mecanismo de cria��o de vista de modo a criar uma vista que para cada
categoria dos funcion�rios, que contabilize o n�mero de vezes que esta � principal
ou secund�ria*/
create view ContagemCategorias as
select Categoria.idCategoria, Categoria.nome,
	(select COUNT(*) from Funcionario where Funcionario.cat_Principal = Categoria.idCategoria) as TotalPrincipal,
	(select COUNT(*) from Funcionario where Funcionario.cat_Secundaria = Categoria.idCategoria) as TotalSecundaria
from Categoria

select * from ContagemCategorias


/*QUEST�ES 2*/

/*"Like", "Between" e "In"*/

/*Lista toda a informa��o dos funcion�rios cujo o nome termina em 'a',
que tenham nascido entre Janeiro e Junho e que o ID seja
10,30,50,70 ou 90. O resultado � ordenado pelo o id do funcion�rio por ordem crescente*/
select Funcionario.* from Funcionario 
join Categoria on Funcionario.cat_Principal = Categoria.idCategoria
where Categoria.nome like '%a'
and MONTH(Funcionario.data_Nascimento) between 1 and 6
and Funcionario.idFuncionario in (10, 30, 50, 70, 90)
order by Funcionario.idFuncionario asc


/*"Not Like", "Not Between" e "Not In"*/

/*Lista as matriculas das viaturas em que o nome do cliente n�o comece por F,
o id da viatura n�o esteja entre 10 e 20 e o id do cliente n�o seja
1000 e 4000. O resultado � ordenado pelo o id da viatura por ordem crescente*/
select Viatura.matricula from Entrega
join Viatura on Entrega.idViatura = Viatura.idViatura
join Cliente on Entrega.idCliente = Cliente.idCliente
where Cliente.nome not like 'F%'
and Viatura.idViatura not between 10 and 20
and Entrega.idCliente not in (1000, 4000)
order by Viatura.idViatura asc


/*"COUNT", "MIN", "MAX"*/

/*Lista da tabela Producao o total de produ�oes e, respetivamente,
a menor quantidade e a maior quantidade de produ��o.*/
select COUNT(Producao.idProducao) 'TotaldeProdu��es', 
MIN(Producao.quantidade) 'MenorQuantidadeDeProdu��o',
MAX(Producao.quantidade) 'MaiorQuantidadeDeProdu��o'
from Producao


/*"SUM", "Group by" e "Having"*/

/*Lista o total de cada ingrediente usado em todos os produtos
e retorna apenas aqueles ingredientes cuja quantidade total � maior do que 100*/
select Ingredientes.nome, SUM(Produto_Ingredientes.quantidade) 'QuantidadeTotal'
from Produto_Ingredientes
join Ingredientes on Produto_Ingredientes.idIngrediente = Ingredientes.idIngrediente
group by Ingredientes.nome
having SUM(Produto_Ingredientes.quantidade) > 100


/*"Vista" e "Subquery com correla��o"*/

/*Cria uma vista com os dados dos funcion�rios que s�o ou foram supervisores tal como as informa��es de in�cio e do fim da supervis�o 
e que � apenas exibido a supervis�o mais recente para cada supervisor.*/
create view SupervisoesMaisRecentes as
select Funcionario.nome, Supervisao.Data_inicio, Supervisao.Data_fim, Supervisao.idSupervisor
from Funcionario
join Supervisao on Funcionario.idFuncionario = Supervisao.idSupervisor
where Supervisao.Data_inicio = (SELECT MAX(Data_inicio) FROM Supervisao WHERE Funcionario.idFuncionario = Supervisao.idSupervisor)

select * from SupervisoesMaisRecentes

/*"Vista", "AVG", "Group by" e "Having" e "Subquery sem correla��o" */

/* Cria uma vista que mostra a media de produ��o de croissants.*/
create view VistaCroissant as
select Produto.nome, AVG(Producao.quantidade) 'MediaDeProducao'
from Produto
join Producao on Producao.idProduto = Produto.idProduto
group by Produto.nome
having Produto.nome = (select nome from Produto where nome = 'Croissant' )

select * from VistaCroissant


