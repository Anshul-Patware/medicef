<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RootCaseAnalysisCftResponse extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $table = 'rootcase_analysis_cft_responses';
}
