<?php
class Servico
{
    private PDO $db;

    public function __construct()
    {
        $this->db = (new Database())->conectar();
    }

    public function listar()
    {
        return $this->db
            ->query("SELECT * FROM servicos ORDER BY tipo, nome")
            ->fetchAll();
    }

    public function buscar(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM servicos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function criar(array $dados)
    {
        $sql = "INSERT INTO servicos (nome, tipo, preco, ativo)
                VALUES (?, ?, ?, 1)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $dados["nome"],
            $dados["tipo"],
            $dados["preco"]
        ]);
    }

    public function atualizar(int $id, array $dados)
    {
        $sql = "UPDATE servicos SET nome = ?, tipo = ?, preco = ?
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $dados["nome"],
            $dados["tipo"],
            $dados["preco"],
            $id
        ]);
    }

    public function excluir(int $id)
    {
        $stmt = $this->db->prepare("DELETE FROM servicos WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function contar()
    {
        return (int)$this->db->query("SELECT COUNT(*) FROM servicos")->fetchColumn();
    }
}
