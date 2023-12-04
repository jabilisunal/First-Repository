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
        Schema::connection($this->connection)->create('category_translations', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->unsigned()
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');

            $table->string('locale')->index();
            $table->string('title')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('category_translations');
    }
};
