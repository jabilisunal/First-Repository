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
        Schema::connection($this->connection)->create('places', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->default(0);
            $table->bigInteger('region_group_id')->default(0);
            $table->bigInteger('destination_id')->default(0);
            $table->string('slug')->unique();
            $table->tinyInteger('sort')->default(0);
            $table->integer('status')->default(0);
            $table->integer('is_popular')->default(0);
            $table->decimal('price')->default(0.0);
            $table->string('booking_url')->nullable();
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
        Schema::connection($this->connection)->dropIfExists('places');
    }
};
