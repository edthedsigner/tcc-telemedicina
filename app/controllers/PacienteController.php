<?php
class PacienteController
{
    private Paciente $model;

    public function __construct()
    {
        $this->model = new Paciente();
    }

    public function index()
    {
        $busca = trim($_GET["busca"] ?? "");
        $pacientes = $this->model->listar($busca);

        require __DIR__ . "/../views/pacientes/index.php";
    }

    public function cadastrar()
    {
        require __DIR__ . "/../views/pacientes/cadastrar.php";
    }

    public function salvar()
    {
        $dados = $_POST;

        if (trim($dados["nome"] ?? "") === "") {
            die("O nome do paciente é obrigatório.");
        }

        $this->model->criar($dados);

        header("Location: index.php?pagina=pacientes");
        exit;
    }

    public function editar()
    {
        $id = (int)($_GET["id"] ?? 0);
        $paciente = $this->model->buscar($id);

        if (!$paciente) {
            die("Paciente não encontrado.");
        }

        require __DIR__ . "/../views/pacientes/editar.php";
    }

    public function atualizar()
    {
        $id = (int)($_POST["id"] ?? 0);
        $this->model->atualizar($id, $_POST);

        header("Location: index.php?pagina=pacientes");
        exit;
    }

    public function excluir()
    {
        $id = (int)($_GET["id"] ?? 0);

        try {
            $this->model->excluir($id);
        } catch (PDOException $e) {
            die("Não é possível excluir este paciente porque ele possui consultas.");
        }

        header("Location: index.php?pagina=pacientes");
        exit;
    }
}
