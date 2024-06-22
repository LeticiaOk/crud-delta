<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
</head>

<body>
    <main class="main-login">
        <div class="left-login">
            <h1>Delta Games</h1>
            <h2>Área administrativa</h2>
            <a href="index.html">
                <img src="svg/horror-video-game-animate.svg" class="left-login-image" alt="Horror Games Animate">
            </a>
        </div>

        <div class="right-login">
            <div class="card-login">
                <h3>Login</h3>
                <form class="formulario" action="processa_login.php" method="post">
                    <div class="textfield">
                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="textfield">
                        <label for="senha">Senha:</label>
                        <input type="password" id="senha" name="senha" placeholder="Senha" required>
                    </div>

                    <input id="btn-login-click" class="btn-login" type="submit" value="Entrar">

                    <?php
                    if (isset($_GET['erro'])) {
                        echo '<p style="color:red;">Nome de usuário ou senha incorretos !</p>';
                    }
                    ?>
                </form>
            </div>
        </div>
    </main>
</body>

</html>