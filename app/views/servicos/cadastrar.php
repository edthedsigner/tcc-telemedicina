<?php require __DIR__ . "/../layouts/cabecalho.php"; ?>
<?php require __DIR__ . "/../layouts/menu.php"; ?>

<h2>Novo serviço</h2>

<form method="POST" action="index.php?pagina=servico_salvar" class="card p-4">
    <?php require __DIR__ . "/formulario.php"; ?>

    <div class="mt-3">
        <button class="btn btn-primary">Guardar</button>
        <a href="index.php?pagina=servicos" class="btn btn-secondary">Cancelar</a>
    </div>
</form>

<?php require __DIR__ . "/../layouts/rodape.php"; ?>
