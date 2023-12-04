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
        Schema::connection($this->connection)->create('banners', static function (Blueprint $table) {
            $table->id();
            $table->integer('type_id')->default(0)->index();
            $table->enum('position', ['left', 'center', 'right'])
                ->default('center');
            $table->tinyInteger('status')->default(0);
            $table->integer('sort')->default(0);
            $table->string('effect')->nullable();
            $table->string('duration')->nullable();
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
        Schema::connection($this->connection)->dropIfExists('banners');
    }
};
