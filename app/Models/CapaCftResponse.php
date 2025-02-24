<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CapaCftResponse extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'capa_cft_responses';
}
