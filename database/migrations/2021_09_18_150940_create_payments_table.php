<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
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
        Schema::connection($this->connection)->create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->index();
            $table->integer('customer_id')->index();
            $table->integer('payment_system_id')->index();
            $table->string('pan')->nullable();
            $table->string('card_type')->nullable();
            $table->decimal('amount')->default(0);
            $table->integer('currency_id')->default(9);
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
        Schema::connection($this->connection)->dropIfExists('payments');
    }
}
