<?php require __DIR__ . "/../layouts/cabecalho.php"; ?>

<div class="container py-5" style="max-width: 700px;">
    <div class="card shadow-sm text-center p-5">
        <div class="display-5 mb-3">✓</div>
        <h2>Solicitação enviada!</h2>
        <p class="text-muted mt-3">
            A sua solicitação de consulta foi registrada com o estado <strong>Pendente</strong>.
            Aguarde a confirmação da clínica.
        </p>
        <div class="mt-3">
            <a href="index.php?pagina=solicitar_consulta" class="btn btn-primary">Fazer outra solicitação</a>
            <a href="index.php?pagina=login" class="btn btn-secondary">Área administrativa</a>
        </div>
    </div>
</div>

<?php require __DIR__ . "/../layouts/rodape.php"; ?>
