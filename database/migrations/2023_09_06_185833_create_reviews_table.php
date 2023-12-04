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
        Schema::connection($this->connection)->create('reviews', static function (Blueprint $table) {
            $table->id();
            $table->bigInteger('model_id')->nullable();
            $table->string('model_type')->nullable();
            $table->integer('rating')->default(1);
            $table->string('full_name');
            $table->string('email');
            $table->longText('message')->nullable();
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
        Schema::connection($this->connection)->dropIfExists('reviews');
    }
};
