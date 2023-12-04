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
        Schema::connection($this->connection)->create('banner_translations', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('banner_id')->unsigned()
                ->references('id')
                ->on('banners')
                ->onDelete('cascade');

            $table->string('locale')->index();
            $table->string('title')->nullable()->default(null);
            $table->longText('description')->nullable()->default(null);
            $table->string('button_title')->nullable()->default(null);
            $table->string('button_url')->nullable()->default(null);
            $table->string('button_icon')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('banner_translations');
    }
};
