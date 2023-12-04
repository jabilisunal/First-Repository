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
        Schema::connection($this->connection)->create('tour_translations', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->unsigned()
                ->references('id')
                ->on('tours')
                ->onDelete('cascade');

            $table->string('locale')->index();
            $table->string('title')->nullable()->default(null);
            $table->longText('why_choose_us')->nullable()->default(null);
            $table->longText('description')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('tour_translations');
    }
};
