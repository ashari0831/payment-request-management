<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('description')->nullable();
            $table->unsignedInteger('price');
            $table->string('sheba_number', 24);
            $table->unsignedInteger('status');
            $table->json('comments')->nullable();

            $table->foreignUuid('payment_category_id')
                ->constrained('payment_categories')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignUuid('file_id')
                ->constrained('files')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignUuid('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_requests');
    }
};
