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
        Schema::create('expenses', function (Blueprint $table) {
            // ID personalizado según tu diagrama
            $table->id('expense_id');

            // Cantidad retirada (mismo formato que royalties)
            $table->decimal('amount', 13, 2);

            // Estado del retiro (ej: 'pagado', 'procesando', 'rechazado')
            $table->string('state')->default('pagado');

            // Fecha exacta del retiro (según tu diagrama 'at')
            $table->timestamp('at')->useCurrent();

            // IMPORTANTE: ¿Quién retiró el dinero?
            // Relacionamos esto con la tabla users
            $table->foreignUuid('user_id')->constrained('users', 'user_id');

            $table->timestamps(); // created_at y updated_at (opcional, pero recomendado)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
