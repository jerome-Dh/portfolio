<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIllustrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('illustrations', function (Blueprint $table) {
            $table->id();
            $table->string('image', 255)->nullable(true);
            $table->unsignedBigInteger('experience_id');

            $table->foreign('experience_id')
                ->references('id')
                ->on('experiences')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->unsignedBigInteger('author_id')->nullable(true);
            $table->foreign('author_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('SET NULL');

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
        Schema::table('illustrations', function (Blueprint $table){
            $table->dropForeign(['experience_id', 'author_id']);
        });
        Schema::dropIfExists('illustrations');
    }
}
