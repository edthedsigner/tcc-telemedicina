<?php
class ServicoController
{
    private Servico $model;

    public function __construct()
    {
        $this->model = new Servico();
    }

    public function index()
    {
        $servicos = $this->model->listar();
        require __DIR__ . "/../views/servicos/index.php";
    }

    public function cadastrar()
    {
        require __DIR__ . "/../views/servicos/cadastrar.php";
    }

    public function salvar()
    {
        $this->model->criar($_POST);
        header("Location: index.php?pagina=servicos");
        exit;
    }

    public function editar()
    {
        $id = (int)($_GET["id"] ?? 0);
        $servico = $this->model->buscar($id);

        if (!$servico) {
            die("Serviço não encontrado.");
        }

        require __DIR__ . "/../views/servicos/editar.php";
    }

    public function atualizar()
    {
        $id = (int)($_POST["id"] ?? 0);
        $this->model->atualizar($id, $_POST);

        header("Location: index.php?pagina=servicos");
        exit;
    }

    public function excluir()
    {
        $id = (int)($_GET["id"] ?? 0);

        try {
            $this->model->excluir($id);
        } catch (PDOException $e) {
            die("Não é possível excluir este serviço porque ele possui consultas.");
        }

        header("Location: index.php?pagina=servicos");
        exit;
    }
}
