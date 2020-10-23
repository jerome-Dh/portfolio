<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperienceTechnologieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experience_technologie', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('experience_id');
            $table->unsignedBigInteger('technologie_id');

            $table->foreign('experience_id')
                ->references('id')
                ->on('experiences')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('technologie_id')
                ->references('id')
                ->on('technologies')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

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
        Schema::table('experience_technologie', function (Blueprint $table){
            $table->dropForeign(['experience_id', 'technologie_id']);
        });

        Schema::dropIfExists('experience_technologie');
    }
}
