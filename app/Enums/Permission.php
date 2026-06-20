<?php

namespace App\Enums;

enum Permission: string
{
    // Liderança
    case VIEW_LEADERSHIP = 'Ver e Listar Liderança';
    case CREATE_LEADERSHIP = 'Criar Liderança';
    case EDIT_LEADERSHIP = 'Editar Liderança';
    case DELETE_LEADERSHIP = 'Deletar Liderança';

    // Contratações Diretas
    case VIEW_DIRECT_HIRES = 'Ver e Listar Contratações Diretas';
    case CREATE_DIRECT_HIRES = 'Criar Contratações Diretas';
    case EDIT_DIRECT_HIRES = 'Editar Contratações Diretas';

    // Licitações
    case VIEW_BIDDINGS = 'Ver e Listar Licitações';
    case CREATE_BIDDINGS = 'Criar Licitações';
    case EDIT_BIDDINGS = 'Editar Licitações';
    case DELETE_BIDDINGS = 'Deletar Licitações';

    // Notícias
    case VIEW_NEWS = 'Ver e Listar Notícias';
    case CREATE_NEWS = 'Criar Notícias';
    case EDIT_NEWS = 'Editar Notícias';
    case DELETE_NEWS = 'Deletar Notícias';

    // Unidades
    case VIEW_UNITS = 'Ver e Listar Unidades';
    case CREATE_UNITS = 'Criar Unidades';
    case EDIT_UNITS = 'Editar Unidades';
    case DELETE_UNITS = 'Deletar Unidades';

    // Relatórios de Gestão
    case VIEW_MANAGEMENT_REPORTS = 'Ver e Listar Relatórios de Gestão';
    case CREATE_MANAGEMENT_REPORTS = 'Criar Relatórios de Gestão';
    case EDIT_MANAGEMENT_REPORTS = 'Editar Relatórios de Gestão';
    case DELETE_MANAGEMENT_REPORTS = 'Deletar Relatórios de Gestão';

    // Sobre
    case VIEW_ABOUT = 'Ver e Listar Sobre';
    case EDIT_ABOUT = 'Editar Sobre';
    case DELETE_ABOUT = 'Deletar Sobre';

    // Contratos
    case EDIT_AGREEMENTS = 'Editar Contratos';

    // Unidade de Conservação
    case VIEW_CONSERVATION_UNITS = 'Ver e Listar Unidade de Conservacao';
    case CREATE_CONSERVATION_UNITS = 'Criar Unidade de Conservacao';
    case EDIT_CONSERVATION_UNITS = 'Editar Unidade de Conservacao';
    case DELETE_CONSERVATION_UNITS = 'Deletar Unidade de Conservacao';

    // Departamentos
    case VIEW_DEPARTMENTS = 'Ver e Listar Departamentos';
    case CREATE_DEPARTMENTS = 'Criar Departamentos';
    case EDIT_DEPARTMENTS = 'Editar Departamentos';
    case DELETE_DEPARTMENTS = 'Deletar Departamentos';

    // Documentos
    case VIEW_DOCUMENTS = 'Ver e Listar Documentos';
    case CREATE_DOCUMENTS = 'Criar Documentos';
    case EDIT_DOCUMENTS = 'Editar Documentos';
    case DELETE_DOCUMENTS = 'Deletar Documentos';

    // E-mails
    case VIEW_EMAILS = 'Ver e Listar E-mails';
    case CREATE_EMAILS = 'Criar E-mails';
    case EDIT_EMAILS = 'Editar E-mails';
    case DELETE_EMAILS = 'Deletar E-mails';

    // Manifestações / Ouvidoria
    case VIEW_MANIFESTATIONS = 'Ver e Listar Manifestações';
    case EDIT_MANIFESTATIONS = 'Editar Manifestações';
    case DELETE_MANIFESTATIONS = 'Deletar Manifestações';

    // Projetos
    case VIEW_PROJECTS = 'Ver e Listar Projetos';
    case CREATE_PROJECTS = 'Criar Projetos';
    case EDIT_PROJECTS = 'Editar Projetos';
    case DELETE_PROJECTS = 'Deletar Projetos';

    // Banners
    case VIEW_BANNERS = 'Ver e Listar Banners';
    case CREATE_BANNERS = 'Criar Banners';
    case EDIT_BANNERS = 'Editar Banners';
    case DELETE_BANNERS = 'Deletar Banners';

    // FAQ
    case VIEW_FAQ = 'Ver e Listar FAQ';
    case CREATE_FAQ = 'Criar FAQ';
    case EDIT_FAQ = 'Editar FAQ';
    case DELETE_FAQ = 'Deletar FAQ';

    // Galeria
    case VIEW_GALLERY = 'Ver e Listar Galeria';
    case CREATE_GALLERY = 'Criar Galeria';
    case EDIT_GALLERY = 'Editar Galeria';
    case DELETE_GALLERY = 'Deletar Galeria';

    // Notificações
    case VIEW_NOTIFICATIONS = 'Ver e Listar Notificações';
    case CREATE_NOTIFICATIONS = 'Criar Notificações';
    case EDIT_NOTIFICATIONS = 'Editar Notificações';
    case DELETE_NOTIFICATIONS = 'Deletar Notificações';

    // Atalhos Web
    case VIEW_WEB_SHORTCUTS = 'Ver e Listar Atalhos Web';
    case CREATE_WEB_SHORTCUTS = 'Criar Atalhos Web';
    case EDIT_WEB_SHORTCUTS = 'Editar Atalhos Web';
    case DELETE_WEB_SHORTCUTS = 'Deletar Atalhos Web';

    // Usuários
    case VIEW_USERS = 'Ver e Listar Usuários';
    case CREATE_USERS = 'Criar Usuários';
    case EDIT_USERS = 'Editar Usuários';
    case DELETE_USERS = 'Deletar Usuários';
}
