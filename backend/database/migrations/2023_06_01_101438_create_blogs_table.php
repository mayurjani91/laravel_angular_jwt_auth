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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->smallInteger("user_id")->nullable();
            $table->foreign('user_id')
              ->references('id')->on('users')->onDelete('cascade');
            $table->string("title", 255)->nullable();
            $table->string("description", 500)->nullable();
            $table->text("image", 500)->nullable();
            $table->enum("status", ["Active", "Inactive", "Deleted"])->default('Active')->nullable();
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
        Schema::dropIfExists('blogs');
    }
};
