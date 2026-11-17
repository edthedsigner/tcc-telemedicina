<?php require __DIR__ . "/../layouts/cabecalho.php"; ?>
<?php require __DIR__ . "/../layouts/menu.php"; ?>

<h2>Editar médico</h2>

<form method="POST" action="index.php?pagina=medico_atualizar" class="card p-4">
    <input type="hidden" name="id" value="<?= $medico["id"] ?>">

    <?php require __DIR__ . "/formulario.php"; ?>

    <div class="mt-3">
        <button class="btn btn-primary">Atualizar</button>
        <a href="index.php?pagina=medicos" class="btn btn-secondary">Cancelar</a>
    </div>
</form>

<?php require __DIR__ . "/../layouts/rodape.php"; ?>
