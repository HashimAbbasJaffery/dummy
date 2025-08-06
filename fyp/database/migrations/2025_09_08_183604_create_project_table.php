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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId("company_id")->nullable()->constrained("companies")->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->text('skills'); // Comma-separated values like "Laravel, Vue.js, MySQL"
            $table->float("threshold")->default("0.75");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project');
    }
};
