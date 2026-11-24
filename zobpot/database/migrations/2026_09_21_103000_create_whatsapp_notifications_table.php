<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whatsapp_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('candidate_id');
            $table->string('phone_number', 20)->nullable();
            $table->string('template_name', 100)->default('info_1');
            $table->string('notification_type', 50)->default('new_job_alert');
            $table->string('status', 30)->default('pending'); // pending|sent|failed|skipped
            $table->text('api_response')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->unique(
                ['job_id', 'candidate_id', 'notification_type'],
                'whatsapp_notif_job_candidate_type_unique'
            );

            $table->index('job_id');
            $table->index('candidate_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('whatsapp_notifications');
    }
};
