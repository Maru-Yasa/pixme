<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_comments', function (Blueprint $table) {
            $table->Bigincrements('id');
            $table->bigInteger('owner')->unsigned();
            $table->bigInteger('parent_comment')->unsigned();
            $table->string('comment')->default(null);
            $table->timestamps();

            $table->foreign('parent_comment')->references('id')->on('comments')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('owner')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_comments');
    }
}
