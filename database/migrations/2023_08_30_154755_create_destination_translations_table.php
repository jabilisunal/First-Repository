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
        Schema::connection($this->connection)->create('destination_translations', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')->unsigned()
                ->references('id')
                ->on('destinations')
                ->onDelete('cascade');

            $table->string('locale')->index();
            $table->string('name')->nullable()->default(null);
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
        Schema::connection($this->connection)->dropIfExists('destination_translations');
    }
};
