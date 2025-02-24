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
        Schema::create('recall_grids', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('recallprocess_id')->nullable();
            $table->string('type')->nullable();
            $table->longText('equipment_name')->nullable();
            $table->longText('equipment_id')->nullable();
            $table->longText('equipment_remark')->nullable();
            $table->longText('equipment_comments')->nullable();
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
        Schema::dropIfExists('recall_grids');
    }
};
