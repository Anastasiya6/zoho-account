<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataToZohoTokens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('zoho_tokens', function (Blueprint $table) {

        });
        DB::table('zoho_tokens')
            ->insert([
                [
                    'client_id' => '1000.HN58OS087VJ1177Y5WPEY5DZJHD6YZ',
                    'client_secret' => '9521dc370c394eb9c2b119257455909b24abf193c6',
                    'access_token' => '1000.1bac2c182c1d2d170c766d896e547c1c.d6854a31afc366159d2ae64b562daacb',
                    'refresh_token' => '1000.8e1b8c1e8e36ff7edeb8a4d1aaab44eb.1ce97e687332968794d372cefc94e16a',
                    'create_date_token' => now()
                ],
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('zoho_tokens', function (Blueprint $table) {
            //
        });
    }
}
