<?php
session_start();
require_once('conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT * FROM CATEGORIA");
    $stmt->execute();
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="css/estrutura.css">
    <link rel="stylesheet" href="css/listagem.css">
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
                <li><a class="ativo" href="listar_categorias.php"><i class="material-symbols-outlined">category</i>Listar categorias</a></li>
            </ul>
            <hr>
            <a  class="login inativo" href="login.php"><i class="material-symbols-outlined">logout</i>Trocar administrador</a>
            <img class="sidebar-img" src="svg/Wall post-amico.svg" alt="">

        </aside>
        <article>
            <main class="main-edit">
                <h3>Categorias Cadastradas</h3>
                <img class="titulo-animacao" src="svg/search-animate.svg" alt="">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Ativo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <?php foreach ($categorias as $categoria) : ?>
                        <tr>
                            <td><?php echo $categoria['CATEGORIA_ID']; ?></td>
                            <td><?php echo $categoria['CATEGORIA_NOME']; ?></td>
                            <td><?php echo $categoria['CATEGORIA_DESC']; ?></td>
                            <td><?php echo $categoria['CATEGORIA_ATIVO'] ? 'Sim' : 'Não'; ?></td>
                            <td class="acoes">
                                <a class="editar" href="editar_categoria.php?id=<?php echo $categoria['CATEGORIA_ID']; ?>">Editar</a>
                                <a class="excluir" href="excluir_categoria.php?id=<?php echo $categoria['CATEGORIA_ID']; ?>" onclick="excluir(event)">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <a class="cadastrar" href="cadastrar_categoria.php">+</a>
                <script>
                    function excluir(event) {
                        if (!confirm('Deseja realmente excluir o item?')) {
                            event.preventDefault();
                        }
                    };
                </script>
            </main>
        </article>
    </main>
</body>

</html>