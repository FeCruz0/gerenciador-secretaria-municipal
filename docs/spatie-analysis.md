# Análise Técnica: Spatie Permission vs Alternativas

> **Contexto do projeto:** A autorização atual usa `Gate::allows('Nome da Permissão')` em cada action dos controllers, com permissões registradas via `AuthServiceProvider`. O Spatie Permission está instalado e integrado ao modelo `User`, mas o acesso às permissões é feito pela fachada `Gate` do Laravel.

---

## Como o Spatie é usado hoje

```php
// Padrão atual em todos os controllers (ex: DirectHireController)
if (! Gate::allows('Ver e Listar Contratações Diretas')) {
    return view('pages.not-authorized');
}
```

O Spatie armazena as permissões no banco (`roles`, `permissions`, `model_has_roles`, `model_has_permissions`) e as expõe ao Gate do Laravel via `Gate::before()` ou `Gate::define()`. O modelo `User` usa a trait `HasRoles`.

---

## Spatie Laravel-Permission — Prós e Contras

### ✅ Prós
| Ponto | Detalhe |
|---|---|
| **Maturidade** | Package mais usado do ecossistema Laravel para RBAC (>17k stars, manutenção ativa) |
| **RBAC completo** | Suporte a Roles + Permissions com hierarquia, múltiplos guards |
| **Integração nativa** | Funciona transparentemente com o `Gate` do Laravel |
| **Blade helpers** | `@can`, `@role`, `@hasanyrole` prontos para uso |
| **Inertia compatible** | Permissões podem ser compartilhadas via `HandleInertiaRequests::share()` |
| **Cache embutido** | Permissões são cacheadas automaticamente (Redis/file) |
| **Bem documentado** | Documentação extensa, comunidade enorme |

### ❌ Contras
| Ponto | Detalhe |
|---|---|
| **Over-engineering** | Para apps simples, adiciona 5 tabelas desnecessárias |
| **Performance** | Queries de permissão por request se o cache não estiver configurado |
| **Acoplamento** | Permissões ficam no banco — difícil versionar/auditar por código |
| **Nomes de permissão hardcoded** | `Gate::allows('Ver e Listar Contratações Diretas')` — strings mágicas espalhadas |
| **Complexidade de teste** | Testes precisam seedar roles/permissions no banco |

### 🔍 Diagnóstico no seu projeto
> [!WARNING]
> O projeto usa strings longas e em português como nomes de permissão (`'Ver e Listar Contratações Diretas'`). Isso é frágil e difícil de refatorar. Recomenda-se migrar para constantes ou enums conforme os modules são migrados para Inertia.

---

## Alternativas

### 1. **Gate nativo do Laravel (sem Spatie)**
```php
// AuthServiceProvider.php
Gate::define('view-direct-hires', fn(User $user) => $user->is_admin);
```
- ✅ Zero dependência externa, tudo em código, versionável
- ✅ Fácil de testar
- ❌ Sem interface de gestão de roles no admin
- ❌ Permissões não são dinâmicas (exige deploy para mudar)
- **Ideal para:** apps simples com poucos papéis fixos

---

### 2. **Laravel Bouncer** (`silber/bouncer`)
```php
Bouncer::allow('admin')->to('view-direct-hires');
$user->can('view-direct-hires');
```
- ✅ API mais limpa e fluente que o Spatie
- ✅ Suporte a permissões por model (ex: só editar *seus próprios* registros)
- ✅ Integração nativa com o Gate
- ❌ Menor adoção que o Spatie (~4k stars)
- ❌ Menos exemplos/tutoriais disponíveis
- **Ideal para:** permissões granulares por instância de modelo

---

### 3. **Casl + Inertia (frontend)**
```js
// React — usando @casl/react
import { Can } from '@casl/react';
<Can I="view" a="DirectHire">
  <BotaoEditar />
</Can>
```
- ✅ Autorização no frontend, melhor UX
- ✅ Regras definidas em JS, sem round-trip ao servidor
- ❌ Requer sincronização das regras com o backend (via Inertia shared data)
- ❌ Nunca substituir a autorização do backend — complementar apenas
- **Ideal para:** controle de UI (mostrar/esconder botões) sem esconder dados reais

---

## Recomendação para este projeto

| Camada | Solução |
|---|---|
| **Backend (mantendo Spatie)** | ✅ Manter Spatie, mas **migrar strings para constantes PHP** |
| **Compartilhamento com React** | Compartilhar permissões via `HandleInertiaRequests::share()` |
| **Frontend** | Usar as permissões recebidas via Inertia props para mostrar/esconder UI |
| **Médio prazo** | Avaliar Bouncer se precisar de permissões granulares por registro |

### Exemplo de melhoria imediata (sem trocar o Spatie):

```php
// app/Enums/Permission.php (PHP 8.1 Enum)
enum Permission: string
{
    case VIEW_DIRECT_HIRES = 'Ver e Listar Contratações Diretas';
    case CREATE_DIRECT_HIRES = 'Criar Contratações Diretas';
    case EDIT_DIRECT_HIRES = 'Editar Contratações Diretas';
}

// No controller:
if (! Gate::allows(Permission::VIEW_DIRECT_HIRES->value)) {
    return redirect()->back()->with('error', 'Não autorizado.');
}
```

```php
// HandleInertiaRequests.php — compartilhar com React
public function share(Request $request): array
{
    return array_merge(parent::share($request), [
        'auth' => [
            'user' => $request->user(),
            'permissions' => $request->user()?->getAllPermissions()->pluck('name'),
        ],
    ]);
}
```

```jsx
// React — usando as permissões recebidas
const { auth } = usePage().props;
const canEdit = auth.permissions.includes('Editar Contratações Diretas');
```

---

## Conclusão

> [!IMPORTANT]
> **Spatie é uma boa opção para este projeto.** Está instalado, funcionando e é a melhor escolha do ecossistema Laravel para RBAC dinâmico. Trocar agora seria trabalho sem ganho real.
>
> O que **deve** ser feito: migrar as strings de permissão para um **PHP Enum** (prioridade média) e compartilhar as permissões com o React via `HandleInertiaRequests` (necessário para a migração dos módulos restantes).
