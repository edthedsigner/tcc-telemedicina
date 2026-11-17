<?php $usuario = usuarioLogado(); ?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIG Consulta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<?php if (!empty($_SESSION["mensagem"])): ?>
    <div class="container mt-3">
        <div class="alert alert-<?= escapar($_SESSION["mensagem"]["tipo"]) ?> alert-dismissible fade show" role="alert">
            <?= escapar($_SESSION["mensagem"]["texto"]) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    </div>
    <?php unset($_SESSION["mensagem"]); ?>
<?php endif; ?>
<nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="index.php?pagina=inicio">SIG Consulta</a>

        <?php if ($usuario): ?>
            <div class="text-white">
                <?= escapar($usuario["nome"]) ?>
                <a class="btn btn-light btn-sm ms-2" href="index.php?pagina=sair">Sair</a>
            </div>
        <?php endif; ?>
    </div>
</nav>

<div class="container-fluid">
<div class="row">
