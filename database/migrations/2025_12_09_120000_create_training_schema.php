<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('professors')) {
            Schema::create('professors', function (Blueprint $table) {
            $table->id(); // idProfessor
            $table->string('nome', 150);
            $table->string('telemovel', 30)->nullable();
            $table->timestamps();
            });
        }

        if (!Schema::hasTable('courses')) {
            Schema::create('courses', function (Blueprint $table) {
            $table->id(); // idCurso
            $table->string('nome', 150);
            $table->date('data_inicio')->nullable();
            $table->date('data_fim')->nullable();
            $table->foreignId('professor_id')->constrained('professors')->cascadeOnUpdate();
            $table->decimal('valor', 12, 2)->default(0);
            $table->timestamps();
            });
        }

        if (!Schema::hasTable('students')) {
            Schema::create('students', function (Blueprint $table) {
            $table->id(); // idAluno
            $table->string('nome', 150);
            $table->string('telemovel', 30)->nullable();
            $table->string('email', 160)->unique();
            $table->date('data_nascimento')->nullable();
            $table->boolean('ativo')->default(true);
            $table->enum('sexo', ['M', 'F', 'O'])->nullable();
            $table->timestamps();
            });
        }

        if (!Schema::hasTable('enrollments')) {
            Schema::create('enrollments', function (Blueprint $table) {
            $table->id(); // idMatricula
            $table->foreignId('student_id')->constrained('students')->cascadeOnUpdate();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnUpdate();
            $table->date('data_matricula')->useCurrent();
            $table->timestamps();
            $table->unique(['student_id', 'course_id']);
            });
        }

        if (!Schema::hasTable('evaluations')) {
            Schema::create('evaluations', function (Blueprint $table) {
            $table->id(); // idAvaliacao
            $table->foreignId('enrollment_id')->constrained('enrollments')->cascadeOnUpdate()->cascadeOnDelete();
            $table->decimal('nota', 5, 2)->nullable();
            $table->date('data')->useCurrent();
            $table->timestamps();
            });
        }

        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
            $table->id(); // idPagamento
            $table->foreignId('enrollment_id')->constrained('enrollments')->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('data_pagamento')->useCurrent();
            $table->decimal('debito', 12, 2)->default(0);
            $table->decimal('credito', 12, 2)->default(0);
            $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('evaluations');
        Schema::dropIfExists('enrollments');
        Schema::dropIfExists('students');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('professors');
    }
};

