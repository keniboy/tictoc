# 📚 Sistema de Gestão de Cursos - TIC-TOC Lda

## 🎯 Visão Geral

Sistema web desenvolvido para automatizar a gestão de cursos do centro de formação profissional TIC-TOC Lda. O sistema permite gerenciar professores, cursos, alunos, matrículas, avaliações e pagamentos de forma integrada e eficiente.

---

## 📊 Modelo de Entidade-Relacionamento (MER)

### Entidades Principais

```
┌─────────────┐
│ Professores │
└──────┬──────┘
       │ 1
       │
       │ N
┌──────▼──────┐
│   Cursos    │
└──────┬──────┘
       │ 1
       │
       │ N
┌──────▼──────────┐
│   Matrículas    │
└──────┬──────────┘
       │ 1
       │
       ├─── N ───┐
       │         │
       │         │
┌──────▼──────┐  │  ┌──────────────┐
│ Avaliações  │  │  │  Pagamentos  │
└─────────────┘  │  └──────────────┘
                 │
                 │ N
       ┌─────────▼─────────┐
       │      Alunos        │
       └────────────────────┘
```

### Relacionamentos

1. **Professor → Cursos** (1:N)
   - Um professor pode lecionar vários cursos
   - Um curso é lecionado por um único professor

2. **Aluno → Matrículas** (1:N)
   - Um aluno pode ter várias matrículas
   - Uma matrícula pertence a um único aluno

3. **Curso → Matrículas** (1:N)
   - Um curso pode ter várias matrículas
   - Uma matrícula é para um único curso

4. **Matrícula → Avaliações** (1:N)
   - Uma matrícula pode ter várias avaliações
   - Uma avaliação pertence a uma única matrícula

5. **Matrícula → Pagamentos** (1:N)
   - Uma matrícula pode ter vários pagamentos
   - Um pagamento pertence a uma única matrícula

---

## 🗄️ Estrutura do Banco de Dados

### Tabela: `professors`
| Campo | Tipo | Descrição | Constraints |
|-------|------|-----------|-------------|
| id | BIGINT | Identificador único | PK, AUTO_INCREMENT |
| nome | VARCHAR(150) | Nome completo | NOT NULL |
| telemovel | VARCHAR(30) | Telefone | NULL |
| created_at | TIMESTAMP | Data criação | |
| updated_at | TIMESTAMP | Data atualização | |

### Tabela: `courses`
| Campo | Tipo | Descrição | Constraints |
|-------|------|-----------|-------------|
| id | BIGINT | Identificador único | PK, AUTO_INCREMENT |
| nome | VARCHAR(150) | Nome do curso | NOT NULL |
| data_inicio | DATE | Data início | NULL |
| data_fim | DATE | Data fim | NULL |
| professor_id | BIGINT | ID do professor | FK → professors.id |
| valor | DECIMAL(12,2) | Valor do curso | DEFAULT 0 |
| created_at | TIMESTAMP | Data criação | |
| updated_at | TIMESTAMP | Data atualização | |

**Regras:**
- `data_fim` deve ser >= `data_inicio` (validação aplicada)
- `valor` não pode ser negativo

### Tabela: `students`
| Campo | Tipo | Descrição | Constraints |
|-------|------|-----------|-------------|
| id | BIGINT | Identificador único | PK, AUTO_INCREMENT |
| nome | VARCHAR(150) | Nome completo | NOT NULL |
| telemovel | VARCHAR(30) | Telefone | NULL |
| email | VARCHAR(160) | Email | NOT NULL, UNIQUE |
| data_nascimento | DATE | Data nascimento | NULL |
| ativo | BOOLEAN | Status ativo/inativo | DEFAULT true |
| sexo | ENUM('M','F','O') | Gênero | NULL |
| created_at | TIMESTAMP | Data criação | |
| updated_at | TIMESTAMP | Data atualização | |

**Regras:**
- Email deve ser único
- Alunos inativos não aparecem na lista de matrículas

### Tabela: `enrollments`
| Campo | Tipo | Descrição | Constraints |
|-------|------|-----------|-------------|
| id | BIGINT | Identificador único | PK, AUTO_INCREMENT |
| student_id | BIGINT | ID do aluno | FK → students.id |
| course_id | BIGINT | ID do curso | FK → courses.id |
| data_matricula | DATE | Data matrícula | DEFAULT CURRENT_DATE |
| created_at | TIMESTAMP | Data criação | |
| updated_at | TIMESTAMP | Data atualização | |

**Constraints:**
- UNIQUE(student_id, course_id) - Evita matrícula duplicada
- CASCADE ON UPDATE - Atualiza referências automaticamente

### Tabela: `evaluations`
| Campo | Tipo | Descrição | Constraints |
|-------|------|-----------|-------------|
| id | BIGINT | Identificador único | PK, AUTO_INCREMENT |
| enrollment_id | BIGINT | ID da matrícula | FK → enrollments.id |
| nota | DECIMAL(5,2) | Nota (0-20) | NULL |
| data | DATE | Data avaliação | DEFAULT CURRENT_DATE |
| created_at | TIMESTAMP | Data criação | |
| updated_at | TIMESTAMP | Data atualização | |

**Regras:**
- Nota máxima: 20 (validação aplicada)
- CASCADE ON DELETE - Remove avaliações se matrícula for removida

### Tabela: `payments`
| Campo | Tipo | Descrição | Constraints |
|-------|------|-----------|-------------|
| id | BIGINT | Identificador único | PK, AUTO_INCREMENT |
| enrollment_id | BIGINT | ID da matrícula | FK → enrollments.id |
| data_pagamento | DATE | Data pagamento | DEFAULT CURRENT_DATE |
| debito | DECIMAL(12,2) | Valor débito | DEFAULT 0 |
| credito | DECIMAL(12,2) | Valor crédito | DEFAULT 0 |
| created_at | TIMESTAMP | Data criação | |
| updated_at | TIMESTAMP | Data atualização | |

**Regras:**
- Pelo menos um valor (débito ou crédito) deve ser preenchido
- CASCADE ON DELETE - Remove pagamentos se matrícula for removida

---

## 🔄 Fluxo do Sistema

### 1. Fluxo de Gestão de Professores

```
┌─────────────────┐
│ Listar          │
│ Professores     │
└────────┬────────┘
         │
         ├───► Criar Novo Professor
         │     └───► [Formulário: nome, telemóvel]
         │           └───► Salvar
         │
         ├───► Ver Detalhes
         │     └───► [Mostra: info + cursos lecionados]
         │
         ├───► Editar
         │     └───► [Formulário preenchido]
         │           └───► Atualizar
         │
         └───► Remover
               └───► [Confirmação]
                     └───► Deletar
```

### 2. Fluxo de Gestão de Cursos

```
┌─────────────────┐
│ Listar          │
│ Cursos          │
└────────┬────────┘
         │
         ├───► Criar Novo Curso
         │     └───► [Formulário: nome, professor, datas, valor]
         │           └───► Validar (data_fim >= data_inicio)
         │                 └───► Salvar
         │
         ├───► Ver Detalhes
         │     └───► [Mostra: info + alunos matriculados]
         │
         ├───► Editar
         │     └───► [Formulário preenchido]
         │           └───► Atualizar
         │
         └───► Remover
               └───► [Confirmação]
                     └───► Deletar
```

### 3. Fluxo de Gestão de Alunos

```
┌─────────────────┐
│ Listar          │
│ Alunos          │
└────────┬────────┘
         │
         ├───► Criar Novo Aluno
         │     └───► [Formulário: nome, email, telemóvel, 
         │               data_nascimento, sexo, ativo]
         │           └───► Validar (email único)
         │                 └───► Salvar
         │
         ├───► Ver Detalhes
         │     └───► [Mostra: info + cursos matriculados]
         │
         ├───► Editar
         │     └───► [Formulário preenchido]
         │           └───► Atualizar
         │
         └───► Remover
               └───► [Confirmação]
                     └───► Deletar
```

### 4. Fluxo de Matrículas (Processo Principal)

```
┌──────────────────────┐
│ Listar Matrículas    │
└──────────┬───────────┘
           │
           ├───► Nova Matrícula
           │     │
           │     ├───► Selecionar Aluno (apenas ativos)
           │     ├───► Selecionar Curso
           │     ├───► Data Matrícula (opcional, padrão: hoje)
           │     │
           │     └───► Validar
           │           ├───► Aluno já matriculado? → ERRO
           │           └───► OK → Salvar
           │
           ├───► Ver Detalhes
           │     └───► [Mostra: aluno, curso, data]
           │           ├───► Lista de Avaliações
           │           └───► Lista de Pagamentos
           │
           ├───► Editar
           │     └───► [Permite alterar aluno/curso/data]
           │           └───► Validar (sem duplicatas)
           │
           └───► Remover
                 └───► [CASCADE: remove avaliações e pagamentos]
```

### 5. Fluxo de Avaliações

```
┌──────────────────────┐
│ Listar Avaliações    │
└──────────┬───────────┘
           │
           ├───► Nova Avaliação
           │     │
           │     ├───► Selecionar Matrícula
           │     │     └───► [Mostra: Aluno - Curso]
           │     ├───► Nota (0-20)
           │     ├───► Data (padrão: hoje)
           │     │
           │     └───► Salvar
           │
           ├───► Ver Detalhes
           │     └───► [Mostra: aluno, curso, nota, data]
           │
           └───► Editar/Remover
```

### 6. Fluxo de Pagamentos

```
┌──────────────────────┐
│ Listar Pagamentos    │
└──────────┬───────────┘
           │
           ├───► Novo Pagamento
           │     │
           │     ├───► Selecionar Matrícula
           │     │     └───► [Mostra: Aluno - Curso]
           │     ├───► Data Pagamento (padrão: hoje)
           │     ├───► Débito (€)
           │     ├───► Crédito (€)
           │     │
           │     └───► Validar
           │           ├───► Pelo menos um valor? → ERRO
           │           └───► OK → Salvar
           │
           ├───► Ver Detalhes
           │     └───► [Mostra: aluno, curso, débito, crédito]
           │
           └───► Editar/Remover
```

---

## 🎯 Processos de Negócio Principais

### Processo 1: Matricular Aluno em Curso

```
1. Verificar se aluno está ativo
   └───► Se não: mostrar apenas alunos ativos

2. Verificar se já existe matrícula
   └───► Se sim: ERRO "Aluno já matriculado neste curso"
   └───► Se não: CONTINUAR

3. Criar matrícula
   └───► Associar aluno ao curso
   └───► Definir data de matrícula
   └───► Salvar no banco

4. Resultado
   └───► Matrícula criada com sucesso
   └───► Aluno pode receber avaliações
   └───► Aluno pode ter pagamentos registrados
```

### Processo 2: Registrar Avaliação

```
1. Selecionar matrícula
   └───► Mostrar: "Aluno X - Curso Y"

2. Inserir nota
   └───► Validar: 0 <= nota <= 20

3. Definir data
   └───► Padrão: data atual

4. Salvar avaliação
   └───► Associada à matrícula
   └───► Histórico de avaliações mantido
```

### Processo 3: Registrar Pagamento

```
1. Selecionar matrícula
   └───► Mostrar: "Aluno X - Curso Y"

2. Inserir valores
   ├───► Débito: valor devido
   └───► Crédito: valor pago

3. Validar
   └───► Pelo menos um valor deve ser preenchido

4. Salvar pagamento
   └───► Histórico financeiro mantido
   └───► Permite controle de débitos/créditos
```

---

## 🔐 Princípios de Segurança e Integridade

### 1. Integridade Referencial
- ✅ Foreign Keys com CASCADE ON UPDATE
- ✅ Foreign Keys com CASCADE ON DELETE (avaliações e pagamentos)
- ✅ Constraints UNIQUE para evitar duplicatas

### 2. Validação de Dados
- ✅ Validação no frontend (HTML5)
- ✅ Validação no backend (Laravel Request Validation)
- ✅ Validação no banco (constraints, tipos, defaults)

### 3. Normalização
- ✅ 1ª Forma Normal: Todos os campos são atômicos
- ✅ 2ª Forma Normal: Dependências funcionais completas
- ✅ 3ª Forma Normal: Sem dependências transitivas

### 4. Regras de Negócio
- ✅ Email único por aluno
- ✅ Matrícula única por aluno/curso
- ✅ Nota máxima: 20
- ✅ Data fim >= Data início
- ✅ Valores monetários não negativos

---

## 📱 Interface do Sistema

### Navegação Principal

```
┌─────────────────────────────────────────┐
│  TicToc                                  │
│  [Cursos] [Alunos] [Professores]        │
│  [Matrículas] [Avaliações] [Pagamentos] │
└─────────────────────────────────────────┘
```

### Páginas Principais

1. **Cursos** (`/courses`)
   - Lista todos os cursos
   - Mostra professor, valor, período
   - Ações: Ver, Editar, Remover, Novo

2. **Alunos** (`/students`)
   - Lista todos os alunos
   - Mostra email, telefone, status
   - Ações: Ver, Editar, Remover, Novo

3. **Professores** (`/professors`)
   - Lista todos os professores
   - Mostra quantidade de cursos
   - Ações: Ver, Editar, Remover, Novo

4. **Matrículas** (`/enrollments`)
   - Lista todas as matrículas
   - Mostra aluno, curso, data
   - Ações: Ver, Editar, Remover, Novo

5. **Avaliações** (`/evaluations`)
   - Lista todas as avaliações
   - Mostra aluno, curso, nota, data
   - Ações: Ver, Editar, Remover, Novo

6. **Pagamentos** (`/payments`)
   - Lista todos os pagamentos
   - Mostra aluno, curso, débito, crédito
   - Ações: Ver, Editar, Remover, Novo

---

## 🔄 Relacionamentos e Consultas

### Consultas Principais

1. **Cursos de um Professor**
   ```sql
   SELECT * FROM courses WHERE professor_id = ?
   ```

2. **Matrículas de um Aluno**
   ```sql
   SELECT * FROM enrollments WHERE student_id = ?
   ```

3. **Alunos de um Curso**
   ```sql
   SELECT s.* FROM students s
   JOIN enrollments e ON s.id = e.student_id
   WHERE e.course_id = ?
   ```

4. **Avaliações de uma Matrícula**
   ```sql
   SELECT * FROM evaluations WHERE enrollment_id = ?
   ```

5. **Pagamentos de uma Matrícula**
   ```sql
   SELECT * FROM payments WHERE enrollment_id = ?
   ```

6. **Histórico Completo de um Aluno**
   ```sql
   SELECT 
     e.id as matricula_id,
     c.nome as curso,
     e.data_matricula,
     COUNT(DISTINCT ev.id) as num_avaliacoes,
     SUM(p.credito) - SUM(p.debito) as saldo
   FROM enrollments e
   JOIN courses c ON e.course_id = c.id
   LEFT JOIN evaluations ev ON e.id = ev.enrollment_id
   LEFT JOIN payments p ON e.id = p.enrollment_id
   WHERE e.student_id = ?
   GROUP BY e.id, c.nome, e.data_matricula
   ```

---

## 📈 Funcionalidades Futuras (Sugestões)

1. **Relatórios**
   - Relatório de alunos por curso
   - Relatório financeiro (receitas/despesas)
   - Relatório de desempenho (médias de notas)

2. **Dashboard**
   - Estatísticas gerais
   - Gráficos de matrículas
   - Gráficos financeiros

3. **Autenticação**
   - Login de administradores
   - Controle de acesso por perfil

4. **Notificações**
   - Email ao matricular aluno
   - Lembretes de pagamento

5. **Exportação**
   - Exportar dados para Excel/PDF
   - Relatórios em PDF

---

## 🛠️ Tecnologias Utilizadas

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Blade Templates + Tailwind CSS 4.0
- **Banco de Dados**: PostgreSQL (Supabase)
- **Build Tool**: Vite 7.0
- **ORM**: Eloquent (Laravel)

---

## 📝 Conclusão

O sistema foi desenvolvido seguindo as melhores práticas de:
- ✅ Normalização de banco de dados
- ✅ Integridade referencial
- ✅ Validação de dados
- ✅ Arquitetura MVC
- ✅ Design responsivo
- ✅ Código limpo e manutenível

O sistema está pronto para uso e pode ser expandido conforme as necessidades da empresa TIC-TOC Lda.

