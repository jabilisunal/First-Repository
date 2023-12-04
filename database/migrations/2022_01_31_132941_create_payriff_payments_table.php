<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayriffPaymentsTable extends Migration
{
    /**
     * @var string $connection
     */
    protected $connection = 'mysql';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::connection($this->connection)
            ->create('payriff_payments', function (Blueprint $table) {
                $table->id();
                $table->integer('customer_id')->index();
                $table->integer('payment_system_id')->index();
                $table->integer('order_id')->index();
                $table->integer('orderId')->nullable()->default(0);
                $table->string('session_id')->nullable()->default(NULL);
                $table->string('payriff_transaction_id')->nullable()->default(NULL);
                $table->string('transaction_type')->nullable()->default(NULL);
                $table->integer('purchase_amount')->nullable()->default(0);
                $table->integer('currency')->nullable()->default(0);
                $table->string('tran_date_time')->nullable()->default(NULL);
                $table->string('response_code')->nullable()->default(NULL);
                $table->string('response_description')->nullable()->default(NULL);
                $table->string('brand')->nullable()->default(NULL);
                $table->string('order_status')->nullable()->default(NULL);
                $table->string('approval_code')->nullable()->default(NULL);
                $table->string('acq_fee')->nullable()->default(NULL);
                $table->string('order_description')->nullable()->default(NULL);
                $table->string('approval_code_scr')->nullable()->default(NULL);
                $table->string('purchase_amount_scr')->nullable()->default(NULL);
                $table->string('currency_scr')->nullable()->default(NULL);
                $table->string('order_status_scr')->nullable()->default(NULL);
                $table->string('card_registration_response')->nullable()->default(NULL);
                $table->string('rrn')->nullable()->default(NULL);
                $table->string('pan')->nullable()->default(NULL);
                $table->string('card_holder_name')->nullable()->default(NULL);
                $table->string('card_uid')->nullable()->default(NULL);
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();
                $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('payriff_payments');
    }
}
