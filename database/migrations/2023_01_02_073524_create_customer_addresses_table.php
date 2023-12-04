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
        Schema::connection($this->connection)->create('customer_addresses', static function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->nullable();
            $table->string('address_title');
            $table->string('country_code');
            $table->string('name');
            $table->string('surname');
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->string('city');
            $table->string('phone');
            $table->string('email');
            $table->string('post_code');
            $table->string('address');
            $table->string('lat');
            $table->string('lng');
            $table->string('zoom');
            $table->tinyInteger('is_default')->default(0);
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
        Schema::connection($this->connection)->dropIfExists('customer_addresses');
    }
};
