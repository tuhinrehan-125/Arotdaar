<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('arot_commission')->nullable();
            $table->string('bazar_commission')->nullable();
            $table->string('arot_image')->nullable();
            $table->string('arot_name')->nullable();
            $table->string('arot_address')->nullable();
            $table->string('arot_phone')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
