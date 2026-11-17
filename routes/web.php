<?php

switch ($pagina) {
    // Área pública
    case "solicitar_consulta":
        (new ConsultaController())->solicitar();
        break;

    case "enviar_solicitacao":
        (new ConsultaController())->enviarSolicitacao();
        break;

    // Uma única tela de login para todos os utilizadores internos
    case "login":
        (new UsuarioController())->login();
        break;

    case "entrar":
        (new UsuarioController())->entrar();
        break;

    case "sair":
        (new UsuarioController())->sair();
        break;

    case "inicio":
        proteger();
        (new UsuarioController())->inicio();
        break;

    // Pacientes e agenda: Administrador e Recepcionista
    case "pacientes":
        protegerAdminRecepcao();
        (new PacienteController())->index();
        break;
    case "paciente_cadastrar":
        protegerAdminRecepcao();
        (new PacienteController())->cadastrar();
        break;
    case "paciente_salvar":
        protegerAdminRecepcao();
        (new PacienteController())->salvar();
        break;
    case "paciente_editar":
        protegerAdminRecepcao();
        (new PacienteController())->editar();
        break;
    case "paciente_atualizar":
        protegerAdminRecepcao();
        (new PacienteController())->atualizar();
        break;
    case "paciente_excluir":
        protegerAdministrador();
        (new PacienteController())->excluir();
        break;

    // Médicos e serviços: Administrador
    case "medicos":
        protegerAdministrador();
        (new MedicoController())->index();
        break;
    case "medico_cadastrar":
        protegerAdministrador();
        (new MedicoController())->cadastrar();
        break;
    case "medico_salvar":
        protegerAdministrador();
        (new MedicoController())->salvar();
        break;
    case "medico_editar":
        protegerAdministrador();
        (new MedicoController())->editar();
        break;
    case "medico_atualizar":
        protegerAdministrador();
        (new MedicoController())->atualizar();
        break;
    case "medico_excluir":
        protegerAdministrador();
        (new MedicoController())->excluir();
        break;

    case "servicos":
        protegerAdministrador();
        (new ServicoController())->index();
        break;
    case "servico_cadastrar":
        protegerAdministrador();
        (new ServicoController())->cadastrar();
        break;
    case "servico_salvar":
        protegerAdministrador();
        (new ServicoController())->salvar();
        break;
    case "servico_editar":
        protegerAdministrador();
        (new ServicoController())->editar();
        break;
    case "servico_atualizar":
        protegerAdministrador();
        (new ServicoController())->atualizar();
        break;
    case "servico_excluir":
        protegerAdministrador();
        (new ServicoController())->excluir();
        break;

    // Consultas: Administrador e Recepcionista. Médico apenas visualiza a agenda.
    case "consultas":
        protegerAdminRecepcaoMedico();
        (new ConsultaController())->index();
        break;
    case "consulta_cadastrar":
        protegerAdminRecepcao();
        (new ConsultaController())->cadastrar();
        break;
    case "consulta_salvar":
        protegerAdminRecepcao();
        (new ConsultaController())->salvar();
        break;
    case "consulta_estado":
        protegerAdminRecepcao();
        (new ConsultaController())->alterarEstado();
        break;

    // Aprovação das solicitações online: somente Administrador
    case "solicitacoes":
        protegerAdministrador();
        (new ConsultaController())->pendentes();
        break;
    case "consulta_aprovar":
        protegerAdministrador();
        (new ConsultaController())->aprovar();
        break;
    case "consulta_recusar":
        protegerAdministrador();
        (new ConsultaController())->recusar();
        break;

    // Gestão de utilizadores internos: somente Administrador
    case "usuarios":
        protegerAdministrador();
        (new UsuarioController())->index();
        break;
    case "usuario_cadastrar":
        protegerAdministrador();
        (new UsuarioController())->cadastrar();
        break;
    case "usuario_salvar":
        protegerAdministrador();
        (new UsuarioController())->salvar();
        break;
    case "usuario_editar":
        protegerAdministrador();
        (new UsuarioController())->editar();
        break;
    case "usuario_atualizar":
        protegerAdministrador();
        (new UsuarioController())->atualizar();
        break;
    case "usuario_ativo":
        protegerAdministrador();
        (new UsuarioController())->alterarAtivo();
        break;

    default:
        http_response_code(404);
        echo "Página não encontrada.";
}
