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
        Schema::connection($this->connection)->create('addresses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('model_id')->index()->default(0);
            $table->string('model_type')->nullable();
            $table->tinyInteger('sort')->default(0);
            $table->integer('status')->default(0);
            $table->string('name')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('zoom')->nullable();
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
        Schema::connection($this->connection)->dropIfExists('addresses');
    }
};
