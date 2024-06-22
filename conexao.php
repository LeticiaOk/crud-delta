<?php
// $host = 'seu_host';
// $db = 'seu_banco_de_dados';
// $user = 'seu_usuario';
// $pass = 'sua_senha';
// $charset = 'utf8mb4';

$dsn = "mysql:host=$host; dbname=$db; charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    echo "Falha ao conectar ao banco de dados <p>" . $e;
}
// echo "Conexão realizada com sucesso";
