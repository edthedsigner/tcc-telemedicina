<?php
class UsuarioController
{
    public function login()
    {
        if (isset($_SESSION["usuario"])) {
            header("Location: index.php?pagina=inicio");
            exit;
        }

        require __DIR__ . "/../views/login/index.php";
    }

    public function entrar()
    {
        $email = trim($_POST["email"] ?? "");
        $senha = $_POST["senha"] ?? "";

        $model = new Usuario();
        $usuario = $model->procurarPorEmail($email);

        if ($usuario && password_verify($senha, $usuario["senha"])) {
            session_regenerate_id(true);
            $_SESSION["usuario"] = [
                "id" => $usuario["id"],
                "nome" => $usuario["nome"],
                "email" => $usuario["email"],
                "perfil" => $usuario["perfil"]
            ];

            header("Location: index.php?pagina=inicio");
            exit;
        }

        $erro = "E-mail ou senha incorretos.";
        require __DIR__ . "/../views/login/index.php";
    }

    public function sair()
    {
        $_SESSION = [];
        session_destroy();
        header("Location: index.php?pagina=login");
        exit;
    }

    public function inicio()
    {
        $pacientes = (new Paciente())->contar();
        $medicos = (new Medico())->contar();
        $servicos = (new Servico())->contar();
        $consultas = (new Consulta())->contar();
        $consultasHoje = (new Consulta())->contarHoje();
        $consultasPendentes = (new Consulta())->contarPendentes();

        require __DIR__ . "/../views/inicio/index.php";
    }

    public function index()
    {
        $usuarios = (new Usuario())->listar();
        require __DIR__ . "/../views/usuarios/index.php";
    }

    public function cadastrar()
    {
        require __DIR__ . "/../views/usuarios/cadastrar.php";
    }

    public function salvar()
    {
        $nome = trim($_POST["nome"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $senha = $_POST["senha"] ?? "";
        $perfil = $_POST["perfil"] ?? "";

        if ($nome === "" || !filter_var($email, FILTER_VALIDATE_EMAIL) || $senha === "") {
            die("Preencha nome, e-mail e senha corretamente.");
        }

        if (!in_array($perfil, ["Administrador", "Recepcionista", "Medico"], true)) {
            die("Perfil inválido.");
        }

        try {
            (new Usuario())->criar($nome, $email, $senha, $perfil);
            $_SESSION["mensagem"] = ["tipo" => "success", "texto" => "Utilizador criado com sucesso."];
            header("Location: index.php?pagina=usuarios");
            exit;
        } catch (PDOException $e) {
            die("Não foi possível criar o utilizador. Verifique se o e-mail já existe.");
        }
    }

    public function editar()
    {
        $id = (int)($_GET["id"] ?? 0);
        $usuario = (new Usuario())->buscar($id);

        if (!$usuario) {
            die("Utilizador não encontrado.");
        }

        require __DIR__ . "/../views/usuarios/editar.php";
    }

    public function atualizar()
    {
        $id = (int)($_POST["id"] ?? 0);
        $nome = trim($_POST["nome"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $senha = $_POST["senha"] ?? "";
        $perfil = $_POST["perfil"] ?? "";

        if ($id <= 0 || $nome === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Dados inválidos.");
        }

        if (!in_array($perfil, ["Administrador", "Recepcionista", "Medico"], true)) {
            die("Perfil inválido.");
        }

        try {
            (new Usuario())->atualizar($id, $nome, $email, $perfil, $senha !== "" ? $senha : null);
            $_SESSION["mensagem"] = ["tipo" => "success", "texto" => "Utilizador atualizado com sucesso."];
            header("Location: index.php?pagina=usuarios");
            exit;
        } catch (PDOException $e) {
            die("Não foi possível atualizar o utilizador. Verifique se o e-mail já existe.");
        }
    }

    public function alterarAtivo()
    {
        $id = (int)($_GET["id"] ?? 0);
        $ativo = (int)($_GET["ativo"] ?? 0);
        $logado = (int)($_SESSION["usuario"]["id"] ?? 0);

        if ($id === $logado) {
            die("Não é permitido desativar o próprio utilizador.");
        }

        (new Usuario())->alterarAtivo($id, $ativo ? 1 : 0);
        $_SESSION["mensagem"] = ["tipo" => "success", "texto" => "Estado do utilizador atualizado."];
        header("Location: index.php?pagina=usuarios");
        exit;
    }
}
