<?php
session_start();

if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Administrador</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="css/estrutura.css">
    <link rel="stylesheet" href="css/painel_admin.css">
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
                <li><a class="inativo" href="cadastrar_admin.php"><i class="material-symbols-outlined">admin_panel_settings</i> Cadastrar administrador</a></li>
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
                <header class="aticle-header">
                    <h1 class="article-h1">Delta Games</h1>
                </header>
                <h2 class="article-h2">Administração</h2>
                <img class="animacao" src="svg/admin-animate.svg" alt="">
            </main>
        </article>
    </main>
</body>

</html>