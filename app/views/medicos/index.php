<?php require __DIR__ . "/../layouts/cabecalho.php"; ?>
<?php require __DIR__ . "/../layouts/menu.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2>Médicos</h2>
        <p class="text-muted">Cadastro dos médicos da clínica.</p>
    </div>
    <a href="index.php?pagina=medico_cadastrar" class="btn btn-primary">+ Novo médico</a>
</div>

<table class="table table-bordered table-hover bg-white">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Especialidade</th>
            <th>Telefone</th>
            <th>E-mail</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($medicos as $medico): ?>
        <tr>
            <td><?= escapar($medico["nome"]) ?></td>
            <td><?= escapar($medico["especialidade"]) ?></td>
            <td><?= escapar($medico["telefone"]) ?></td>
            <td><?= escapar($medico["email"]) ?></td>
            <td>
                <a class="btn btn-sm btn-warning"
                   href="index.php?pagina=medico_editar&id=<?= $medico["id"] ?>">Editar</a>
                <a class="btn btn-sm btn-danger"
                   onclick="return confirm('Deseja excluir este médico?')"
                   href="index.php?pagina=medico_excluir&id=<?= $medico["id"] ?>">Excluir</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php require __DIR__ . "/../layouts/rodape.php"; ?>
