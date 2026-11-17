<?php
class Especialidade
{
    private PDO $db;

    public function __construct()
    {
        $this->db = (new Database())->conectar();
    }

    public function listar()
    {
        return $this->db
            ->query("SELECT * FROM especialidades ORDER BY nome")
            ->fetchAll();
    }
}
