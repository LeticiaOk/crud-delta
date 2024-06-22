<?php
session_start();
require_once('conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //$_SEVER['REQUEST_METHOD'] retorna o método usado para acessar a página

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    //Gerar a URL da imagem
    $base_url = "http://localhost/delta/";

    try {
        $sql = "INSERT INTO ADMINISTRADOR (ADM_NOME, ADM_EMAIL, ADM_SENHA, ADM_ATIVO) VALUES (:nome, :email, :senha, :ativo)";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
        $stmt->execute();
        echo "<p style= 'color:green;'> Administrador cadastrado com sucesso!</p>";
    } catch (PDOException $e) {
        echo "<p style='color:red;'> Erro ao cadastrar o admnistrador:" . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="css/cadastro.css">
    <link rel="stylesheet" href="css/estrutura.css">

</head>

<body>
    <main class="main-page">
        <aside class="sidebar">
            <header class="sidebar-header">
                <img class="logo-img" src="img/delta_logo3.png" alt="Games">
                <p class="logo-txt">Delta</p>
            </header>
            <a class="add" href="cadastrar_produto.php"><span class="plus">+</span> Produto</a>

            <ul class="administrador">
                <li><a class="ativo" href="cadastrar_admin.php"><i class="material-symbols-outlined">admin_panel_settings</i> Cadastrar administrador</a></li>
                <li><a class="inativo" href="listar_administradores.php"><i class="material-symbols-outlined">view_list</i> Listar administradores</a></li>
            </ul>
            <ul class="produto">
                <li><a class="inativo" href="cadastrar_produto.php"><i class="material-symbols-outlined">inventory_2</i>Cadastrar produto</a></li>
                <li><a class="inativo" href="listar_produtos.php"><i class="material-symbols-outlined">inventory</i>Listar produtos</a></li>
            </ul>
            <ul class="categoria">
                <li><a class="inativo" href="cadastrar_categoria.php"><i class="material-symbols-outlined">add</i>Cadastrar categoria</a></li>
                <li><a class="inativo" href="listar_categorias.php"><i class="material-symbols-outlined">category</i>Listar categorias</a></li>
            </ul>
            <hr>
            <a class="login inativo" href="login.php"><i class="material-symbols-outlined">logout</i>Trocar administrador</a>
            <img class="sidebar-img" src="svg/Wall post-amico.svg" alt="">
        </aside>
        <article class="background-image">
            <main class="main-edit">
                <form class="center-content" action="" method="post" enctype="multipart/form-data">
                    <div class="card-edit">
                        <h3>Cadastrar Administrador</h3>
                        <img class="titulo-animacao" src="svg/login-animate.svg" alt="">
                        <div class="textfield">
                            <label for="nome">Nome:</label>
                            <input type="text" name="nome" id="nome" required>
                        </div>

                        <div class="textfield">
                            <label for="email">E-mail:</label>
                            <input type="email" name="email" id="email">
                        </div>

                        <div class="textfield">
                            <label for="senha">Senha:</label>
                            <input type="password" name="senha" id="senha">
                        </div>

                        <div class="textfield-check">
                            <label for="ativo">Ativo:</label>
                            <input type="checkbox" name="ativo" id="ativo" value="1">
                        </div>

                        <input class="cadastrar" type="submit" value="Cadastrar admnistrador">

                    </div>
                </form>
            </main>
        </article>
    </main>
</body>

</html>