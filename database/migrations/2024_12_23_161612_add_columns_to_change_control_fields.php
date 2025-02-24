<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('change_control_fields', function (Blueprint $table) {
            $table->text('similarChangeControlRequired')->nullable();
            $table->longText('similarChangeControl')->nullable();
            $table->longText('changeControlNature')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('change_control_fields', function (Blueprint $table) {
            //
        });
    }
};
