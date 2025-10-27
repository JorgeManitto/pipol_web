<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // quien crea el ticket
            $table->foreignId('session_id')->nullable()->constrained('pipol_sessions')->onDelete('set null'); // opcional: sesión asociada

            // Tipo de ticket
            $table->enum('type', [
                'payment_issue',      // problema con pago
                'session_dispute',    // disputa entre mentor/mentee
                'technical_issue',    // error técnico
                'feedback',           // sugerencia o comentario
                'admin_notification'  // generado por el sistema
            ])->default('feedback');

            // Contenido
            $table->string('subject');
            $table->text('message');
            $table->string('attachment')->nullable(); // archivo opcional

            // Estado
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])
                ->default('open');
            $table->foreignId('assigned_admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('resolved_at')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
