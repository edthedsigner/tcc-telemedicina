<?php
class Paciente
{
    private PDO $db;

    public function __construct()
    {
        $this->db = (new Database())->conectar();
    }

    public function listar(string $busca = "")
    {
        if ($busca !== "") {
            $sql = "SELECT * FROM pacientes
                    WHERE nome LIKE ? OR telefone LIKE ? OR documento LIKE ?
                    ORDER BY nome";
            $termo = "%{$busca}%";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$termo, $termo, $termo]);
            return $stmt->fetchAll();
        }

        return $this->db
            ->query("SELECT * FROM pacientes ORDER BY nome")
            ->fetchAll();
    }

    public function buscar(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM pacientes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function buscarPorDocumento(string $documento)
    {
        $stmt = $this->db->prepare("SELECT * FROM pacientes WHERE documento = ? LIMIT 1");
        $stmt->execute([$documento]);
        return $stmt->fetch();
    }

    public function criar(array $dados)
    {
        $sql = "INSERT INTO pacientes
                (nome, data_nascimento, sexo, telefone, email, endereco, documento, alergias, observacoes)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            $dados["nome"],
            $dados["data_nascimento"] ?: null,
            $dados["sexo"] ?: null,
            $dados["telefone"],
            $dados["email"],
            $dados["endereco"],
            $dados["documento"],
            $dados["alergias"],
            $dados["observacoes"]
        ]);

        return (int)$this->db->lastInsertId();
    }

    public function atualizar(int $id, array $dados)
    {
        $sql = "UPDATE pacientes SET
                    nome = ?,
                    data_nascimento = ?,
                    sexo = ?,
                    telefone = ?,
                    email = ?,
                    endereco = ?,
                    documento = ?,
                    alergias = ?,
                    observacoes = ?
                WHERE id = ?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $dados["nome"],
            $dados["data_nascimento"] ?: null,
            $dados["sexo"] ?: null,
            $dados["telefone"],
            $dados["email"],
            $dados["endereco"],
            $dados["documento"],
            $dados["alergias"],
            $dados["observacoes"],
            $id
        ]);
    }

    public function atualizarContato(int $id, string $nome, string $telefone, string $email): bool
    {
        $stmt = $this->db->prepare("UPDATE pacientes SET nome = ?, telefone = ?, email = ? WHERE id = ?");
        return $stmt->execute([$nome, $telefone, $email, $id]);
    }

    public function excluir(int $id)
    {
        $stmt = $this->db->prepare("DELETE FROM pacientes WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function contar()
    {
        return (int)$this->db->query("SELECT COUNT(*) FROM pacientes")->fetchColumn();
    }
}
