<?php require __DIR__ . "/../layouts/cabecalho.php"; ?>
<?php require __DIR__ . "/../layouts/menu.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2>Pacientes</h2>
        <p class="text-muted">Cadastro de pacientes.</p>
    </div>
    <a href="index.php?pagina=paciente_cadastrar" class="btn btn-primary">+ Novo paciente</a>
</div>

<form class="row g-2 mb-3" method="GET">
    <input type="hidden" name="pagina" value="pacientes">
    <div class="col-md-5">
        <input type="text" name="busca" value="<?= escapar($busca) ?>"
               class="form-control" placeholder="Pesquisar por nome, telefone ou documento">
    </div>
    <div class="col-auto">
        <button class="btn btn-secondary">Pesquisar</button>
    </div>
</form>

<div class="table-responsive">
<table class="table table-bordered table-hover bg-white">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>E-mail</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($pacientes as $paciente): ?>
        <tr>
            <td><?= $paciente["id"] ?></td>
            <td><?= escapar($paciente["nome"]) ?></td>
            <td><?= escapar($paciente["telefone"]) ?></td>
            <td><?= escapar($paciente["email"]) ?></td>
            <td>
                <a class="btn btn-sm btn-warning"
                   href="index.php?pagina=paciente_editar&id=<?= $paciente["id"] ?>">Editar</a>

                <a class="btn btn-sm btn-danger"
                   onclick="return confirm('Deseja excluir este paciente?')"
                   href="index.php?pagina=paciente_excluir&id=<?= $paciente["id"] ?>">Excluir</a>
            </td>
        </tr>
    <?php endforeach; ?>

    <?php if (!$pacientes): ?>
        <tr><td colspan="5" class="text-center">Nenhum paciente encontrado.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
</div>

<?php require __DIR__ . "/../layouts/rodape.php"; ?>
