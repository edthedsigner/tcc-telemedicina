<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nome *</label>
        <input type="text" name="nome" class="form-control"
               value="<?= escapar($medico["nome"] ?? "") ?>" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Especialidade *</label>
        <select name="especialidade_id" class="form-select" required>
            <option value="">Selecione</option>
            <?php foreach ($especialidades as $especialidade): ?>
                <option value="<?= $especialidade["id"] ?>"
                    <?= ((int)($medico["especialidade_id"] ?? 0) === (int)$especialidade["id"]) ? "selected" : "" ?>>
                    <?= escapar($especialidade["nome"]) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Telefone</label>
        <input type="text" name="telefone" class="form-control"
               value="<?= escapar($medico["telefone"] ?? "") ?>">
    </div>

    <div class="col-md-6">
        <label class="form-label">E-mail</label>
        <input type="email" name="email" class="form-control"
               value="<?= escapar($medico["email"] ?? "") ?>">
    </div>
</div>
