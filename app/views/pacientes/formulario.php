<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Nome completo *</label>
        <input type="text" name="nome" class="form-control"
               value="<?= escapar($paciente["nome"] ?? "") ?>" required>
    </div>

    <div class="col-md-4">
        <label class="form-label">Documento</label>
        <input type="text" name="documento" class="form-control"
               value="<?= escapar($paciente["documento"] ?? "") ?>">
    </div>

    <div class="col-md-4">
        <label class="form-label">Data de nascimento</label>
        <input type="date" name="data_nascimento" class="form-control"
               value="<?= escapar($paciente["data_nascimento"] ?? "") ?>">
    </div>

    <div class="col-md-4">
        <label class="form-label">Sexo</label>
        <select name="sexo" class="form-select">
            <option value="">Selecione</option>
            <?php foreach (["Masculino","Feminino","Outro"] as $sexo): ?>
                <option value="<?= $sexo ?>"
                    <?= (($paciente["sexo"] ?? "") === $sexo) ? "selected" : "" ?>>
                    <?= $sexo ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Telefone</label>
        <input type="text" name="telefone" class="form-control"
               value="<?= escapar($paciente["telefone"] ?? "") ?>">
    </div>

    <div class="col-md-6">
        <label class="form-label">E-mail</label>
        <input type="email" name="email" class="form-control"
               value="<?= escapar($paciente["email"] ?? "") ?>">
    </div>

    <div class="col-md-6">
        <label class="form-label">Endereço</label>
        <input type="text" name="endereco" class="form-control"
               value="<?= escapar($paciente["endereco"] ?? "") ?>">
    </div>

    <div class="col-md-6">
        <label class="form-label">Alergias</label>
        <input type="text" name="alergias" class="form-control"
               value="<?= escapar($paciente["alergias"] ?? "") ?>">
    </div>

    <div class="col-md-12">
        <label class="form-label">Observações</label>
        <textarea name="observacoes" class="form-control"><?= escapar($paciente["observacoes"] ?? "") ?></textarea>
    </div>
</div>
