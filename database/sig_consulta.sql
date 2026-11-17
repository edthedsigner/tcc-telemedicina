-- SIG CONSULTA - BASE DE DADOS SIMPLIFICADA
-- Execute apenas se puder recriar a base. Este script apaga a base existente.

DROP DATABASE IF EXISTS sig_consulta;
CREATE DATABASE sig_consulta CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sig_consulta;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    perfil ENUM('Administrador','Recepcionista','Medico') NOT NULL DEFAULT 'Recepcionista',
    ativo TINYINT(1) NOT NULL DEFAULT 1,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE especialidades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    data_nascimento DATE NULL,
    sexo ENUM('Masculino','Feminino','Outro') NULL,
    telefone VARCHAR(30) NULL,
    email VARCHAR(120) NULL,
    endereco VARCHAR(200) NULL,
    documento VARCHAR(50) NULL,
    alergias VARCHAR(255) NULL,
    observacoes TEXT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE medicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    especialidade_id INT NOT NULL,
    telefone VARCHAR(30) NULL,
    email VARCHAR(120) NULL,
    ativo TINYINT(1) NOT NULL DEFAULT 1,
    CONSTRAINT fk_medico_especialidade
        FOREIGN KEY (especialidade_id) REFERENCES especialidades(id)
        ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE servicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    tipo ENUM('Consulta','Exame','Procedimento') NOT NULL,
    preco DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    ativo TINYINT(1) NOT NULL DEFAULT 1
);

CREATE TABLE consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    medico_id INT NOT NULL,
    servico_id INT NOT NULL,
    data_consulta DATETIME NOT NULL,
    estado ENUM('Pendente','Agendada','Confirmada','Realizada','Cancelada') NOT NULL DEFAULT 'Pendente',
    motivo VARCHAR(255) NULL,
    observacoes TEXT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_consulta_paciente
        FOREIGN KEY (paciente_id) REFERENCES pacientes(id)
        ON UPDATE CASCADE ON DELETE RESTRICT,

    CONSTRAINT fk_consulta_medico
        FOREIGN KEY (medico_id) REFERENCES medicos(id)
        ON UPDATE CASCADE ON DELETE RESTRICT,

    CONSTRAINT fk_consulta_servico
        FOREIGN KEY (servico_id) REFERENCES servicos(id)
        ON UPDATE CASCADE ON DELETE RESTRICT
);

INSERT INTO especialidades (nome) VALUES
('Clínica Geral'),
('Pediatria'),
('Ginecologia'),
('Estomatologia'),
('Cardiologia'),
('Dermatologia'),
('Ortopedia'),
('Urologia');

INSERT INTO servicos (nome, tipo, preco) VALUES
('Consulta de Clínica Geral', 'Consulta', 8050.00),
('Consulta de Pediatria', 'Consulta', 9000.00),
('Consulta de Ginecologia', 'Consulta', 13500.00),
('Consulta de Estomatologia', 'Consulta', 5000.00),
('Consulta de Cardiologia', 'Consulta', 15300.00),
('Consulta de Dermatologia', 'Consulta', 15300.00),
('Consulta de Ortopedia', 'Consulta', 15300.00),
('Consulta de Urologia', 'Consulta', 15300.00),
('Raio-X', 'Exame', 12500.00),
('Ecografia', 'Exame', 19000.00),
('Electrocardiograma', 'Exame', 10750.00),
('Colocação de Chip', 'Procedimento', 12350.00);

INSERT INTO medicos (nome, especialidade_id, telefone, email) VALUES
('Dr. João Manuel', 1, '923000001', 'joao@clinica.com'),
('Dra. Maria Silva', 3, '923000002', 'maria@clinica.com'),
('Dr. Paulo Costa', 5, '923000003', 'paulo@clinica.com');
