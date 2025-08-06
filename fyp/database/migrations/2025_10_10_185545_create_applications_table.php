<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            // Foreign key to jobs table
            $table->foreignId('job_id')->constrained("projects")->onDelete('cascade');

            $table->string('name');
            $table->string('email');

            // Paths to uploaded files
            $table->string('resume_path');
            $table->string('education_file_path');

            $table->text('cover_letter')->nullable();

            
            // New classification fields
            $table->string('classification_label')->nullable();
            $table->decimal('classification_score', 5, 3)->nullable(); // e.g., 0.000 to 9.999
         

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
