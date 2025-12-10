# 📊 Modelo de Entidade-Relacionamento (MER) - TIC-TOC Lda

## Diagrama Completo

```
┌─────────────────────────────────────────────────────────────────┐
│                    MODELO DE ENTIDADE-RELACIONAMENTO            │
│                         TIC-TOC Lda                             │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────┐
│    PROFESSORES      │
│ ─────────────────── │
│ PK │ id             │
│    │ nome           │
│    │ telemovel      │
│    │ created_at     │
│    │ updated_at     │
└────┬────────────────┘
     │
     │ 1
     │
     │ possui
     │
     │ N
┌────▼────────────────┐
│      CURSOS         │
│ ──────────────────── │
│ PK │ id             │
│ FK │ professor_id   │──┐
│    │ nome           │  │
│    │ data_inicio    │  │
│    │ data_fim       │  │
│    │ valor          │  │
│    │ created_at     │  │
│    │ updated_at     │  │
└────┬────────────────┘  │
     │                    │
     │ 1                  │
     │                    │
     │ possui            │
     │                    │
     │ N                  │
┌────▼────────────────┐  │
│    MATRÍCULAS       │  │
│ ─────────────────── │  │
│ PK │ id             │  │
│ FK │ student_id     │──┼──┐
│ FK │ course_id      │──┘  │
│    │ data_matricula │     │
│    │ created_at     │     │
│    │ updated_at     │     │
│    │                │     │
│ UK │ (student_id,   │     │
│    │  course_id)    │     │
└────┬────────────────┘     │
     │                       │
     │ 1                     │
     │                       │
     ├─── N ────────────────┼─── N ───┐
     │                       │        │
     │                       │        │
┌────▼──────────────┐  ┌────▼──────┐ │
│   AVALIAÇÕES      │  │ PAGAMENTOS│ │
│ ───────────────── │  │ ────────  │ │
│ PK │ id           │  │ PK │ id   │ │
│ FK │ enrollment_id│──┘ FK │      │ │
│    │ nota         │     │ enrollment│
│    │ data         │     │ _id    │──┘
│    │ created_at   │     │ data_  │
│    │ updated_at   │     │ pagamento│
│    │              │     │ debito │
│    │              │     │ credito │
│    │              │     │ created │
│    │              │     │ updated │
└───────────────────┘     └─────────┘
                                    │
                                    │ N
                                    │
                                    │ pertence
                                    │
                                    │ 1
                          ┌─────────▼─────────┐
                          │      ALUNOS      │
                          │ ──────────────── │
                          │ PK │ id         │
                          │    │ nome       │
                          │    │ telemovel  │
                          │    │ email      │ (UNIQUE)
                          │    │ data_      │
                          │    │ nascimento │
                          │    │ ativo      │
                          │    │ sexo       │
                          │    │ created_at │
                          │    │ updated_at │
                          └──────────────────┘
```

## Legenda

- **PK** = Primary Key (Chave Primária)
- **FK** = Foreign Key (Chave Estrangeira)
- **UK** = Unique Key (Chave Única)
- **1** = Um (lado um do relacionamento)
- **N** = Muitos (lado muitos do relacionamento)

---

## Descrição dos Relacionamentos

### 1. Professor ↔ Cursos (1:N)

**Cardinalidade:** Um para Muitos

- **Um professor** pode lecionar **vários cursos**
- **Um curso** é lecionado por **um único professor**

**Implementação:**
```php
// Model: Professor
public function courses(): HasMany
{
    return $this->hasMany(Course::class, 'professor_id');
}

// Model: Course
public function professor(): BelongsTo
{
    return $this->belongsTo(Professor::class, 'professor_id');
}
```

**Constraint:**
- `courses.professor_id` → `professors.id` (CASCADE ON UPDATE)

---

### 2. Aluno ↔ Matrículas (1:N)

**Cardinalidade:** Um para Muitos

- **Um aluno** pode ter **várias matrículas**
- **Uma matrícula** pertence a **um único aluno**

**Implementação:**
```php
// Model: Student
public function enrollments(): HasMany
{
    return $this->hasMany(Enrollment::class, 'student_id');
}

// Model: Enrollment
public function student(): BelongsTo
{
    return $this->belongsTo(Student::class, 'student_id');
}
```

**Constraint:**
- `enrollments.student_id` → `students.id` (CASCADE ON UPDATE)

---

### 3. Curso ↔ Matrículas (1:N)

**Cardinalidade:** Um para Muitos

- **Um curso** pode ter **várias matrículas**
- **Uma matrícula** é para **um único curso**

**Implementação:**
```php
// Model: Course
public function enrollments(): HasMany
{
    return $this->hasMany(Enrollment::class, 'course_id');
}

// Model: Enrollment
public function course(): BelongsTo
{
    return $this->belongsTo(Course::class, 'course_id');
}
```

**Constraint:**
- `enrollments.course_id` → `courses.id` (CASCADE ON UPDATE)
- **UNIQUE(student_id, course_id)** - Evita matrícula duplicada

---

### 4. Matrícula ↔ Avaliações (1:N)

**Cardinalidade:** Um para Muitos

- **Uma matrícula** pode ter **várias avaliações**
- **Uma avaliação** pertence a **uma única matrícula**

**Implementação:**
```php
// Model: Enrollment
public function evaluations(): HasMany
{
    return $this->hasMany(Evaluation::class, 'enrollment_id');
}

// Model: Evaluation
public function enrollment(): BelongsTo
{
    return $this->belongsTo(Enrollment::class, 'enrollment_id');
}
```

**Constraint:**
- `evaluations.enrollment_id` → `enrollments.id`
- **CASCADE ON DELETE** - Remove avaliações se matrícula for removida

---

### 5. Matrícula ↔ Pagamentos (1:N)

**Cardinalidade:** Um para Muitos

- **Uma matrícula** pode ter **vários pagamentos**
- **Um pagamento** pertence a **uma única matrícula**

**Implementação:**
```php
// Model: Enrollment
public function payments(): HasMany
{
    return $this->hasMany(Payment::class, 'enrollment_id');
}

// Model: Payment
public function enrollment(): BelongsTo
{
    return $this->belongsTo(Enrollment::class, 'enrollment_id');
}
```

**Constraint:**
- `payments.enrollment_id` → `enrollments.id`
- **CASCADE ON DELETE** - Remove pagamentos se matrícula for removida

---

## Tabela de Atributos Detalhada

### PROFESSORES
| Atributo | Tipo | Tamanho | Obrigatório | Descrição |
|----------|------|---------|-------------|-----------|
| id | BIGINT | - | Sim (PK) | Identificador único |
| nome | VARCHAR | 150 | Sim | Nome completo |
| telemovel | VARCHAR | 30 | Não | Telefone de contato |
| created_at | TIMESTAMP | - | Sim | Data de criação |
| updated_at | TIMESTAMP | - | Sim | Data de atualização |

### CURSOS
| Atributo | Tipo | Tamanho | Obrigatório | Descrição |
|----------|------|---------|-------------|-----------|
| id | BIGINT | - | Sim (PK) | Identificador único |
| nome | VARCHAR | 150 | Sim | Nome do curso |
| data_inicio | DATE | - | Não | Data de início |
| data_fim | DATE | - | Não | Data de término |
| professor_id | BIGINT | - | Sim (FK) | Referência ao professor |
| valor | DECIMAL | 12,2 | Sim | Valor do curso |
| created_at | TIMESTAMP | - | Sim | Data de criação |
| updated_at | TIMESTAMP | - | Sim | Data de atualização |

**Regra de Negócio:** `data_fim >= data_inicio`

### ALUNOS
| Atributo | Tipo | Tamanho | Obrigatório | Descrição |
|----------|------|---------|-------------|-----------|
| id | BIGINT | - | Sim (PK) | Identificador único |
| nome | VARCHAR | 150 | Sim | Nome completo |
| telemovel | VARCHAR | 30 | Não | Telefone de contato |
| email | VARCHAR | 160 | Sim (UNIQUE) | Email (único) |
| data_nascimento | DATE | - | Não | Data de nascimento |
| ativo | BOOLEAN | - | Sim | Status ativo/inativo |
| sexo | ENUM | M/F/O | Não | Gênero |
| created_at | TIMESTAMP | - | Sim | Data de criação |
| updated_at | TIMESTAMP | - | Sim | Data de atualização |

**Regra de Negócio:** Email deve ser único

### MATRÍCULAS
| Atributo | Tipo | Tamanho | Obrigatório | Descrição |
|----------|------|---------|-------------|-----------|
| id | BIGINT | - | Sim (PK) | Identificador único |
| student_id | BIGINT | - | Sim (FK) | Referência ao aluno |
| course_id | BIGINT | - | Sim (FK) | Referência ao curso |
| data_matricula | DATE | - | Sim | Data da matrícula |
| created_at | TIMESTAMP | - | Sim | Data de criação |
| updated_at | TIMESTAMP | - | Sim | Data de atualização |

**Constraint:** UNIQUE(student_id, course_id) - Evita matrícula duplicada

### AVALIAÇÕES
| Atributo | Tipo | Tamanho | Obrigatório | Descrição |
|----------|------|---------|-------------|-----------|
| id | BIGINT | - | Sim (PK) | Identificador único |
| enrollment_id | BIGINT | - | Sim (FK) | Referência à matrícula |
| nota | DECIMAL | 5,2 | Não | Nota (0-20) |
| data | DATE | - | Sim | Data da avaliação |
| created_at | TIMESTAMP | - | Sim | Data de criação |
| updated_at | TIMESTAMP | - | Sim | Data de atualização |

**Regra de Negócio:** `0 <= nota <= 20`

### PAGAMENTOS
| Atributo | Tipo | Tamanho | Obrigatório | Descrição |
|----------|------|---------|-------------|-----------|
| id | BIGINT | - | Sim (PK) | Identificador único |
| enrollment_id | BIGINT | - | Sim (FK) | Referência à matrícula |
| data_pagamento | DATE | - | Sim | Data do pagamento |
| debito | DECIMAL | 12,2 | Sim | Valor devido |
| credito | DECIMAL | 12,2 | Sim | Valor pago |
| created_at | TIMESTAMP | - | Sim | Data de criação |
| updated_at | TIMESTAMP | - | Sim | Data de atualização |

**Regra de Negócio:** Pelo menos um valor (débito ou crédito) deve ser preenchido

---

## Normalização

### 1ª Forma Normal (1FN) ✅
- Todos os campos são atômicos (não compostos)
- Não há grupos repetitivos

### 2ª Forma Normal (2FN) ✅
- Todos os atributos não-chave dependem completamente da chave primária
- Não há dependências parciais

### 3ª Forma Normal (3FN) ✅
- Não há dependências transitivas
- Todos os atributos não-chave dependem apenas da chave primária

---

## Integridade Referencial

### Foreign Keys com CASCADE

1. **courses.professor_id**
   - CASCADE ON UPDATE
   - Se professor for atualizado, cursos são atualizados

2. **enrollments.student_id**
   - CASCADE ON UPDATE
   - Se aluno for atualizado, matrículas são atualizadas

3. **enrollments.course_id**
   - CASCADE ON UPDATE
   - Se curso for atualizado, matrículas são atualizadas

4. **evaluations.enrollment_id**
   - CASCADE ON UPDATE
   - CASCADE ON DELETE
   - Se matrícula for removida, avaliações são removidas

5. **payments.enrollment_id**
   - CASCADE ON UPDATE
   - CASCADE ON DELETE
   - Se matrícula for removida, pagamentos são removidos

---

## Índices

### Índices Criados Automaticamente

1. **Primary Keys** - Todas as tabelas têm índice na PK
2. **Foreign Keys** - Índices automáticos nas FKs
3. **Unique Constraints** - Índices únicos:
   - `students.email` (UNIQUE)
   - `enrollments(student_id, course_id)` (UNIQUE)

### Índices Recomendados (Futuro)

- `students.ativo` - Para filtrar alunos ativos rapidamente
- `courses.data_inicio` - Para consultas por período
- `enrollments.data_matricula` - Para relatórios temporais
- `evaluations.data` - Para histórico de avaliações
- `payments.data_pagamento` - Para relatórios financeiros

---

Este modelo garante integridade, normalização e eficiência na gestão dos dados do centro de formação TIC-TOC Lda.

