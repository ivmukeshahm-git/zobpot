<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblInternshipPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_internship_payment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_id')->nullable()->comment('Reference to internship application');
            $table->unsignedBigInteger('user_id')->nullable()->comment('Paid by user id');
            $table->unsignedBigInteger('internship_id')->nullable()->comment('Reference to internship');

            $table->decimal('gst_percentage', 5, 2)->nullable()->comment('GST percentage applied');
            $table->decimal('gst_amount', 10, 2)->nullable()->comment('GST amount value');
            $table->decimal('total_amount', 12, 2)->nullable()->comment('Final total amount charged');

            $table->string('payment_mode', 50)->nullable()->comment('e.g., Razorpay, Stripe, Paytm, local');
            $table->string('transaction_id', 150)->nullable()->comment('Gateway transaction id or local generated payment id');

            $table->tinyInteger('payment_status')->default(0)->comment('Application status Pending:0, Success:1, Failed:2, Refunded:3');

            $table->timestamp('paid_on')->nullable()->comment('Datetime when payment was made');
            $table->json('payment_response_data')->nullable()->comment('Raw gateway response JSON');
            $table->string('payment_transaction_id', 150)->nullable()->comment('Local payment transaction id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_internship_payment');
    }
}
