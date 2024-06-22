<?php
// Uma sessão é iniciada e verifica-se se um admnistrador está logado. Se não estiver, ele é redirecionado para a página de login.
session_start();
if (!isset($_SESSION['admin_logado'])) {
    header('location: login.php');
    exit();
}

// O script fa uma conexaão com o bando de dados, usando os detalhes de configuração específicados em conexao.php
require_once('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        try {
            $stmt = $pdo->prepare("SELECT * FROM ADMINISTRADOR WHERE ADM_ID = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $administrador = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                echo "Nenhum administrador encontrado com o ID fornecido.";
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
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;
    $id = $_POST['id']; // Certifique-se de que você está passando o id do administrador como um campo oculto no seu formulário
    try {
        $stmt = $pdo->prepare("UPDATE ADMINISTRADOR SET ADM_NOME = :nome, ADM_EMAIL = :email, ADM_SENHA = :senha, ADM_ATIVO = :ativo WHERE ADM_ID = :id");
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Administrador</title>
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
                <form class="center-content" action="editar_administrador.php" method="post" enctype="multipart/form-data">
                    <div class="card-edit">
                        <h3>Editar Administrador</h3>
                        <img class="titulo-animacao" src="svg/login-animate.svg" alt="">
                        <input type="hidden" name="id" id="id" value="<?php echo $administrador['ADM_ID']; ?>">
                        <div class="textfield">
                            <label for="nome">Nome:</label>
                            <input type="text" name="nome" id="nome" value="<?php echo isset($administrador) ? $administrador['ADM_NOME'] : '' ?>">
                        </div>

                        <div class="textfield">
                            <label for="email">E-mail:</label>
                            <input type="email" name="email" id="email" value="<?php echo isset($administrador) ? $administrador['ADM_EMAIL'] : '' ?>"><br>
                        </div>

                        <div class="textfield">
                            <label for="senha">Senha:</label>
                            <input type="text" name="senha" id="senha" value="<?php echo isset($administrador) ? $administrador['ADM_SENHA'] : '' ?>"><br>
                        </div>
                        <div class="textfield-check">
                            <label for="ativo">Ativo:</label>
                            <input type="checkbox" name="ativo" id="ativo" value="1" <?php if (isset($administrador)) {
                                                                                            echo $administrador['ADM_ATIVO'] ? 'checked' : '';
                                                                                        } else {
                                                                                            echo '';
                                                                                        }; ?>>
                        </div>
                        <input class="cadastrar" type="submit" value="Atualizar Administrador">
                        <!-- <a class="back" href="listar_administradores.php">Voltar à Lista de Administradores</a> -->
                    </div>
                </form>
            </main>
        </article>
    </main>
</body>

</html>