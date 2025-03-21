<?php

use App\Enums\TaskStatus;
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
        Schema::create('tasks', static function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('status', array_column(TaskStatus::cases(), 'value'))->default(TaskStatus::Pending->value);
            $table->foreignId('owner_id')->constrained(
                table: 'users', indexName: 'tasks_owner_id_foreign'
            );
            $table->foreignId('assigned_to')->nullable()->constrained(
                table: 'users', indexName: 'tasks_assigned_to_foreign'
            );
            $table->date('due_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
