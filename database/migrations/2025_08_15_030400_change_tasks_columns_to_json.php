<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE tasks ALTER COLUMN sub_tasks TYPE jsonb USING array_to_json(sub_tasks)::jsonb');
        DB::statement('ALTER TABLE tasks ALTER COLUMN attachments TYPE jsonb USING array_to_json(attachments)::jsonb');
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->text('sub_tasks')->nullable()->change();
            $table->text('attachments')->nullable()->change();
        });
    }
};