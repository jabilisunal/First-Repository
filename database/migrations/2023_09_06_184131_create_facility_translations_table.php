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
        Schema::connection($this->connection)->create('facility_translations', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('facility_id')->unsigned()
                ->references('id')
                ->on('facilities')
                ->onDelete('cascade');

            $table->string('locale')->index();
            $table->string('name')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('facility_translations');
    }
};
