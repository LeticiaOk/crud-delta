<?php
session_start();
if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit();
}

require_once('conexao.php');

$mensagem = '';
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM PRODUTO WHERE PRODUTO_ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt_imagem = $pdo->prepare("DELETE FROM PRODUTO_IMAGEM WHERE PRODUTO_ID = :id");
        $stmt_imagem->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt_imagem->execute();

        $stmt_estoque = $pdo->prepare("DELETE FROM PRODUTO_ESTOQUE WHERE PRODUTO_ID = :id");
        $stmt_estoque->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt_estoque->execute();

        if ($stmt->rowCount() > 0) {
            $mensagem = "Produto excluído com sucesso!";
        } else {
            $mensagem = "Ops.. Erro ao excluir produto.";
        }
    } catch (PDOException $e) {
        $mensagem =  "Serviço indisponível: não foi possível excluir o produto.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Produto</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="css/estrutura.css">
    <link rel="stylesheet" href="css/exclusao.css">
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
                <h1 class="mensagem"><?php echo $mensagem; ?></h1>
                <img class="titulo-animacao" class="" src="svg/inbox-cleanup-pana.svg" alt="">
                <!-- <a class="back" href="listar_administradores.php">Voltar à Lista de Administradores</a> -->
            </main>
        </article>
    </main>
</body>
</html>