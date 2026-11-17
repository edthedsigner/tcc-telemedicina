<?php
class Database
{
    private string $host = "127.0.0.1";
    private string $database = "sig_consulta";
    private string $username = "root";
    private string $password = "";

    public function conectar(): PDO
    {
        $dsn = "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4";

        return new PDO($dsn, $this->username, $this->password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
    }
}
