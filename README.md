# SIG Consulta

Sistema simples de gestão de consultas para fins didáticos.

## Tecnologias

- PHP
- MySQL
- PDO
- MVC
- Bootstrap
- Laragon

## Base de dados

Nome:

sig_consulta

## Estrutura

6 tabelas:

- usuarios
- pacientes
- especialidades
- medicos
- servicos
- consultas

## Instalação

1. Coloque a pasta `sig_consulta` em:

C:\laragon\www\

2. Inicie Apache e MySQL no Laragon.

3. Crie/importar a base `sig_consulta` no phpMyAdmin usando o arquivo SQL simplificado.

4. Verifique `config/Database.php`.

Por padrão:

host: 127.0.0.1
usuario: root
senha: vazia
banco: sig_consulta

5. Acesse:

http://sig_consulta.test/public/

ou:

http://localhost/sig_consulta/public/

## Criar primeiro usuário

Execute temporariamente no PHP:

```php
<?php
require_once "config/bootstrap.php";

$usuario = new Usuario();

$usuario->criar(
    "Administrador",
    "admin@sigconsulta.com",
    "123456",
    "Administrador"
);

echo "Usuário criado.";
```

Depois acesse:

E-mail: admin@sigconsulta.com
Senha: 123456

Remova esse arquivo depois de criar o usuário.

## Observação

O projeto é propositalmente simples. A ideia é ensinar:

View -> Controller -> Model -> MySQL

Sem Laravel e sem framework de backend.


## Solicitação de consulta online

O sistema agora possui uma área pública para o paciente solicitar uma consulta.

Fluxo:
1. Paciente acessa `index.php?pagina=solicitar_consulta`.
2. Preenche os seus dados, especialidade, médico, serviço e data pretendida.
3. A solicitação é gravada em `consultas` com estado `Pendente`.
4. O administrador entra no painel e abre **Solicitações online**.
5. O administrador pode **Aprovar** (passa para `Agendada`) ou **Recusar** (passa para `Cancelada`).

Para uma base já existente, execute `database/alterar_consultas_online.sql`.

A opção de aprovação está protegida para o perfil `Administrador`. Neste projeto, Administrador representa o responsável/gestor da clínica.


## Envio de e-mails após aprovação/recusa

O sistema usa PHPMailer para enviar automaticamente um e-mail ao paciente quando o administrador aprova ou recusa uma solicitação. PHPMailer suporta SMTP e é adequado para ambientes Windows/Laragon.

### Instalar

Na pasta do projeto, abra o terminal e execute:

```bash
composer install
```

Depois edite `config/email.php` e informe os dados do SMTP.

Exemplo com Gmail:
- host: `smtp.gmail.com`
- porta: `587`
- encryption: `tls`
- username: seu e-mail
- password: sua senha de aplicação

Não coloque a senha real no Git ou em arquivos públicos.

Se o SMTP ainda não estiver configurado, a aprovação continua a ser gravada, mas o sistema mostrará ao administrador que o e-mail não foi enviado.


## Notificação automática por e-mail

O e-mail do paciente é informado no formulário público de solicitação e fica guardado na tabela `pacientes`. Quando o administrador aprova ou recusa a solicitação, o sistema usa automaticamente esse e-mail como destinatário.

Apenas o e-mail da clínica é configurado no `config/email.php` como conta SMTP remetente. Não é necessário pedir senha ao paciente.

1. Execute `composer install`.
2. Configure no `config/email.php` a conta SMTP da clínica.
3. Para Gmail, use uma Senha de app na conta que envia os e-mails.
4. Faça uma solicitação com um e-mail válido.
5. No painel do administrador, aprove ou recuse a solicitação.
6. O paciente recebe automaticamente a notificação no e-mail informado.


## e-mail
O projeto agora guarda o consentimento do paciente para receber notificações por e-mail.
Por padrão, o envio está DESATIVADO até configurar a e-mail Cloud API em `config/e-mail.php`.
As notificações de aprovação/recusa usam um template aprovado do e-mail Business.

Passos:
1. Execute `database/alterar_e-mail.sql` na base existente.
2. Configure `config/e-mail.php`.
3. Crie/aprove no e-mail Business um template chamado, por exemplo, `consulta_resultado`, com 4 variáveis no corpo: paciente, estado, médico e data/hora.
4. Defina `enabled` como `true`.

A e-mail Business Platform usa mensagens de template para mensagens iniciadas pela empresa fora da janela de atendimento.


## Notificações por e-mail

O sistema envia automaticamente um e-mail ao endereço informado pelo paciente quando o administrador aprova ou recusa uma solicitação online.

1. Execute `composer install` na pasta do projeto.
2. Configure `config/email.php` com o SMTP da clínica.
3. Para Gmail, use uma senha de aplicação com verificação em duas etapas.
4. Não coloque o e-mail do paciente em `config/email.php`: o sistema busca automaticamente o e-mail guardado em `pacientes`.
