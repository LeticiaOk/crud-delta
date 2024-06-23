# CRUD Delta
> CRUD desenvolvido como parte da disciplina de Projeto Integrador do curso de Sistemas para Internet da minha faculdade.

## `Skills utilizadas:`
* PHP, SQL, JavaScript, HTML e CSS

## `Funcionalidades:`
* Servir como parte administrativa de uma empresa de jogos (DELTA).

### Principais funcionalidades:

* **CADASTRAR** administrador / categoria / produto.
* **EDITAR** informações do(a) administrador / categoria / produto.
* **EXCLUIR** administrador / categoria / produto.
* Sistema de **LOGIN** do administrador.

## `Execução:`
> Antes de tudo certfique-se de ter o XAMPP instalado e configurado corretamente em sua máquina.
1. Para conectar o banco de dados será necessário baixar o arquivo SQL disponibilizado dentro da pasta **'dumps'**
2. Em seguida acessar o seguinte endereço: [phpMyAdmin](http://localhost/phpmyadmin/)
3. Dentro do phpMyAdmin clicar na opção de 'Importar' e selecionar o arquivo SQL disponibilizado.
4. Navegar até o arquivo conexao.php e preencher as informações do banco de dados

> Essa é uma das formas de se conectar ao banco de dados pois existem outros tipos de se hospedar um banco de dados.
## `Páginas:`

### Página de Login:
* Aqui é onde o administrador vai entrar com sua conta ativa, caso a conta esteja desativada não será possível efetuar o login.
  
![login](img/login.png)

### Página Inicial do Administrador:
* Nesta sessão já é possível observar as funcionalidades do site que estão dispostas em um sidebar.
* Como observado o produto, categoria e admnistrador tem seus próprios CRUDs.

![inicio](img/inicio.png)

### Página de Cadastro:
* O formulário deverá ser preenchido com as informações correspondentes do ítem que se quer cadastrar.

![cadastrar](img/cadastrar.png)

### Página de Listagem:
* Todos os itens cadastrados aparecerão nesta sessão, junto as funções de editar e excluir.
  
![listar](img/listar.png)

### Página de Editar:
* Aqui é onde será possível alterar todas as informações dos item cadastrado.

![editar](img/editar.png)

### Página de Excluir:
* Aqui aparecerá uma mensagem caso o item tenha sido excluido com sucesso ou não.

![excluir](img/excluir.png)
