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
        Schema::connection($this->connection)->create('entity_files', static function (Blueprint $table) {
            $table->id();
            $table->integer('file_id')->index();
            $table->string('entity_type')->nullable();
            $table->integer('entity_id')->index();
            $table->string('zone')->nullable();
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
        Schema::connection($this->connection)->dropIfExists('entity_files');
    }
};
