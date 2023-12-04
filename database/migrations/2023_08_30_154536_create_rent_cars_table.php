<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
        Schema::connection($this->connection)->create('rent_cars', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('brand_id')->default(0);
            $table->bigInteger('category_id')->default(0);
            $table->bigInteger('region_group_id')->default(0);
            $table->bigInteger('destination_id')->default(0);
            $table->tinyInteger('sort')->default(0);
            $table->tinyInteger('is_popular')->default(0);
            $table->integer('year')->default(0);
            $table->integer('seats')->default(0);
            $table->enum('engine_type', ['petrol', 'diesel'])->default('petrol');
            $table->integer('status')->default(0);
            $table->string('slug')->unique();
            $table->decimal('daily_price')->default(0.00);
            $table->decimal('weekly_price')->default(0.00);
            $table->decimal('monthly_price')->default(0.00);
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
        Schema::connection($this->connection)->dropIfExists('rent_cars');
    }
};
