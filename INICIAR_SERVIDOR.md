# 🚀 Como Iniciar o Servidor Local

## Opção 1: Servidor PHP Artisan (Recomendado - Mais Simples)

Execute no terminal:

```bash
php artisan serve
```

O servidor será iniciado em: **http://localhost:8000**

Para parar o servidor, pressione `Ctrl + C`

---

## Opção 2: Com Vite (Frontend + Backend)

Se você quiser que o Vite também compile os assets em tempo real:

```bash
composer run dev
```

Isso iniciará:
- Servidor Laravel (porta 8000)
- Vite dev server (hot reload)
- Queue worker
- Logs em tempo real

---

## Opção 3: Servidor em Porta Específica

Para usar uma porta diferente (ex: 8080):

```bash
php artisan serve --port=8080
```

---

## Acessar o Projeto

Após iniciar o servidor, acesse:

- **Página inicial**: http://localhost:8000
- **Cursos**: http://localhost:8000/courses
- **Alunos**: http://localhost:8000/students
- **Professores**: http://localhost:8000/professors
- **Matrículas**: http://localhost:8000/enrollments
- **Avaliações**: http://localhost:8000/evaluations
- **Pagamentos**: http://localhost:8000/payments

---

## ⚠️ Antes de Iniciar

Certifique-se de que:

1. ✅ As migrações foram executadas: `php artisan migrate`
2. ✅ O banco de dados está configurado no `.env`
3. ✅ As dependências estão instaladas: `composer install` e `npm install`

---

## Problemas Comuns

### Erro: "Port 8000 is already in use"
Use outra porta:
```bash
php artisan serve --port=8080
```

### Erro: "Class not found"
Execute:
```bash
composer dump-autoload
```

### Erro: "Vite manifest not found"
Execute:
```bash
npm run build
```

