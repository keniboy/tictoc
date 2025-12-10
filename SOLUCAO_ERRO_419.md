# 🔧 Solução para Erro 419 (CSRF Token)

## Problema
Erro 419 ao tentar registrar usuário: "Failed to load resource: the server responded with a status of 419"

## Causa
O erro 419 no Laravel indica que o token CSRF não foi validado corretamente. Isso pode acontecer por:
1. Sessão não está funcionando corretamente
2. Cookies não estão sendo aceitos
3. Token CSRF expirado
4. Configuração de sessão incorreta

## Soluções Aplicadas

### 1. Meta Tag CSRF Adicionada
✅ Adicionado `<meta name="csrf-token" content="{{ csrf_token() }}">` nas páginas de login e registro

### 2. Configuração de Sessão
✅ Alterado driver de sessão de `database` para `file` (mais simples e confiável)

### 3. Cache Limpo
✅ Executado `php artisan config:clear` e `php artisan cache:clear`

## Próximos Passos

### Opção 1: Usar Sessão em Arquivo (Recomendado)
A configuração já foi alterada. Reinicie o servidor:

```bash
# Pare o servidor (Ctrl+C)
# Inicie novamente
php artisan serve
```

### Opção 2: Usar Sessão em Banco de Dados
Se preferir usar database, execute:

```bash
php artisan migrate
```

Isso criará a tabela `sessions` se ainda não existir.

### Opção 3: Verificar Cookies do Navegador
1. Abra as ferramentas de desenvolvedor (F12)
2. Vá para a aba "Application" (Chrome) ou "Storage" (Firefox)
3. Verifique se os cookies estão sendo salvos
4. Limpe os cookies e tente novamente

### Opção 4: Verificar Configuração do .env
Certifique-se de que o `.env` tem:
```
SESSION_DRIVER=file
SESSION_LIFETIME=120
APP_KEY=base64:... (deve estar preenchido)
```

## Teste
1. Limpe o cache do navegador (Ctrl+Shift+Delete)
2. Acesse `/register` novamente
3. Preencha o formulário
4. Clique em "Registrar"

Se o problema persistir, verifique:
- Se o servidor foi reiniciado após as mudanças
- Se os cookies estão habilitados no navegador
- Se não há extensões bloqueando cookies

