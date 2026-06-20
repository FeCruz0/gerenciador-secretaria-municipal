# Relatório de Auditoria: Migração Bootstrap → Tailwind CSS

Gerado automaticamente em: 2026-06-20

Este documento lista todas as páginas e componentes React que contêm classes ou referências ao Bootstrap clássico e estima a complexidade de conversão para o Tailwind CSS.

## Resumo Geral

*   **Total de arquivos React analisados com ocorrências**: 43
*   **Classes Bootstrap exclusivas em uso**: 46

### Top 15 Classes Bootstrap Mais Frequentes

| Classe Bootstrap | Frequência | Equivalente Recomendado no Tailwind |
| :--- | :---: | :--- |
| `btn-primary` | 106 | inline-flex items-center justify-center px-4 py-2 rounded-lg font-medium transition |
| `col-md-6` | 24 | Ver guia de design |
| `card-text` | 20 | bg-slate-900 border border-slate-800 rounded-xl shadow-md p-6 |
| `col-lg-4` | 18 | Ver guia de design |
| `col-sm-8` | 18 | Ver guia de design |
| `col-lg-12` | 18 | Ver guia de design |
| `col-12` | 16 | w-full |
| `table-row-hover` | 15 | Ver guia de design |
| `card-title` | 14 | bg-slate-900 border border-slate-800 rounded-xl shadow-md p-6 |
| `col-lg-8` | 12 | Ver guia de design |
| `form-label` | 11 | text-sm font-medium text-slate-400 mb-1 block |
| `form-control` | 11 | w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-lg text-slate-100 focus:outline-none focus:border-indigo-500 transition |
| `row` | 8 | flex flex-wrap -mx-4 (ou grid grid-cols-12 gap-4) |
| `card-header` | 8 | bg-slate-900 border border-slate-800 rounded-xl shadow-md p-6 |
| `btn` | 7 | inline-flex items-center justify-center px-4 py-2 rounded-lg font-medium transition |

## Arquivos a Serem Migrados (Ordenados por Complexidade)

| Arquivo | Classes Bootstrap Identificadas | Imports do BS? | Complexidade |
| :--- | :--- | :---: | :---: |
| [Login.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Auth/Login.jsx) | `row`, `col-lg-8`, `col-lg-4`, `col-12`, `col-sm-8`, `col-md-6`, `col-lg-12`, `card-title`, `card-text`, `form-label`, `form-control`, `input-group`, `input-group-merge`, `form-control-merge`, `text-danger`, `form-check`, `form-check-input`, `form-check-label`, `btn`, `btn-primary` | Não | **Alta** |
| [Register.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Auth/Register.jsx) | `row`, `col-lg-8`, `col-lg-4`, `col-12`, `col-sm-8`, `col-md-6`, `col-lg-12`, `card-title`, `card-text`, `form-label`, `form-control`, `input-group`, `input-group-merge`, `form-control-merge`, `text-danger`, `btn`, `btn-primary` | Não | **Alta** |
| [Dashboard.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Dashboard.jsx) | `row`, `match-height`, `col-lg-3`, `col-sm-6`, `col-12`, `card`, `card-header`, `card-text`, `avatar`, `bg-light-primary`, `avatar-content`, `bg-light-success`, `bg-light-danger`, `col-lg-4`, `col-md-6`, `card-profile`, `card-img-top`, `card-body`, `badge`, `badge-light-primary`, `profile-badge`, `card-developer-meetup`, `card-title`, `card-employee-task` | Não | **Alta** |
| [ConfirmPassword.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Auth/ConfirmPassword.jsx) | `row`, `col-lg-8`, `col-lg-4`, `col-12`, `col-sm-8`, `col-md-6`, `col-lg-12`, `card-text`, `form-label`, `form-control`, `btn`, `btn-primary` | Não | **Média** |
| [ForgotPassword.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Auth/ForgotPassword.jsx) | `row`, `col-lg-8`, `col-lg-4`, `col-12`, `col-sm-8`, `col-md-6`, `col-lg-12`, `card-title`, `card-text`, `alert`, `alert-success`, `form-label`, `form-control`, `btn`, `btn-primary` | Não | **Média** |
| [ResetPassword.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Auth/ResetPassword.jsx) | `row`, `col-lg-8`, `col-lg-4`, `col-12`, `col-sm-8`, `col-md-6`, `col-lg-12`, `card-title`, `card-text`, `form-label`, `form-control`, `btn`, `btn-primary` | Não | **Média** |
| [VerifyEmail.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Auth/VerifyEmail.jsx) | `row`, `col-lg-8`, `col-lg-4`, `col-12`, `col-sm-8`, `col-md-6`, `col-lg-12`, `card-title`, `card-text`, `alert`, `alert-success`, `btn`, `btn-primary`, `btn-outline-danger` | Não | **Média** |
| [AdminLayout.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Components/Layout/AdminLayout.jsx) | `flex-col` | Não | **Baixa** |
| [Create.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Bidding/Create.jsx) | `btn-primary` | Não | **Baixa** |
| [Index.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Bidding/Index.jsx) | `btn-primary`, `table-row-hover` | Não | **Baixa** |
| [Show.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Bidding/Show.jsx) | `btn-primary` | Não | **Baixa** |
| [Create.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/DirectHire/Create.jsx) | `btn-primary` | Não | **Baixa** |
| [Index.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/DirectHire/Index.jsx) | `btn-primary`, `table-row-hover` | Não | **Baixa** |
| [ItemShow.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/DirectHire/ItemShow.jsx) | `btn-primary` | Não | **Baixa** |
| [Show.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/DirectHire/Show.jsx) | `btn-primary` | Não | **Baixa** |
| [WinnerCreate.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/DirectHire/WinnerCreate.jsx) | `btn-primary` | Não | **Baixa** |
| [WinnerIndex.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/DirectHire/WinnerIndex.jsx) | `btn-primary` | Não | **Baixa** |
| [WinnerItems.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/DirectHire/WinnerItems.jsx) | `btn-primary` | Não | **Baixa** |
| [WinnerShow.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/DirectHire/WinnerShow.jsx) | `btn-primary` | Não | **Baixa** |
| [Create.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Expense/Create.jsx) | `btn-primary` | Não | **Baixa** |
| [Index.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Expense/Index.jsx) | `btn-primary`, `table-row-hover` | Não | **Baixa** |
| [ReportIndex.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Expense/ReportIndex.jsx) | `flex-col`, `sm:flex-row`, `md:col-span-1`, `md:col-span-2` | Não | **Baixa** |
| [Show.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Expense/Show.jsx) | `btn-primary` | Não | **Baixa** |
| [Index.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Leadership/Index.jsx) | `btn-primary` | Não | **Baixa** |
| [Show.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Leadership/Show.jsx) | `btn-primary` | Não | **Baixa** |
| [Create.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Legislation/Create.jsx) | `btn-primary` | Não | **Baixa** |
| [Index.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Legislation/Index.jsx) | `btn-primary`, `table-row-hover` | Não | **Baixa** |
| [ReportIndex.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Legislation/ReportIndex.jsx) | `btn-primary` | Não | **Baixa** |
| [Show.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Legislation/Show.jsx) | `btn-primary` | Não | **Baixa** |
| [Create.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/ManagementReport/Create.jsx) | `btn-primary` | Não | **Baixa** |
| [Index.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/ManagementReport/Index.jsx) | `btn-primary` | Não | **Baixa** |
| [Show.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/ManagementReport/Show.jsx) | `btn-primary` | Não | **Baixa** |
| [CategoryIndex.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Project/CategoryIndex.jsx) | `btn-primary` | Não | **Baixa** |
| [CategoryShow.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Project/CategoryShow.jsx) | `btn-primary` | Não | **Baixa** |
| [Create.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Project/Create.jsx) | `btn-primary` | Não | **Baixa** |
| [Index.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Project/Index.jsx) | `btn-primary` | Não | **Baixa** |
| [Show.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Project/Show.jsx) | `btn-primary` | Não | **Baixa** |
| [Create.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Revenue/Create.jsx) | `btn-primary` | Não | **Baixa** |
| [Index.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Revenue/Index.jsx) | `btn-primary`, `table-row-hover` | Não | **Baixa** |
| [ReportIndex.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Revenue/ReportIndex.jsx) | `btn-primary` | Não | **Baixa** |
| [Show.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Revenue/Show.jsx) | `btn-primary` | Não | **Baixa** |
| [Index.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Unit/Index.jsx) | `btn-primary` | Não | **Baixa** |
| [Show.jsx](file:///c:/Users/Felipe Cruz/Documents/projetos/gerenciador-secretaria-municipal/resources/js/Pages/Unit/Show.jsx) | `btn-primary` | Não | **Baixa** |
