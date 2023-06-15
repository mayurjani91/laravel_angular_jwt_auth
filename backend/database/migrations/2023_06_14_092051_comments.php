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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->smallInteger("user_id")->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')->onDelete('cascade');
            $table->smallInteger("blog_id")->nullable();
            $table->foreign('blog_id')
                ->references('id')->on('blogs')->onDelete('cascade');
            $table->string('comment')->nullable();
            $table->string('parent_id')->default(0);
            $table->enum("status", ["Active", "Inactive", "Deleted"])->default('Active')->nullable();
            $table->timestamps(); //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');

    }
};
