<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('orders', static function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->index()->nullable();
            $table->bigInteger('shipping_method_id')->index()->nullable();
            $table->bigInteger('payment_method_id')->index()->nullable();
            $table->bigInteger('payment_system_id')->index()->nullable();
            $table->string('country_code');
            $table->string('name');
            $table->string('surname');
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->string('city');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('post_code')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('is_pay')->default(0);
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
        Schema::connection($this->connection)->dropIfExists('orders');
    }
};
