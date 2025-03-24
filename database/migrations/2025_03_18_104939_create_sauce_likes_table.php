<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSauceLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sauce_likes', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('sauceId')->constrained('sauces','sauceId')->onDelete('cascade');
            $table->foreignId('userId')->constrained('users','userId')->onDelete('cascade');
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
        Schema::dropIfExists('sauce_likes');
    }
}
