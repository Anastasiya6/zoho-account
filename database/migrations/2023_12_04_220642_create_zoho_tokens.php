<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZohoTokens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zoho_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('client_id');
            $table->string('client_secret');
            $table->string('access_token');
            $table->string('refresh_token');
            $table->timeStamp('create_date_token');
            $table->boolean('flag')->default(false);

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
        Schema::dropIfExists('zoho_tokens');
    }
}
