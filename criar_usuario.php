<?php
require_once __DIR__ . "/config/bootstrap.php";

$usuario = new Usuario();

try {
    $usuario->criar(
        "Administrador",
        "admin@sigconsulta.com",
        "123456",
        "Administrador"
    );

    echo "Usuário criado com sucesso.<br>";
    echo "E-mail: admin@sigconsulta.com<br>";
    echo "Senha: 123456<br>";
    echo "<strong>Apague este arquivo depois.</strong>";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
