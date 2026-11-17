<div class="row g-3">
    <div class="col-md-7">
        <label class="form-label">Nome *</label>
        <input type="text" name="nome" class="form-control"
               value="<?= escapar($servico["nome"] ?? "") ?>" required>
    </div>

    <div class="col-md-3">
        <label class="form-label">Tipo *</label>
        <select name="tipo" class="form-select" required>
            <?php foreach (["Consulta","Exame","Procedimento"] as $tipo): ?>
                <option value="<?= $tipo ?>"
                    <?= (($servico["tipo"] ?? "") === $tipo) ? "selected" : "" ?>>
                    <?= $tipo ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-2">
        <label class="form-label">Preço (Kz) *</label>
        <input type="number" step="0.01" min="0" name="preco" class="form-control"
               value="<?= escapar($servico["preco"] ?? "") ?>" required>
    </div>
</div>
