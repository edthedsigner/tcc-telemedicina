<?php require __DIR__ . "/../layouts/cabecalho.php"; ?>
<?php require __DIR__ . "/../layouts/menu.php"; ?>

<h2>Nova consulta</h2>

<form method="POST" action="index.php?pagina=consulta_salvar" class="card p-4">
    <div class="row g-3">

        <div class="col-md-6">
            <label class="form-label">Paciente *</label>
            <select name="paciente_id" class="form-select" required>
                <option value="">Selecione o paciente</option>
                <?php foreach ($pacientes as $paciente): ?>
                    <option value="<?= $paciente["id"] ?>">
                        <?= escapar($paciente["nome"]) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Médico *</label>
            <select name="medico_id" class="form-select" required>
                <option value="">Selecione o médico</option>
                <?php foreach ($medicos as $medico): ?>
                    <option value="<?= $medico["id"] ?>">
                        <?= escapar($medico["nome"]) ?> -
                        <?= escapar($medico["especialidade"]) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Serviço *</label>
            <select name="servico_id" class="form-select" required>
                <option value="">Selecione o serviço</option>
                <?php foreach ($servicos as $servico): ?>
                    <?php if ((int)$servico["ativo"] === 1): ?>
                        <option value="<?= $servico["id"] ?>">
                            <?= escapar($servico["nome"]) ?> -
                            <?= number_format($servico["preco"], 2, ",", ".") ?> Kz
                        </option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Data e hora *</label>
            <input type="datetime-local" name="data_consulta"
                   class="form-control" required>
        </div>

        <div class="col-md-12">
            <label class="form-label">Motivo</label>
            <input type="text" name="motivo" class="form-control">
        </div>

        <div class="col-md-12">
            <label class="form-label">Observações</label>
            <textarea name="observacoes" class="form-control"></textarea>
        </div>
    </div>

    <div class="mt-3">
        <button class="btn btn-primary">Agendar consulta</button>
        <a href="index.php?pagina=consultas" class="btn btn-secondary">Cancelar</a>
    </div>
</form>

<?php require __DIR__ . "/../layouts/rodape.php"; ?>
