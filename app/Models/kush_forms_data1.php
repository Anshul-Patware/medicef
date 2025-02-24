<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kush_forms_data1 extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'depart',
        'course',
        'rollno',
        'contact',
        'branch',
        'category',
        'profile_pics',
        'company_name',
        'join_date',
        'job_type',
        'experience',
        'skill',
        'attachment',
    ];
}
