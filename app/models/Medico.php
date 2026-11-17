<?php
class Medico
{
    private PDO $db;

    public function __construct()
    {
        $this->db = (new Database())->conectar();
    }

    public function listar()
    {
        $sql = "SELECT m.*, e.nome AS especialidade
                FROM medicos m
                INNER JOIN especialidades e ON e.id = m.especialidade_id
                ORDER BY m.nome";

        return $this->db->query($sql)->fetchAll();
    }

    public function buscar(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM medicos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function criar(array $dados)
    {
        $sql = "INSERT INTO medicos
                (nome, especialidade_id, telefone, email, ativo)
                VALUES (?, ?, ?, ?, 1)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $dados["nome"],
            $dados["especialidade_id"],
            $dados["telefone"],
            $dados["email"]
        ]);
    }

    public function atualizar(int $id, array $dados)
    {
        $sql = "UPDATE medicos
                SET nome = ?, especialidade_id = ?, telefone = ?, email = ?
                WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $dados["nome"],
            $dados["especialidade_id"],
            $dados["telefone"],
            $dados["email"],
            $id
        ]);
    }

    public function excluir(int $id)
    {
        $stmt = $this->db->prepare("DELETE FROM medicos WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function contar()
    {
        return (int)$this->db->query("SELECT COUNT(*) FROM medicos")->fetchColumn();
    }
}
