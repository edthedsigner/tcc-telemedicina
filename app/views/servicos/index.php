<?php require __DIR__ . "/../layouts/cabecalho.php"; ?>
<?php require __DIR__ . "/../layouts/menu.php"; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2>Serviços</h2>
        <p class="text-muted">Consultas, exames e procedimentos.</p>
    </div>
    <a href="index.php?pagina=servico_cadastrar" class="btn btn-primary">+ Novo serviço</a>
</div>

<table class="table table-bordered table-hover bg-white">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Tipo</th>
            <th>Preço</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($servicos as $servico): ?>
        <tr>
            <td><?= escapar($servico["nome"]) ?></td>
            <td><?= escapar($servico["tipo"]) ?></td>
            <td><?= number_format($servico["preco"], 2, ",", ".") ?> Kz</td>
            <td>
                <a class="btn btn-sm btn-warning"
                   href="index.php?pagina=servico_editar&id=<?= $servico["id"] ?>">Editar</a>
                <a class="btn btn-sm btn-danger"
                   onclick="return confirm('Deseja excluir este serviço?')"
                   href="index.php?pagina=servico_excluir&id=<?= $servico["id"] ?>">Excluir</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php require __DIR__ . "/../layouts/rodape.php"; ?>
