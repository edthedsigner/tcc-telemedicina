<?php
class Usuario
{
    private PDO $db;

    public function __construct()
    {
        $this->db = (new Database())->conectar();
    }

    public function procurarPorEmail(string $email)
    {
        $sql = "SELECT * FROM usuarios WHERE email = ? AND ativo = 1 LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function listar()
    {
        return $this->db->query(
            "SELECT id, nome, email, perfil, ativo, criado_em FROM usuarios ORDER BY nome"
        )->fetchAll();
    }

    public function buscar(int $id)
    {
        $stmt = $this->db->prepare("SELECT id, nome, email, perfil, ativo FROM usuarios WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function criar(string $nome, string $email, string $senha, string $perfil = "Recepcionista")
    {
        $hash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nome, email, senha, perfil)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nome, $email, $hash, $perfil]);
    }

    public function atualizar(int $id, string $nome, string $email, string $perfil, ?string $senha = null)
    {
        if ($senha !== null && $senha !== '') {
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios SET nome = ?, email = ?, perfil = ?, senha = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$nome, $email, $perfil, $hash, $id]);
        }

        $sql = "UPDATE usuarios SET nome = ?, email = ?, perfil = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nome, $email, $perfil, $id]);
    }

    public function alterarAtivo(int $id, int $ativo)
    {
        $stmt = $this->db->prepare("UPDATE usuarios SET ativo = ? WHERE id = ?");
        return $stmt->execute([$ativo, $id]);
    }

    public function contar()
    {
        return (int)$this->db->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
    }
}
