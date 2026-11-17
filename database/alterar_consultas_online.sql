-- Use este script na base sig_consulta que já existe.
-- Ele NÃO apaga dados.

USE sig_consulta;

ALTER TABLE consultas
MODIFY COLUMN estado ENUM('Pendente','Agendada','Confirmada','Realizada','Cancelada')
NOT NULL DEFAULT 'Pendente';


-- O e-mail do paciente é usado automaticamente para as notificações.
-- Não é necessário criar nenhum campo de WhatsApp.
