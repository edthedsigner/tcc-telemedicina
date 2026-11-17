<aside class="col-md-2 bg-light menu-lateral p-3">
    <h6 class="text-muted">MENU</h6>

    <a href="index.php?pagina=inicio">Dashboard</a>

    <?php if (in_array(($usuario["perfil"] ?? ""), ["Administrador", "Recepcionista"], true)): ?>
        <a href="index.php?pagina=pacientes">Pacientes</a>
        <a href="index.php?pagina=consultas">Consultas</a>
    <?php endif; ?>

    <?php if (($usuario["perfil"] ?? "") === "Administrador"): ?>
        <a href="index.php?pagina=medicos">Médicos</a>
        <a href="index.php?pagina=servicos">Serviços</a>
        <a href="index.php?pagina=usuarios">Utilizadores</a>
        <a href="index.php?pagina=solicitacoes">
            Solicitações online
            <?php if (!empty($consultasPendentes)): ?>
                <span class="badge text-bg-danger"><?= (int)$consultasPendentes ?></span>
            <?php endif; ?>
        </a>
    <?php endif; ?>

    <?php if (($usuario["perfil"] ?? "") === "Medico"): ?>
        <a href="index.php?pagina=consultas">Minhas consultas</a>
    <?php endif; ?>
</aside>

<main class="col-md-10 p-4">
