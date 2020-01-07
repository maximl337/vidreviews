<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->integer('reviewer_id')->unsigned();
            $table->string('video_url')->comment = "Video url";
            $table->string('thumbnail')->nullable()->comment = "Video thumbnail";

            $table->string('token')->nullable()->comment = "Token received from Ziggeo";

            $table->dateTime('approved_at')->nullable();
            $table->dateTime('seen_at')->nullable();

            $table->timestamps();
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('reviewer_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
