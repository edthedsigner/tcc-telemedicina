<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class EmailService
{
    public static function enviarResultadoConsulta(array $consulta, string $estado): bool
    {
        $autoload = __DIR__ . "/../../vendor/autoload.php";

        if (!file_exists($autoload)) {
            throw new RuntimeException(
                "PHPMailer não está instalado. Execute 'composer install' na pasta do projeto."
            );
        }

        require_once $autoload;

        $config = require __DIR__ . "/../../config/email.php";

        $emailPaciente = trim((string)($consulta["email_paciente"] ?? ""));
        if ($emailPaciente === "" || !filter_var($emailPaciente, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException("O paciente não possui um e-mail válido cadastrado.");
        }

        $mail = new PHPMailer(true);
        $mail->CharSet = "UTF-8";
        $mail->isSMTP();
        $mail->Host = $config["host"];
        $mail->SMTPAuth = true;
        $mail->Username = $config["username"];
        $mail->Password = $config["password"];
        $mail->Port = (int)$config["port"];

        if (($config["encryption"] ?? "") === "ssl") {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        } else {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }

        // Remetente fixo: a conta SMTP da clínica.
        $mail->setFrom($config["from_email"], $config["from_name"]);
        $mail->addReplyTo($config["from_email"], $config["from_name"]);

        // Destinatário automático: o e-mail informado pelo paciente e guardado na tabela pacientes.
        $mail->addAddress($emailPaciente, $consulta["paciente"] ?? "Paciente");
        $mail->isHTML(true);

        $aprovada = $estado === "Agendada";
        $mail->Subject = $aprovada
            ? "SIG Consulta - Consulta aprovada"
            : "SIG Consulta - Solicitação de consulta";

        $nome = htmlspecialchars((string)$consulta["paciente"], ENT_QUOTES, "UTF-8");
        $especialidade = htmlspecialchars((string)$consulta["especialidade"], ENT_QUOTES, "UTF-8");
        $medico = htmlspecialchars((string)$consulta["medico"], ENT_QUOTES, "UTF-8");
        $servico = htmlspecialchars((string)$consulta["servico"], ENT_QUOTES, "UTF-8");
        $data = date("d/m/Y H:i", strtotime($consulta["data_consulta"]));

        if ($aprovada) {
            $titulo = "Consulta aprovada";
            $mensagem = "A sua solicitação de consulta foi aprovada pela clínica.";
            $corEstado = "success";
            $estadoTexto = "AGENDADA";
        } else {
            $titulo = "Solicitação de consulta";
            $mensagem = "Informamos que a sua solicitação de consulta não foi aprovada neste momento. Entre em contacto com a clínica para obter mais informações.";
            $corEstado = "danger";
            $estadoTexto = "CANCELADA";
        }

        $mail->Body = "
            <div style='font-family:Arial,sans-serif;max-width:650px;margin:auto;'>
                <h2 style='margin-bottom:5px;'>SIG Consulta</h2>
                <p>Olá, <strong>{$nome}</strong>.</p>
                <h3>{$titulo}</h3>
                <p>{$mensagem}</p>
                <table cellpadding='8' cellspacing='0' style='border-collapse:collapse;width:100%;'>
                    <tr><td><strong>Especialidade</strong></td><td>{$especialidade}</td></tr>
                    <tr><td><strong>Médico</strong></td><td>{$medico}</td></tr>
                    <tr><td><strong>Serviço</strong></td><td>{$servico}</td></tr>
                    <tr><td><strong>Data/Hora</strong></td><td>{$data}</td></tr>
                    <tr><td><strong>Estado</strong></td><td><strong>{$estadoTexto}</strong></td></tr>
                </table>
                <p style='margin-top:25px;'>Obrigado por utilizar o SIG Consulta.</p>
            </div>
        ";

        $mail->AltBody = "SIG Consulta\n\nOlá, {$consulta["paciente"]}.\n\n{$mensagem}\n\nEspecialidade: {$consulta["especialidade"]}\nMédico: {$consulta["medico"]}\nServiço: {$consulta["servico"]}\nData/Hora: {$data}\nEstado: {$estadoTexto}";

        try {
            return $mail->send();
        } catch (Exception $e) {
            throw new RuntimeException("Não foi possível enviar o e-mail: " . $mail->ErrorInfo);
        }
    }
}
