<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\Fill;

class Recall extends Model
{
    use HasFactory;
    protected $fillable = [
        'rec_no',
        'loca_code',
        'init',
        'date_of_init',
        'assign_to',
        'due_date',
        'depart_group',
        'depart_group_code',
        'short_desc',
        'batch_lot_no',
        'recall_classifi',
        'recall_init_date',
        'reason_for_recall',
        'recall_scope',

        
        'produ_code',
        'acti_phar_ingre',
        'manufac_name',
        'expiry_data',
        'add_group',
        'add_group_detail',
        'packaging_detail',
        'dosage_form',
        'stora_condi',
        'affected_lot_no',
        'affected_manufacturing_date',
        'affected_expiry_date',
        'quantity_produced',
        'quantity_distri',
        'quantity_recall',
        'distribution_channel',
        'affected_batch_reason',
        'distributor_name',
        'distributor_address',
        'shipment_date',
        'delivery_confirm',
        'pharmacy_name',
        'geograp_reason_of_distri',
        'investi_id',
        'detaction_date',
        'root_cause_desc',
        'expiry_date',
        'root_quantity_produced',
        'root_quantity_distri',
        'root_quantity_recall',
        'root_distri_channel',
        'root_affected_batch_person',
    ];
}
