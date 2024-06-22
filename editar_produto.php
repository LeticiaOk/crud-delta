<?php
session_start();
if (!isset($_SESSION['admin_logado'])) {
    header('location: login.php');
    exit();
}

require_once('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $imagem_id = $_GET['imagem_id']; // Pegando elementos via GET (url)
        try {
            //Fazando consulta do banco de dados

            // Tabela produto
            $stmt = $pdo->prepare("SELECT * FROM PRODUTO WHERE PRODUTO_ID = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Tabela da imagem do produto
            $stmt_imagem = $pdo->prepare("SELECT * FROM PRODUTO_IMAGEM WHERE IMAGEM_ID = :imagem_id");
            $stmt_imagem->bindParam(':imagem_id', $imagem_id, PDO::PARAM_INT);
            $stmt_imagem->execute();

            // Tabela do estoque do produto
            $stmt_estoque = $pdo->prepare("SELECT * FROM PRODUTO_ESTOQUE WHERE PRODUTO_ID = :id");
            $stmt_estoque->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt_estoque->execute();

            // Tabela de categoria
            $stmt_categoria = $pdo->prepare("SELECT * FROM CATEGORIA");
            $stmt_categoria->execute();

            if ($stmt->rowCount() > 0) {
                //Atribuindo as informações do banco de dados as varáveis correspondentes

                $produto = $stmt->fetch(PDO::FETCH_ASSOC); //Busca os registros retornados pela consulta da tabela do produto
                $imagem = $stmt_imagem->fetch(PDO::FETCH_ASSOC); //Busca os registros retornados pela consulta da tabela da imagem do produto
                $estoque = $stmt_estoque->fetch(PDO::FETCH_ASSOC); //Busca os registros retornados pela consulta da tabela de estoque do produto
                $categorias = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC); //Busca todos os registros retornados pela consulta da tabela categoria
            } else {
                echo "Nenhum produto encontrado com o ID fornecido.";
                exit();
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    } else {
        header('Location: listar_administradores.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    /*Resgatando e atribuindo as informações do formulário as variáveis correspondentes*/
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $desconto = $_POST['desconto'];
    $categoria_id = $_POST['categoria_id'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;
    $produto_qtd = $_POST['produto_qtd'];
    $imagem_id = $_POST['imagem_id'];
    $imagem_urls = $_POST['imagem_url'];
    $imagem_ordens = $_POST['imagem_ordem'];
    $id = $_POST['id'];
    try {
        /*Atualizando a tabela do produto*/
        $stmt = $pdo->prepare("UPDATE PRODUTO SET PRODUTO_NOME = :nome, PRODUTO_DESC = :descricao, PRODUTO_PRECO = :preco, PRODUTO_DESCONTO = :desconto, CATEGORIA_ID = :categoria_id, PRODUTO_ATIVO = :ativo WHERE PRODUTO_ID = :id");
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
        $stmt->bindParam(':desconto', $desconto, PDO::PARAM_STR);
        $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // 
        $stmt->execute();

        /*Atualizando a tabela do estoque do produto*/
        $stmt_estoque = $pdo->prepare("UPDATE PRODUTO_ESTOQUE SET PRODUTO_QTD = :produto_qtd WHERE PRODUTO_ID = :id");
        $stmt_estoque->bindParam(':produto_qtd', $produto_qtd, PDO::PARAM_STR);
        $stmt_estoque->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt_estoque->execute();


        //Atualizando a tabela da imagem do produto
        foreach ($imagem_urls as $index => $url) {
            $ordem = $imagem_ordens[$index];
            $sql_imagem = "UPDATE PRODUTO_IMAGEM SET IMAGEM_URL = :url_imagem, PRODUTO_ID = :id, IMAGEM_ORDEM = :imagem_ordem WHERE PRODUTO_ID = :id AND IMAGEM_ID = :imagem_id";
            $stmt_imagem = $pdo->prepare($sql_imagem);
            $stmt_imagem->bindParam(':url_imagem', $url, PDO::PARAM_STR);
            $stmt_imagem->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt_imagem->bindParam(':imagem_ordem', $ordem, PDO::PARAM_INT);
            $stmt_imagem->bindParam(':imagem_id', $imagem_id, PDO::PARAM_INT);
            $stmt_imagem->execute();
        }
        echo "<script>alert('Produto atualizado com sucesso');</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Erro ao atualizar produto');</script>";

    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Produto</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="css/estrutura.css">
    <link rel="stylesheet" href="css/edicao.css">
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
            <a  class="login inativo" href="login.php"><i class="material-symbols-outlined">logout</i>Trocar administrador</a>
            <img class="sidebar-img" src="svg/Wall post-amico.svg" alt="">

        </aside>
        <article class="background-image">
            <main class="main-edit">
                <script>
                    /*Inserindo novas imagens no banco*/
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
                        novoInputOrdem.min = '1'
                        novoInputOrdem.required = true;
                        novoDiv.appendChild(novoInputURL);
                        novoDiv.appendChild(novoInputOrdem);
                        containerImagens.appendChild(novoDiv);
                    }
                </script>
                <!-- Resgatando as informações das tabelas do banco de dados e inserindo novas -->
                <form class="center-content" action="editar_produto.php" method="post" enctpype="multipart/form-data">
                    <div class="card-edit">
                        <h3>Atualizar Produto</h3>
                        <img class="titulo-animacao" src="svg/Horror video game-pana.svg" alt="">
                        <input type="hidden" name="id" id="id" value="<?php echo $produto['PRODUTO_ID']; ?>">
                        <!-- Produto -->
                        <div class="textfield">
                            <label for="nome">Nome:</label>
                            <input type="text" name="nome" id="nome" value="<?php echo isset($produto) ? $produto['PRODUTO_NOME'] : '' ?>">
                        </div>
                        <div class="textfield">
                            <label for="descricao">Descrição:</label>
                            <textarea name="descricao" id="descricao"><?php echo isset($produto) ? $produto['PRODUTO_DESC'] : '' ?></textarea>
                        </div>
                        <div class="textfield">
                            <label for="preco">Preço:</label>
                            <input type="number" name="preco" id="preco" step="0.01" value="<?php echo isset($produto) ? $produto['PRODUTO_PRECO'] : '' ?>">
                        </div>
                        <div class="textfield">
                            <label for="desconto">Desconto:</label>
                            <input type="number" name="desconto" id="desconto" step="0.01" value="<?php echo isset($produto) ? $produto['PRODUTO_DESCONTO'] : '' ?>">
                        </div>
                        <div class="textfield">
                            <!-- Categoria -->
                            <label for="categoria_id">Categoria:</label>
                            <select name="categoria_id" id="categoria_id" required>
                                <?php
                                foreach ($categorias as $categoria) :
                                    $selected = ($categoria['CATEGORIA_ID'] == $produto['CATEGORIA_ID']) ? 'selected' : '';
                                ?>
                                    <option value="<?= $categoria['CATEGORIA_ID'] ?>" <?= $selected ?>><?= $categoria['CATEGORIA_NOME'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="textfield-check">
                            <!-- produto ativo -->
                            <label for="ativo">Ativo:</label>
                            <input type="checkbox" name="ativo" id="ativo" value="1" <?php if (isset($produto)) {
                                                                                            echo $produto['PRODUTO_ATIVO'] ? 'checked' : '';
                                                                                        } else {
                                                                                            echo '';
                                                                                        }; ?>>
                        </div>
                        <!-- estoque -->
                        <div class="textfield">
                            <label for="produto_qtd">Estoque:</label>
                            <input type="number" name="produto_qtd" id="produto_qtd" value="<?php echo isset($estoque) ? $estoque['PRODUTO_QTD'] : '' ?>">
                        </div>
                        <!-- área para adicionar URLs de imagens -->
                        <div class="textfield">
                            <label for="imagem">Imagem URL</label>
                            <div class="containerImagens" id="containerImagens">
                                <input type="hidden" name="imagem_id" id="imagem_id" value="<?php echo $imagem['IMAGEM_ID']; ?>">
                                <input type="text" name="imagem_url[]" placeholder="URL da imagem" value="<?php echo isset($imagem) ? $imagem['IMAGEM_URL'] : '' ?>">
                                <input type="number" name="imagem_ordem[]" placeholder="Ordem" min="1" value="<?php echo isset($imagem) ? $imagem['IMAGEM_ORDEM'] : '' ?>">
                            </div>
                            <button class="adicionar" type="button" onclick="adicionarImagem()">Adicionar mais imagens</button>
                        </div>
                        <!-- Atualizando dados -->
                        <button class="cadastrar" type="submit">Atualizar Produto</button>
                </form>
                <!-- <a class="back" href="listar_produtos.php">Voltar à Listar Produtos</a> -->
                </div>
            </main>
        </article>
    </main>
</body>

</html>