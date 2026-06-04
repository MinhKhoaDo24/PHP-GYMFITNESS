<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Foreign keys đã được tạo đúng trong create_conversations và create_messages migrations.
        // Migration này không cần thực hiện gì thêm.
    }

    public function down(): void
    {
        // Nothing to reverse
    }
};
