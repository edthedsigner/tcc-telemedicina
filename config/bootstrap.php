<?php
session_start();

require_once __DIR__ . "/Database.php";

require_once __DIR__ . "/../app/models/Usuario.php";
require_once __DIR__ . "/../app/models/Paciente.php";
require_once __DIR__ . "/../app/models/Especialidade.php";
require_once __DIR__ . "/../app/models/Medico.php";
require_once __DIR__ . "/../app/models/Servico.php";
require_once __DIR__ . "/../app/models/Consulta.php";

require_once __DIR__ . "/../app/controllers/UsuarioController.php";
require_once __DIR__ . "/../app/controllers/PacienteController.php";
require_once __DIR__ . "/../app/controllers/MedicoController.php";
require_once __DIR__ . "/../app/controllers/ServicoController.php";
require_once __DIR__ . "/../app/controllers/ConsultaController.php";
require_once __DIR__ . "/../app/services/EmailService.php";

function proteger()
{
    if (!isset($_SESSION["usuario"])) {
        header("Location: index.php?pagina=login");
        exit;
    }
}

function protegerPerfis(array $perfis)
{
    proteger();

    $perfil = $_SESSION["usuario"]["perfil"] ?? "";
    if (!in_array($perfil, $perfis, true)) {
        http_response_code(403);
        die("Acesso negado. O seu perfil não possui permissão para esta área.");
    }
}

function protegerAdministrador()
{
    protegerPerfis(["Administrador"]);
}

function protegerAdminRecepcao()
{
    protegerPerfis(["Administrador", "Recepcionista"]);
}

function protegerAdminRecepcaoMedico()
{
    protegerPerfis(["Administrador", "Recepcionista", "Medico"]);
}

function usuarioLogado()
{
    return $_SESSION["usuario"] ?? null;
}

function escapar($valor)
{
    return htmlspecialchars((string)$valor, ENT_QUOTES, "UTF-8");
}
