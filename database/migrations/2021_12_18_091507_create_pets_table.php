<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('types');
            $table->unsignedBigInteger('breed_id');
            $table->foreign('breed_id')->references('id')->on('breeds');
            $table->string('name');
            $table->string('gender');
            $table->json('images');
            $table->date('birthday');
            $table->integer('weight')->nullable();
            $table->integer('height')->nullable();
            $table->float('price', 8, 2)->nullable();
            $table->longText('description')->nullable();
            $table->string('status'); //   available or for sale // reserved //  adopted  // for breeding  ,
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('pets');
    }
}
