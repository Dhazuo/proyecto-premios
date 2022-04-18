<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('email')->unique()->nullable(false);
            $table->string('participation')->unique()->nullable();
            $table->enum('status', ['allowed', 'not_allowed'])->default('not_allowed');
            $table->enum('award_type', ['PREMIO_FÍSICO', 'CÓDIGO'])->nullable();
            $table->string('award')->nullable();
            $table->string('code')->nullable();
            $table->string('ip_address', 45)->unique()->nullable();



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participants');
    }
};
