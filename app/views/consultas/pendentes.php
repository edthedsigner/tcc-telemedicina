<?php require __DIR__ . "/../layouts/cabecalho.php"; ?>
<?php require __DIR__ . "/../layouts/menu.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2>Solicitações de consultas online</h2>
        <p class="text-muted">Pedidos enviados pelos pacientes e aguardando aprovação.</p>
    </div>
</div>

<div class="table-responsive">
<table class="table table-bordered table-hover bg-white align-middle">
    <thead>
        <tr>
            <th>Paciente</th>
            <th>Telefone</th>
            <th>Especialidade</th>
            <th>Médico</th>
            <th>Serviço</th>
            <th>Data pretendida</th>
            <th>Motivo</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($consultas as $consulta): ?>
        <tr>
            <td>
                <strong><?= escapar($consulta["paciente"]) ?></strong><br>
                <small class="text-muted">Doc.: <?= escapar($consulta["documento"]) ?></small>
            </td>
            <td><?= escapar($consulta["telefone_paciente"]) ?><br><small class="text-muted"><?= escapar($consulta["email_paciente"]) ?></small></td>
            <td><?= escapar($consulta["especialidade"]) ?></td>
            <td><?= escapar($consulta["medico"]) ?></td>
            <td><?= escapar($consulta["servico"]) ?></td>
            <td><?= date("d/m/Y H:i", strtotime($consulta["data_consulta"])) ?></td>
            <td><?= escapar($consulta["motivo"] ?: "-") ?></td>
            <td class="text-nowrap">
                <a class="btn btn-sm btn-success"
                   href="index.php?pagina=consulta_aprovar&id=<?= $consulta["id"] ?>"
                   onclick="return confirm('Aprovar esta consulta?')">
                    Aprovar
                </a>
                <a class="btn btn-sm btn-danger"
                   href="index.php?pagina=consulta_recusar&id=<?= $consulta["id"] ?>"
                   onclick="return confirm('Recusar esta solicitação?')">
                    Recusar
                </a>
            </td>
        </tr>
    <?php endforeach; ?>

    <?php if (!$consultas): ?>
        <tr><td colspan="8" class="text-center py-4">Não existem solicitações pendentes.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
</div>

<?php require __DIR__ . "/../layouts/rodape.php"; ?>
