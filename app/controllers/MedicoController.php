<?php
class MedicoController
{
    private Medico $model;

    public function __construct()
    {
        $this->model = new Medico();
    }

    public function index()
    {
        $medicos = $this->model->listar();
        $especialidades = (new Especialidade())->listar();

        require __DIR__ . "/../views/medicos/index.php";
    }

    public function cadastrar()
    {
        $especialidades = (new Especialidade())->listar();
        require __DIR__ . "/../views/medicos/cadastrar.php";
    }

    public function salvar()
    {
        $this->model->criar($_POST);
        header("Location: index.php?pagina=medicos");
        exit;
    }

    public function editar()
    {
        $id = (int)($_GET["id"] ?? 0);
        $medico = $this->model->buscar($id);
        $especialidades = (new Especialidade())->listar();

        if (!$medico) {
            die("Médico não encontrado.");
        }

        require __DIR__ . "/../views/medicos/editar.php";
    }

    public function atualizar()
    {
        $id = (int)($_POST["id"] ?? 0);
        $this->model->atualizar($id, $_POST);

        header("Location: index.php?pagina=medicos");
        exit;
    }

    public function excluir()
    {
        $id = (int)($_GET["id"] ?? 0);

        try {
            $this->model->excluir($id);
        } catch (PDOException $e) {
            die("Não é possível excluir este médico porque ele possui consultas.");
        }

        header("Location: index.php?pagina=medicos");
        exit;
    }
}
