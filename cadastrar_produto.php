<?php

session_start();

require_once('conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}
//Bloco de consulta para buscar categorias. A variável $categorias criada aqui será utilizada no formulário para apresentar as categorias disponíveis
try {
    $stmt_categoria = $pdo->prepare("SELECT * FROM CATEGORIA");
    $stmt_categoria->execute();
    $categorias = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p style=color:red;'>Erro ao atualizar produto: " . $e->getMessage() . "</p>" . "<p>" . $e->getLine() . "</p>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $desconto = $_POST['desconto'];
    $categoria_id = $_POST['categoria_id'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;
    $produto_qtd = $_POST['produto_qtd'];
    $imagem_urls = $_POST['imagem_url'];
    $imagem_ordens = $_POST['imagem_ordem'];


    try {
        $sql = "INSERT INTO PRODUTO(PRODUTO_NOME, PRODUTO_DESC, PRODUTO_PRECO, PRODUTO_DESCONTO, CATEGORIA_ID, PRODUTO_ATIVO) VALUES (:nome, :descricao, :preco, :desconto, :categoria_id, :ativo)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
        $stmt->bindParam(':desconto', $desconto, PDO::PARAM_STR);
        $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_STR);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
        $stmt->execute();


        //pegando o id do último produto inserido
        $produto_id = $pdo->lastInsertID();

        $sql_estoque = "INSERT INTO PRODUTO_ESTOQUE(PRODUTO_ID, PRODUTO_QTD) VALUES (:produto_id, :produto_qtd)";
        $stmt_estoque = $pdo->prepare($sql_estoque);
        $stmt_estoque->bindParam(':produto_qtd', $produto_qtd, PDO::PARAM_STR);
        $stmt_estoque->bindParam(':produto_id', $produto_id, PDO::PARAM_STR);
        $stmt_estoque->execute();



        //Inserindo imagens no BD
        foreach ($imagem_urls as $index => $url) {
            $ordem = $imagem_ordens[$index];
            $sql_imagem = "INSERT INTO PRODUTO_IMAGEM(IMAGEM_URL, PRODUTO_ID, IMAGEM_ORDEM ) VALUES (:url_imagem, :produto_id, :ordem_imagem)";
            $stmt_imagem = $pdo->prepare($sql_imagem);
            $stmt_imagem->bindParam(':url_imagem', $url, PDO::PARAM_STR);
            $stmt_imagem->bindParam(':produto_id', $produto_id, PDO::PARAM_STR);
            $stmt_imagem->bindParam(':ordem_imagem', $ordem, PDO::PARAM_INT);
            $stmt_imagem->execute();
        }
        echo "<p style='color:green;'>Produto cadastrado com sucesso</p>";
    } catch (PDOException $e) {
        echo "<p style=color:red;'>Erro ao atualizar produto: " . $e->getMessage() . "</p>" . "<p>" . $e->getLine() . "</p>";
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
    <link rel="stylesheet" href="css/estrutura.css">
    <link rel="stylesheet" href="css/cadastro.css">
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
                <li><a class="ativo" href="cadastrar_produto.php"><i class="material-symbols-outlined">inventory_2</i>Cadastrar produto</a></li>
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
                <script>
                    //Adiciona um novo campo de imagem URL
                    function adicionarImagem() {
                        const containerImagens = document.getElementById('containerImagens');
                        const novoDiv = document.createElement('div');
                        novoDiv.className = 'imagem-input';
                        const novoInputURL = document.createElement('input');
                        novoInputURL.type = "text";
                        novoInputURL.name = 'imagem_url[]';
                        novoInputURL.placeholder = 'URL da imagem';
                        novoInputURL.required = true;
                        const novoInputOrdem = document.createElement('input');
                        novoInputOrdem.type = "number";
                        novoInputOrdem.name = 'imagem_ordem[]';
                        novoInputOrdem.placeholder = 'Ordem';
                        novoInputOrdem.min = '1';
                        novoInputOrdem.required = true;
                        novoDiv.appendChild(novoInputURL);
                        novoDiv.appendChild(novoInputOrdem);
                        containerImagens.appendChild(novoDiv);
                    }
                </script>
                <form class="center-content" action="" method="post" enctpype="multipart/form-data">
                    <div class="card-edit">
                        <h3>Cadastrar Produto</h3>
                        <img class="titulo-animacao" src="svg/Horror video game-pana.svg" alt="">
                        <div class="textfield">
                            <label for="nome">Nome:</label>
                            <input type="text" name="nome" id="nome" required>
                        </div>

                        <div class="textfield">
                            <label for="descricao">Descrição:</label>
                            <textarea class="descricao" name="descricao" id="descricao" required></textarea>
                        </div>

                        <div class="textfield">
                            <label for="preco">Preço:</label>
                            <input type="number" name="preco" id="preco" step="0.01" required>
                        </div>
                        <div class="textfield">
                            <label for="desconto">Desconto:</label>
                            <input type="number" name="desconto" id="desconto" step="0.01">
                        </div>

                        <div class="textfield">
                            <label for="categoria_id">Categoria</label>
                            <select name="categoria_id" id="categoria_id" required>
                                <?php
                                //Loop para preecher o dropdown de categoria:
                                foreach ($categorias as $categoria) :
                                ?>
                                    <option value="<?= $categoria['CATEGORIA_ID'] ?>"><?= $categoria['CATEGORIA_NOME'] ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="textfield-check">
                            <label for="ativo">Ativo:</label>
                            <input type="checkbox" name="ativo" id="ativo" value="1">
                        </div>

                        <div class="textfield">
                            <label for="produto_qtd">Estoque:</label>
                            <input type="number" name="produto_qtd" id="produto_qtd" required>
                        </div>
                        <!-- área para adicionar URLs de imagens -->
                        <div class="textfield">
                            <label for="imagem">Imagem URL:</label>
                            <div class="containerImagens" id="containerImagens">
                                <input type="text" name="imagem_url[]" placeholder="URL da imagem" required>
                                <input type="number" name="imagem_ordem[]" placeholder="Ordem" min="1" required>
                            </div>
                            <button class="adicionar" type="button" onclick="adicionarImagem()">Adicionar mais imagens</button>
                        </div>
                        <button class="cadastrar" type="submit">Cadastrar Produto</button>
                    </div>
                </form>
            </main>
        </article>
    </main>
</body>

</html>