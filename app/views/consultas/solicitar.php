<?php require __DIR__ . "/../layouts/cabecalho.php"; ?>

<div class="container py-5" style="max-width: 950px;">
    <div class="text-center mb-4">
        <h2>Solicitar consulta online</h2>
        <p class="text-muted">Preencha os dados. A consulta só será confirmada após análise do administrador da clínica.</p>
    </div>

    <form method="POST" action="index.php?pagina=enviar_solicitacao" class="card shadow-sm p-4">
        <h5 class="mb-3">Dados do paciente</h5>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nome completo *</label>
                <input type="text" name="nome" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Documento *</label>
                <input type="text" name="documento" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Data de nascimento</label>
                <input type="date" name="data_nascimento" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Sexo</label>
                <select name="sexo" class="form-select">
                    <option value="">Selecione</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Feminino">Feminino</option>
                    <option value="Outro">Outro</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Telefone *</label>
                <input type="text" name="telefone" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" required>
                <div class="form-text">Este e-mail será usado automaticamente para enviar a confirmação ou recusa da consulta.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Endereço</label>
                <input type="text" name="endereco" class="form-control">
            </div>
            <div class="col-12">
                <div class="form-text">O número deve incluir o indicativo do país, por exemplo: +244 923 000 000.</div>
            </div>
        </div>

        <hr class="my-4">
        <h5 class="mb-3">Dados da consulta</h5>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Especialidade *</label>
                <select id="especialidade_id" class="form-select" required>
                    <option value="">Selecione a especialidade</option>
                    <?php foreach ($especialidades as $especialidade): ?>
                        <option value="<?= $especialidade["id"] ?>"><?= escapar($especialidade["nome"]) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Médico *</label>
                <select name="medico_id" id="medico_id" class="form-select" required>
                    <option value="">Selecione primeiro a especialidade</option>
                    <?php foreach ($medicos as $medico): ?>
                        <?php if ((int)$medico["ativo"] === 1): ?>
                            <option value="<?= $medico["id"] ?>" data-especialidade="<?= $medico["especialidade_id"] ?>" style="display:none">
                                <?= escapar($medico["nome"]) ?> - <?= escapar($medico["especialidade"]) ?>
                            </option>
                        <?php endif; ?>
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
                                <?= escapar($servico["nome"]) ?> - <?= number_format($servico["preco"], 2, ",", ".") ?> Kz
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Data e hora pretendida *</label>
                <input type="datetime-local" name="data_consulta" class="form-control" required>
            </div>

            <div class="col-12">
                <label class="form-label">Motivo da consulta</label>
                <input type="text" name="motivo" class="form-control">
            </div>

            <div class="col-12">
                <label class="form-label">Observações</label>
                <textarea name="observacoes" class="form-control" rows="3"></textarea>
            </div>
        </div>

        <div class="alert alert-info mt-4 mb-0">
            <strong>Importante:</strong> esta é apenas uma solicitação. A clínica irá analisar a disponibilidade e aprovar ou recusar o pedido.
        </div>

        <div class="mt-4">
            <button class="btn btn-primary">Enviar solicitação</button>
            <a href="index.php?pagina=login" class="btn btn-secondary">Voltar</a>
        </div>
    </form>
</div>

<script>
const especialidade = document.getElementById('especialidade_id');
const medico = document.getElementById('medico_id');

especialidade.addEventListener('change', function () {
    const id = this.value;
    medico.value = '';

    Array.from(medico.options).forEach(function (option) {
        if (!option.dataset.especialidade) return;
        option.style.display = option.dataset.especialidade === id ? '' : 'none';
    });
});
</script>

<?php require __DIR__ . "/../layouts/rodape.php"; ?>
