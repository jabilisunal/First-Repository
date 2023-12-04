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
        Schema::connection($this->connection)->create('menu_translations', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->unsigned()
                ->references('id')
                ->on('menus')
                ->onDelete('cascade');

            $table->string('locale')->index();
            $table->string('title')->nullable()->default(null);
            $table->string('url')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('menu_translations');
    }
};
