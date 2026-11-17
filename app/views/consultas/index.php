<?php require __DIR__ . "/../layouts/cabecalho.php"; ?>
<?php require __DIR__ . "/../layouts/menu.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2>Consultas</h2>
        <p class="text-muted">Agenda de consultas da clínica.</p>
    </div>
    <?php if (in_array(($usuario["perfil"] ?? ""), ["Administrador", "Recepcionista"], true)): ?>
        <a href="index.php?pagina=consulta_cadastrar" class="btn btn-primary">+ Nova consulta</a>
    <?php endif; ?>
</div>

<div class="table-responsive">
<table class="table table-bordered table-hover bg-white">
    <thead>
        <tr>
            <th>Data</th>
            <th>Paciente</th>
            <th>Médico</th>
            <th>Serviço</th>
            <th>Preço</th>
            <th>Estado</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($consultas as $consulta): ?>
        <tr>
            <td><?= date("d/m/Y H:i", strtotime($consulta["data_consulta"])) ?></td>
            <td><?= escapar($consulta["paciente"]) ?></td>
            <td><?= escapar($consulta["medico"]) ?></td>
            <td><?= escapar($consulta["servico"]) ?></td>
            <td><?= number_format($consulta["preco"], 2, ",", ".") ?> Kz</td>
            <td>
                <?php
                $classe = match ($consulta["estado"]) {
                    "Realizada" => "success",
                    "Cancelada" => "danger",
                    "Confirmada" => "info",
                    "Agendada" => "primary",
                    default => "warning"
                };
                ?>
                <span class="badge text-bg-<?= $classe ?>">
                    <?= escapar($consulta["estado"]) ?>
                </span>
            </td>
            <td>
                <?php if (($usuario["perfil"] ?? "") === "Medico"): ?>
                    <span class="text-muted">Somente visualização</span>
                <?php elseif ($consulta["estado"] === "Pendente"): ?>
                    <span class="text-muted">Aguardando aprovação</span>
                <?php elseif ($consulta["estado"] === "Agendada"): ?>
                    <a class="btn btn-sm btn-info" href="index.php?pagina=consulta_estado&id=<?= $consulta["id"] ?>&estado=Confirmada">Confirmar</a>
                <?php elseif ($consulta["estado"] === "Confirmada"): ?>
                    <a class="btn btn-sm btn-success" href="index.php?pagina=consulta_estado&id=<?= $consulta["id"] ?>&estado=Realizada">Realizada</a>
                <?php endif; ?>

                <?php if (($usuario["perfil"] ?? "") !== "Medico" && $consulta["estado"] !== "Cancelada" && $consulta["estado"] !== "Realizada"): ?>
                    <a class="btn btn-sm btn-danger" href="index.php?pagina=consulta_estado&id=<?= $consulta["id"] ?>&estado=Cancelada">Cancelar</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>

    <?php if (!$consultas): ?>
        <tr><td colspan="7" class="text-center">Nenhuma consulta cadastrada.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
</div>

<?php require __DIR__ . "/../layouts/rodape.php"; ?>
