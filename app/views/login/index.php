<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIG Consulta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body class="login-fundo">

<div class="login-caixa">
    <div class="text-center">
        <img src="../public/assets/clinic_logo.jpg" alt="logo" style="width: 80px">
    </div>
    <h2 class="text-center mb-4">SIG Consulta</h2>
    <p class="text-center text-muted">Acesso dos utilizadores internos</p>

    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger"><?= escapar($erro) ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?pagina=entrar">
        <div class="mb-3">
            <label>E-mail</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Senha</label>
            <input type="password" name="senha" class="form-control" required>
        </div>

        <button class="btn btn-primary w-100">Entrar</button>
    </form>

    <div class="text-center mt-3">
        <a href="index.php?pagina=solicitar_consulta" class="btn btn-outline-primary">Solicitar consulta online</a>
    </div>

    <div class="text-center mt-3 small text-muted">Administrador, Recepcionista e Médico usam esta mesma tela de acesso.</div>
</div>

</body>
</html>
