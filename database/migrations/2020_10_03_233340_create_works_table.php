<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('works', function (Blueprint $table) {
            $table->id();

            $table->string('name_en', 100)->unique();
            $table->string('name_fr', 100)->unique();
            $table->string('title_en', 100)->nullable(true);
            $table->string('title_fr', 100)->nullable(true);
            $table->string('description_en', 255)->nullable(true);
            $table->string('description_fr', 255)->nullable(true);
            $table->string('image', 255)->nullable(true);
            $table->string('source', 255)->nullable(true);

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
        Schema::table('works', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
        });
        Schema::dropIfExists('works');
    }
}
