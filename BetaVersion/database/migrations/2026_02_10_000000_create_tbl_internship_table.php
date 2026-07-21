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
        Schema::create('tbl_internship', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('internship_type')->comment('1: With College, 2: Individually');
            $table->string('internship_title');
            $table->string('category')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('company_website')->nullable();
            $table->string('mode')->nullable();
            $table->string('location')->nullable();
            $table->decimal('stipend', 10, 2)->nullable();
            $table->integer('openings')->nullable();
            $table->string('duration')->nullable();
            $table->integer('total_weeks')->nullable();
            $table->integer('total_hours')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('application_deadline')->nullable();
            $table->json('batch_days')->nullable()->comment('Store data in format: [["monday":{"09:00","10:00"}],[]]');
            $table->text('skills')->nullable();
            $table->text('eligibility_criteria')->nullable();
            $table->text('internship_description')->nullable();
            $table->text('module_brief_description')->nullable();
            $table->text('internship_objective')->nullable();
            $table->text('internship_outcome')->nullable();
            $table->decimal('registration_fees', 10, 2)->nullable();
            $table->decimal('gst_percentage', 5, 2)->nullable();
            $table->decimal('gst_amount', 10, 2)->nullable();
            $table->decimal('final_amount', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_internship');
    }
};
