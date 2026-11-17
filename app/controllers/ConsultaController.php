<?php
class ConsultaController
{
    private Consulta $model;

    public function __construct()
    {
        $this->model = new Consulta();
    }

    public function index()
    {
        $consultas = $this->model->listar();
        require __DIR__ . "/../views/consultas/index.php";
    }

    public function cadastrar()
    {
        $pacientes = (new Paciente())->listar();
        $medicos = (new Medico())->listar();
        $servicos = (new Servico())->listar();

        require __DIR__ . "/../views/consultas/cadastrar.php";
    }

    public function salvar()
    {
        $this->model->criar($_POST);

        header("Location: index.php?pagina=consultas");
        exit;
    }

    public function pendentes()
    {
        $consultas = $this->model->listarPendentes();
        require __DIR__ . "/../views/consultas/pendentes.php";
    }

    public function alterarEstado()
    {
        $id = (int)($_GET["id"] ?? 0);
        $estado = $_GET["estado"] ?? "";

        $this->model->alterarEstado($id, $estado);

        header("Location: index.php?pagina=consultas");
        exit;
    }

    public function aprovar()
    {
        $this->processarResultadoOnline("Agendada");
    }

    public function recusar()
    {
        $this->processarResultadoOnline("Cancelada");
    }

    private function processarResultadoOnline(string $novoEstado)
    {
        $id = (int)($_GET["id"] ?? 0);
        $consulta = $this->model->buscarComDetalhes($id);

        if (!$consulta) {
            $_SESSION["mensagem"] = [
                "tipo" => "danger",
                "texto" => "Solicitação não encontrada."
            ];
            header("Location: index.php?pagina=solicitacoes");
            exit;
        }

        $alterado = $this->model->alterarEstado($id, $novoEstado);

        if (!$alterado) {
            $_SESSION["mensagem"] = [
                "tipo" => "danger",
                "texto" => "Não foi possível alterar o estado da consulta."
            ];
            header("Location: index.php?pagina=solicitacoes");
            exit;
        }

        try {
            $avisos = [];

            try {
                EmailService::enviarResultadoConsulta($consulta, $novoEstado);
                $avisos[] = "e-mail enviado";
            } catch (Throwable $e) {
                $avisos[] = "e-mail não enviado: " . $e->getMessage();
            }

            $_SESSION["mensagem"] = [
                "tipo" => "success",
                "texto" => ($novoEstado === "Agendada" ? "Consulta aprovada" : "Solicitação recusada") . ". " . implode("; ", $avisos) . "."
            ];
        } catch (Throwable $e) {
            $_SESSION["mensagem"] = [
                "tipo" => "warning",
                "texto" => $novoEstado === "Agendada"
                    ? "Consulta aprovada, mas o e-mail não foi enviado: " . $e->getMessage()
                    : "Solicitação recusada, mas o e-mail não foi enviado: " . $e->getMessage()
            ];
        }

        header("Location: index.php?pagina=solicitacoes");
        exit;
    }

    public function solicitar()
    {
        $especialidades = (new Especialidade())->listar();
        $medicos = (new Medico())->listar();
        $servicos = (new Servico())->listar();

        require __DIR__ . "/../views/consultas/solicitar.php";
    }

    public function enviarSolicitacao()
    {
        $dados = $_POST;

        if (trim($dados["nome"] ?? "") === "") {
            die("O nome do paciente é obrigatório.");
        }

        if (trim($dados["documento"] ?? "") === "") {
            die("O documento do paciente é obrigatório.");
        }

        $email = trim($dados["email"] ?? "");
        if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Informe um e-mail válido para receber a confirmação da consulta.");
        }

        if (empty($dados["medico_id"]) || empty($dados["servico_id"]) || empty($dados["data_consulta"])) {
            die("Preencha médico, serviço e data pretendida.");
        }

        $pacienteModel = new Paciente();
        $paciente = $pacienteModel->buscarPorDocumento(trim($dados["documento"]));

        if ($paciente) {
            $pacienteId = (int)$paciente["id"];

            // O e-mail informado nesta solicitação será o destinatário da notificação.
            $pacienteModel->atualizarContato(
                $pacienteId,
                trim($dados["nome"]),
                trim($dados["telefone"] ?? ""),
                $email
            );
        } else {
            $pacienteId = $pacienteModel->criar([
                "nome" => trim($dados["nome"]),
                "data_nascimento" => $dados["data_nascimento"] ?? "",
                "sexo" => $dados["sexo"] ?? "",
                "telefone" => trim($dados["telefone"] ?? ""),
                "email" => $email,
                "endereco" => trim($dados["endereco"] ?? ""),
                "documento" => trim($dados["documento"]),
                "alergias" => "",
                "observacoes" => ""
            ]);
        }

        $this->model->criarPendente([
            "paciente_id" => $pacienteId,
            "medico_id" => (int)$dados["medico_id"],
            "servico_id" => (int)$dados["servico_id"],
            "data_consulta" => $dados["data_consulta"],
            "motivo" => trim($dados["motivo"] ?? ""),
            "observacoes" => trim($dados["observacoes"] ?? "")
        ]);

        require __DIR__ . "/../views/consultas/sucesso.php";
    }
}
