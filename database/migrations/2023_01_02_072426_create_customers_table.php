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
        Schema::connection($this->connection)->create('customers', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['customer', 'supplier'])
                ->default('customer');
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('company_name')->nullable();
            $table->string('tax_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('locale');
            $table->string('timezone');
            $table->string('country_code');
            $table->rememberToken()->nullable();
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::connection($this->connection)->dropIfExists('customers');
    }
};
