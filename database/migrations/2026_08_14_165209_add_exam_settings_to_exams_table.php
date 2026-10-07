<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exams', function (Blueprint $table) {

            $table->boolean('negative_marking')
                ->default(false)
                ->after('status');

            $table->decimal('negative_marks', 4, 2)
                ->default(0)
                ->after('negative_marking');

            $table->unsignedInteger('time_per_question')
                ->default(75)
                ->after('negative_marks');

        });
    }

    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {

            $table->dropColumn([
                'negative_marking',
                'negative_marks',
                'time_per_question',
            ]);

        });
    }
};