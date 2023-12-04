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
        Schema::connection($this->connection)->create('menus', static function (Blueprint $table) {
            $table->id();
            $table->integer('menu_type_id')->index();
            $table->integer('parent_id')->nullable()->default(null);
            $table->string('slug')->unique();
            $table->tinyInteger('status')->default(0);
            $table->integer('sort')->default(0);
            $table->enum('style', ['none', 'dropdown', 'megaMenu'])
                ->default('dropdown');
            $table->tinyInteger('target_blank')->default(0);
            $table->tinyInteger('is_new')->default(0);
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
        Schema::connection($this->connection)->dropIfExists('menus');
    }
};
