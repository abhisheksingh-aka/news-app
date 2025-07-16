<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('source_id', 50)->nullable();
            $table->string('source_name', 100)->nullable();
            $table->string('author')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->text('url')->nullable();
            $table->text('url_image')->nullable();
            $table->enum('status', ['Enabled', 'Disabled'])->default('Enabled');
            $table->unsignedBigInteger('client_user_id')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
