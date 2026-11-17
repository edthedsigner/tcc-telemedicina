<?php require __DIR__ . "/../layouts/cabecalho.php"; ?>
<?php require __DIR__ . "/../layouts/menu.php"; ?>

<h2>Dashboard</h2>
<p class="text-muted">Visão geral do sistema.</p>

<div class="row g-3 mt-2">
    <div class="col-md-3">
        <div class="card card-info">
            <div class="card-body">
                <h6>Pacientes</h6>
                <h2><?= $pacientes ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-info">
            <div class="card-body">
                <h6>Médicos</h6>
                <h2><?= $medicos ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-info">
            <div class="card-body">
                <h6>Serviços</h6>
                <h2><?= $servicos ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-info">
            <div class="card-body">
                <h6>Consultas hoje</h6>
                <h2><?= $consultasHoje ?></h2>
            </div>
        </div>
    </div>
</div>

<?php if (($usuario["perfil"] ?? "") === "Administrador"): ?>
<div class="card mt-4 border-warning">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-1">Solicitações de consultas online</h5>
            <p class="mb-0 text-muted">Existem <strong><?= (int)$consultasPendentes ?></strong> solicitações aguardando aprovação.</p>
        </div>
        <a href="index.php?pagina=solicitacoes" class="btn btn-warning">Ver solicitações</a>
    </div>
</div>
<?php endif; ?>

<div class="mt-4">
    <div class="alert alert-primary">
        Bem-vindo(a), <strong><?= escapar($usuario["nome"] ?? "") ?></strong>. Perfil: <strong><?= escapar($usuario["perfil"] ?? "") ?></strong>.
        Total de consultas cadastradas: <strong><?= $consultas ?></strong>
    </div>
</div>

<?php require __DIR__ . "/../layouts/rodape.php"; ?>
