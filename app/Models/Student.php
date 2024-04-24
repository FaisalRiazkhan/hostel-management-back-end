<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'national_id_no', 'email', 'contact_no', 'nationality', 'religion', 'gender', 'permanent_address', 
        'district', 'province', 'current_address', 'current_district', 'current_province', 'guardian_name', 'guardian_id_no',
        'guardian_contact_no', 'guardian_occupation',
    ];
}
