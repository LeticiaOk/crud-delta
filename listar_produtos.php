<?php
session_start();
require_once('conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT PRODUTO.*, CATEGORIA.CATEGORIA_NOME, PRODUTO_IMAGEM.IMAGEM_URL, PRODUTO_ESTOQUE.PRODUTO_QTD, PRODUTO_IMAGEM.IMAGEM_ID
            FROM PRODUTO 
            JOIN CATEGORIA ON PRODUTO.CATEGORIA_ID = CATEGORIA.CATEGORIA_ID 
            LEFT JOIN PRODUTO_IMAGEM ON PRODUTO.PRODUTO_ID = PRODUTO_IMAGEM.PRODUTO_ID 
            LEFT JOIN PRODUTO_ESTOQUE ON PRODUTO.PRODUTO_ID = PRODUTO_ESTOQUE.PRODUTO_ID");

    $stmt->execute(); // Executa a consulta
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC); //Busca todos os registros retornados pela consulta
} catch (PDOException $e) {
    // Em caso de erro na consulta, exibe uma mensagem
    echo "<p style='color:red;'> Erro ao listar produtos:" . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Produtos</title>
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
                <li><a class="ativo" href="listar_produtos.php"><i class="material-symbols-outlined">inventory</i>Listar produtos</a></li>
            </ul>
            <ul class="categoria">
                <li><a class="inativo" href="cadastrar_categoria.php"><i class="material-symbols-outlined">add</i>Cadastrar categoria</a></li>
                <li><a class="inativo" href="listar_categorias.php"><i class="material-symbols-outlined">category</i>Listar categorias</a></li>
            </ul>
            <hr>
            <a class="login inativo" href="login.php"><i class="material-symbols-outlined">logout</i>Trocar administrador</a>
            <img class="sidebar-img" src="svg/Wall post-amico.svg" alt="">

        </aside>
        <article>
            <div class="main-edit">
                <h3>Produtos Cadastrados</h3>
                <img class="titulo-animacao" src="svg/Horror video game-pana.svg" alt="">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Preço</th>
                        <th>Categoria</th>
                        <th>Ativo</th>
                        <th>Desconto</th>
                        <th>Estoque</th>
                        <th>Imagem</th>
                        <th>Ações</th>
                    </tr>
                    <?php foreach ($produtos as $produto) : ?>
                        <tr>
                            <td><?php echo $produto['PRODUTO_ID']; ?></td>
                            <td><?php echo $produto['PRODUTO_NOME']; ?></td>
                            <td><?php echo $produto['PRODUTO_DESC']; ?></td>
                            <td><?php echo $produto['PRODUTO_PRECO']; ?></td>
                            <td><?php echo $produto['CATEGORIA_NOME']; ?></td>
                            <td><?php echo $produto['PRODUTO_ATIVO'] ? 'Sim' : 'Não'; ?></td>
                            <td><?php echo $produto['PRODUTO_DESCONTO']; ?></td>
                            <td><?php echo $produto['PRODUTO_QTD']; ?></td>
                            <td><img src="<?php echo $produto['IMAGEM_URL']; ?>" alt="<?php echo $produto['PRODUTO_NOME']; ?>" width="50"></td>
                            <td class="acoes">
                                <a class="editar" href="editar_produto.php?id=<?php echo $produto['PRODUTO_ID']; ?>&imagem_id=<?php echo $produto['IMAGEM_ID']; ?>" class="action-btn">Editar</a><!-- Passando dados do produto pela URL-->
                                <a class="excluir" href="excluir_produto.php?id=<?php echo $produto['PRODUTO_ID']; ?>" class="action-btn delete-btn" onclick="excluir(event)">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <a class="cadastrar" href="cadastrar_produto.php">+</a>
                <!-- Script para confirmar a exclusão do item -->
                <script>
                    function excluir(event) {
                        if (!confirm('Deseja realmente excluir o item?')) {
                            event.preventDefault();
                        }
                    };
                </script>
            </div>
        </article>
    </main>
</body>

</html>