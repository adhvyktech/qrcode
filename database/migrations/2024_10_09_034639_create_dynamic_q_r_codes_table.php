<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDynamicQRCodesTable extends Migration
{
    public function up()
    {
        Schema::create('dynamic_q_r_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('description');
            $table->string('key')->unique();
            $table->string('redirect_url');
            $table->dateTime('active_from')->nullable();
            $table->dateTime('active_to')->nullable();
            $table->json('style')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dynamic_q_r_codes');
    }
}