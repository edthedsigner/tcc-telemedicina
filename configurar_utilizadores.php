<?php
/**
 * Configuração inicial dos utilizadores internos.
 * Execute UMA vez e apague este arquivo depois.
 */
require_once __DIR__ . '/config/Database.php';

$utilizadores = [
    [
        'nome' => 'Administrador',
        'email' => 'admin@sigconsulta.com',
        'senha' => '123456',
        'perfil' => 'Administrador'
    ],
    [
        'nome' => 'Recepcionista',
        'email' => 'ana@clinica.com',
        'senha' => '123456',
        'perfil' => 'Recepcionista'
    ],
    [
        'nome' => 'Medico',
        'email' => 'joao@clinica.com',
        'senha' => '123456',
        'perfil' => 'Medico'
    ]
];

try {
    $db = (new Database())->conectar();

    $buscar = $db->prepare('SELECT id FROM usuarios WHERE email = ? LIMIT 1');
    $inserir = $db->prepare(
        'INSERT INTO usuarios (nome, email, senha, perfil, ativo) VALUES (?, ?, ?, ?, 1)'
    );
    $atualizar = $db->prepare(
        'UPDATE usuarios SET nome = ?, senha = ?, perfil = ?, ativo = 1 WHERE id = ?'
    );
    $verificar = $db->prepare('SELECT id, nome, email, senha, perfil, ativo FROM usuarios WHERE email = ? LIMIT 1');

    echo '<!doctype html><html lang="pt"><head><meta charset="utf-8"><title>Configurar utilizadores</title>';
    echo '<style>body{font-family:Arial,sans-serif;background:#f5f5f5;padding:30px;color:#222}.box{max-width:850px;margin:auto;background:#fff;padding:30px;border-radius:12px;box-shadow:0 2px 12px #ccc}table{width:100%;border-collapse:collapse;margin-top:20px}th,td{padding:10px;border:1px solid #ddd;text-align:left}th{background:#eee}.ok{color:#087f23;font-weight:bold}.warn{color:#b45309;font-weight:bold}.btn{display:inline-block;margin-top:20px;padding:12px 18px;background:#0d6efd;color:#fff;text-decoration:none;border-radius:7px}</style></head><body><div class="box">';
    echo '<h1>Utilizadores configurados</h1>';
    echo '<p>Os três utilizadores foram criados ou atualizados na base <strong>sig_consulta</strong>.</p>';
    echo '<table><tr><th>Perfil</th><th>E-mail</th><th>Senha</th><th>Resultado</th></tr>';

    foreach ($utilizadores as $u) {
        $hash = password_hash($u['senha'], PASSWORD_DEFAULT);

        $buscar->execute([$u['email']]);
        $existente = $buscar->fetch();

        if ($existente) {
            $atualizar->execute([$u['nome'], $hash, $u['perfil'], $existente['id']]);
            $resultado = 'Atualizado';
        } else {
            $inserir->execute([$u['nome'], $u['email'], $hash, $u['perfil']]);
            $resultado = 'Criado';
        }

        $verificar->execute([$u['email']]);
        $registro = $verificar->fetch();
        $senhaOk = $registro && password_verify($u['senha'], $registro['senha']);

        echo '<tr>';
        echo '<td>' . htmlspecialchars($u['perfil'], ENT_QUOTES, 'UTF-8') . '</td>';
        echo '<td>' . htmlspecialchars($u['email'], ENT_QUOTES, 'UTF-8') . '</td>';
        echo '<td>123456</td>';
        echo '<td class="' . ($senhaOk ? 'ok' : 'warn') . '">' . htmlspecialchars($resultado, ENT_QUOTES, 'UTF-8') . ($senhaOk ? ' — senha verificada' : ' — ERRO na verificação') . '</td>';
        echo '</tr>';
    }

    echo '</table>';
    echo '<p class="ok">Se os três resultados mostrarem “senha verificada”, o login está pronto.</p>';
    echo '<p><strong>Apague este arquivo depois de executar.</strong></p>';
    echo '<a class="btn" href="public/index.php?pagina=login">Ir para o login</a>';
    echo '</div></body></html>';
} catch (Throwable $e) {
    http_response_code(500);
    echo '<h2>Erro ao configurar os utilizadores</h2>';
    echo '<pre>' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</pre>';
}
