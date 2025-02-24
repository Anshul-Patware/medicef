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
        Schema::create('recalls', function (Blueprint $table) {
            $table->id();
            $table->string('rec_no')->nullable();
            $table->string('loca_code')->nullable();
            $table->string('init')->nullable();
            $table->date('date_of_init')->nullable();
            $table->string('assign_to')->nullable();
            $table->date('due_date')->nullable();
            $table->string('depart_group')->nullable();
            $table->string('depart_group_code')->nullable();
            $table->text('short_desc')->nullable();
            $table->string('batch_lot_no')->nullable();
            $table->string('recall_classifi')->nullable();
            $table->date('recall_init_date')->nullable();
            $table->text('reason_for_recall')->nullable();
            $table->text('recall_scope')->nullable();
            
            // form product details -2 
            $table->string('produ_code')->nullable();
            $table->string('acti_phar_ingre')->nullable();
            $table->string('manufac_name')->nullable();
            $table->date('expiry_data')->nullable();
            $table->string('add_group')->nullable();
            $table->json('add_group_detail')->nullable();
            $table->text('packaging_detail')->nullable();
            $table->string('dosage_form')->nullable();
            $table->string('stora_condi')->nullable();
            
            // form affected batch - 3
            $table->string('affected_lot_no')->nullable();
            $table->date('affected_manufacturing_date')->nullable();
            $table->date('affected_expiry_date')->nullable();
            $table->string('quantity_produced')->nullable();
            $table->string('quantity_distri')->nullable();
            $table->string('quantity_recall')->nullable();
            $table->string('distribution_channel')->nullable();
            $table->text('affected_batch_reason')->nullable();
            
            // for ditribution form - 4

            $table->string('distributor_name')->nullable();
            $table->text('distributor_address')->nullable();
            $table->date('shipment_date')->nullable();
            $table->string('delivery_confirm')->nullable();
            $table->string('pharmacy_name')->nullable();
            $table->string('geograp_reason_of_distri')->nullable();

            // for root cause analysis -5

            $table->string('investi_id')->nullable();
            $table->date('detaction_date')->nullable();
            $table->text('root_cause_desc')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('root_quantity_produced')->nullable();
            $table->string('root_quantity_distri')->nullable();
            $table->string('root_quantity_recall')->nullable();
            $table->string('root_distri_channel')->nullable();
            $table->text('root_affected_batch_person')->nullable();        
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
        Schema::dropIfExists('recalls');
    }
};
