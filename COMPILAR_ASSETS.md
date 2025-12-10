# 📦 Como Compilar os Assets (CSS/JS)

## Problema
O erro "Vite manifest not found" ocorre porque os arquivos CSS e JavaScript não foram compilados ainda.

## Solução Temporária (Já Aplicada)
Adicionei um fallback no layout que usa Tailwind CSS via CDN quando o Vite não está disponível. O site deve funcionar agora, mas é recomendado compilar os assets.

## Solução Permanente

### 1. Habilitar Execução de Scripts no PowerShell (se necessário)

Abra o PowerShell como **Administrador** e execute:

```powershell
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
```

Depois confirme com `Y` (Yes).

### 2. Instalar Dependências do NPM

No terminal do projeto, execute:

```bash
npm install
```

Isso instalará todas as dependências necessárias (Vite, Tailwind CSS, etc.)

### 3. Compilar os Assets

**Para desenvolvimento (com hot reload):**
```bash
npm run dev
```

**Para produção (compilação única):**
```bash
npm run build
```

### 4. Iniciar o Servidor

Em um terminal separado:

```bash
php artisan serve
```

---

## Opção: Usar o Comando Dev Completo

O Laravel tem um comando que inicia tudo de uma vez:

```bash
composer run dev
```

Isso inicia:
- Servidor Laravel (porta 8000)
- Vite dev server (hot reload)
- Queue worker
- Logs em tempo real

---

## Verificar se Funcionou

Após compilar, você deve ver:
- Pasta `public/build/` criada
- Arquivo `public/build/manifest.json` criado
- CSS e JS compilados em `public/build/assets/`

---

## Nota Importante

O fallback que adicionei permite que o site funcione sem compilar, mas:
- ⚠️ Usa Tailwind via CDN (mais lento)
- ⚠️ Não tem hot reload
- ✅ Funciona para desenvolvimento básico

Para melhor performance, compile os assets seguindo os passos acima.

