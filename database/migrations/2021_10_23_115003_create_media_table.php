<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');
            $table->string('mime_type');
            $table->unsignedInteger('filesize');
            $table->unsignedSmallInteger('width');
            $table->unsignedSmallInteger('height');
            $table->string('group_slug', 50)->nullable();
            $table->timestamps();

            $table->foreign('group_slug')->references('slug')->on('media_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
