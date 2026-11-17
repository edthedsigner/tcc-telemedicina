<?php
class Consulta
{
    private PDO $db;

    public function __construct()
    {
        $this->db = (new Database())->conectar();
    }

    public function listar()
    {
        $sql = "SELECT
                    c.*,
                    p.nome AS paciente,
                    p.telefone AS telefone_paciente,
                    p.email AS email_paciente,
                    m.nome AS medico,
                    e.nome AS especialidade,
                    s.nome AS servico,
                    s.preco
                FROM consultas c
                INNER JOIN pacientes p ON p.id = c.paciente_id
                INNER JOIN medicos m ON m.id = c.medico_id
                INNER JOIN especialidades e ON e.id = m.especialidade_id
                INNER JOIN servicos s ON s.id = c.servico_id
                ORDER BY c.data_consulta DESC";

        return $this->db->query($sql)->fetchAll();
    }

    public function listarPendentes()
    {
        $sql = "SELECT
                    c.*,
                    p.nome AS paciente,
                    p.telefone AS telefone_paciente,
                    p.email AS email_paciente,
                    p.documento,
                    m.nome AS medico,
                    e.nome AS especialidade,
                    s.nome AS servico,
                    s.preco
                FROM consultas c
                INNER JOIN pacientes p ON p.id = c.paciente_id
                INNER JOIN medicos m ON m.id = c.medico_id
                INNER JOIN especialidades e ON e.id = m.especialidade_id
                INNER JOIN servicos s ON s.id = c.servico_id
                WHERE c.estado = 'Pendente'
                ORDER BY c.data_consulta ASC";

        return $this->db->query($sql)->fetchAll();
    }

    public function criar(array $dados)
    {
        $sql = "INSERT INTO consultas
                (paciente_id, medico_id, servico_id, data_consulta, estado, motivo, observacoes)
                VALUES (?, ?, ?, ?, 'Agendada', ?, ?)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $dados["paciente_id"],
            $dados["medico_id"],
            $dados["servico_id"],
            $dados["data_consulta"],
            $dados["motivo"],
            $dados["observacoes"]
        ]);
    }

    public function criarPendente(array $dados)
    {
        $sql = "INSERT INTO consultas
                (paciente_id, medico_id, servico_id, data_consulta, estado, motivo, observacoes)
                VALUES (?, ?, ?, ?, 'Pendente', ?, ?)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $dados["paciente_id"],
            $dados["medico_id"],
            $dados["servico_id"],
            $dados["data_consulta"],
            $dados["motivo"],
            $dados["observacoes"]
        ]);
    }

    public function buscarComDetalhes(int $id)
    {
        $sql = "SELECT
                    c.*,
                    p.nome AS paciente,
                    p.email AS email_paciente,
                    p.telefone AS telefone_paciente,
                    m.nome AS medico,
                    e.nome AS especialidade,
                    s.nome AS servico
                FROM consultas c
                INNER JOIN pacientes p ON p.id = c.paciente_id
                INNER JOIN medicos m ON m.id = c.medico_id
                INNER JOIN especialidades e ON e.id = m.especialidade_id
                INNER JOIN servicos s ON s.id = c.servico_id
                WHERE c.id = ?
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function alterarEstado(int $id, string $estado)
    {
        $permitidos = ["Pendente", "Agendada", "Confirmada", "Realizada", "Cancelada"];

        if (!in_array($estado, $permitidos, true)) {
            return false;
        }

        $stmt = $this->db->prepare(
            "UPDATE consultas SET estado = ? WHERE id = ?"
        );

        return $stmt->execute([$estado, $id]);
    }

    public function contar()
    {
        return (int)$this->db
            ->query("SELECT COUNT(*) FROM consultas")
            ->fetchColumn();
    }

    public function contarPendentes()
    {
        return (int)$this->db
            ->query("SELECT COUNT(*) FROM consultas WHERE estado = 'Pendente'")
            ->fetchColumn();
    }

    public function contarHoje()
    {
        $sql = "SELECT COUNT(*)
                FROM consultas
                WHERE DATE(data_consulta) = CURDATE()
                AND estado NOT IN ('Cancelada', 'Pendente')";

        return (int)$this->db->query($sql)->fetchColumn();
    }
}
